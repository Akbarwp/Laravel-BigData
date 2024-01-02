<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sentiment;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ClassificationReport;
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
        $teks = "adaptif adil agung ahli ajaib";
        // $teks = "teror bodoh ambigu agresif ambigu";
        // $teks = "jalan kemana saja";

        $scores = $this->sentiment->score($teks);
        $category = $this->sentiment->categories($teks);

        // if ($scores['positif'] == 0.333 && $scores['netral'] == 0.333 && $scores['negatif'] == 0.333) {
        //     $category = 'netral';
        // }

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
        ->join('preprocessing as p', 'p.resource_id', '=', 'sentiment_analysis.resource_id')
        ->select('sentiment_analysis.*', 'p.stemming', 'r.label')
        ->orderBy('r.id', 'asc')->get();

        $sentimen = Sentiment::all();
        // $sentiment = ['positive' => $positive, 'netral' => $netral, 'negative' => $negative];
        $sentimenPositif = $sentimen->where('sentiment', 'positive')->count();
        $sentimenNegatif = $sentimen->where('sentiment', 'negative')->count();
        $sentiment = [
            'positive' => $sentimenPositif,
            // 'netral' => $sentimen->where('sentiment', 'netral')->count(),
            'negative' => $sentimenNegatif,
        ];

        if ($sentimen->count() != 0) {
            $persentasePositif = ($sentimenPositif / $sentimen->count()) * 100;
            $persentaseNegatif = ($sentimenNegatif / $sentimen->count()) * 100;
            $persentase = [
                'positive' => $persentasePositif,
                'negative' => $persentaseNegatif,
            ];
        } else {
            $persentase = [
                'positive' => 0,
                'negative' => 0,
            ];
        }

        return view('dashboard.sentiment.index', [
            "judul" => $judul,
            "data" => $data,
            "sentiment" => $sentiment,
            "persentase" => $persentase,
        ]);
    }

    public function sentimentAnalysis()
    {
        $data = Preprocessing::orderBy('resource_id', 'asc')->get();
        if ($data[0]->stemming == null) {
            abort(400);
        }
        Sentiment::truncate();

        //? Kalua Ada Netral
        // foreach ($data as $item) {
        //     $scores = $this->sentiment->score($item->stemming);
        //     $category = $this->sentiment->categories($item->stemming);
        //     if ($scores['positif'] == 0.333 && $scores['netral'] == 0.333 && $scores['negatif'] == 0.333) {
        //         $category = 'netral';
        //     }

        //     Sentiment::insert([
        //         'positive' => $scores['positif'],
        //         'netral' => $scores['netral'],
        //         'negative' => $scores['negatif'],
        //         'sentiment' => $category,
        //         'resource_id' => $item->resource_id,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }

        //? Kalau Tidak Ada Netral
        foreach ($data as $item) {
            $scores = $this->sentiment->score($item->stemming);
            $category = $this->sentiment->categories($item->stemming);

            if ($category == "positif") {
                $kategori = "positive";
            } elseif ($category == "negatif") {
                $kategori = "negative";
            }

            Sentiment::insert([
                'positive' => $scores['positif'],
                'negative' => $scores['negatif'],
                'sentiment' => $kategori,
                'resource_id' => $item->resource_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
