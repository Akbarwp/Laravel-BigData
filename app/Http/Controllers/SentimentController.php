<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sentiment;
use App\Models\Preprocessing;

class SentimentController extends Controller
{
    private $sentiment;

    public function __construct()
    {
        require_once app_path('/Library/PHPInsight/Autoloader.php');
        \PHPInsight\Autoloader::register();
        $this->sentiment = new \PHPInsight\Sentiment();
    }

    public function sentimen()
    {
        $judul = "Dashboard";
        $teks = "Jalanan ke malino rusak berat, pemerintah perbaiki dong";

        $scores = $this->sentiment->score($teks);
        $category = $this->sentiment->categories($teks);

        if ($scores['positif'] == 0.333 && $scores['netral'] == 0.333 && $scores['negatif'] == 0.333) {
            $category = 'netral';
        }

        return view('index', [
            'judul' => $judul,
            'teks' => $teks,
            'scores' => $scores,
            'category' => $category,
        ]);
    }

    public function index()
    {
        $judul = "Sentiment Analysis";
        $data = Sentiment::join('resource as r', 'r.id', '=', 'sentiment_analysis.resource_id')
        ->select('sentiment_analysis.*', 'r.text')
        ->orderBy('r.id', 'asc')->get();

        $sentimen = Sentiment::all();
        // $sentiment = ['positive' => $positive, 'netral' => $netral, 'negative' => $negative];
        $sentiment = [
            'positive' => $sentimen->where('sentiment', 'positif')->count(),
            'netral' => $sentimen->where('sentiment', 'netral')->count(),
            'negative' => $sentimen->where('sentiment', 'negatif')->count()
        ];

        return view('dashboard.sentiment.index', [
            "judul" => $judul,
            "data" => $data,
            "sentiment" => $sentiment,
        ]);
    }

    public function sentimentAnalysis()
    {
        $data = Preprocessing::orderBy('resource_id', 'asc')->get();
        Sentiment::truncate();

        foreach ($data as $item) {
            $scores = $this->sentiment->score($item->stemming);
            $category = $this->sentiment->categories($item->stemming);
            if ($scores['positif'] == 0.333 && $scores['netral'] == 0.333 && $scores['negatif'] == 0.333) {
                $category = 'netral';
            }

            Sentiment::insert([
                'positive' => $scores['positif'],
                'netral' => $scores['netral'],
                'negative' => $scores['negatif'],
                'sentiment' => $category,
                'resource_id' => $item->resource_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
