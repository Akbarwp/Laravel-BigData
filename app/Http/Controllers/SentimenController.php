<?php

namespace App\Http\Controllers;

class SentimenController extends Controller
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
}
