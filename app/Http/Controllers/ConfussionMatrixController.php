<?php

namespace App\Http\Controllers;

use App\Models\Sentiment;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ClassificationReport;

class ConfussionMatrixController extends Controller
{
    private $sentiment;

    public function __construct()
    {
        require_once app_path('/Library/PHPInsight/Autoloader.php');
        \PHPInsight\Autoloader::register();
        $this->sentiment = new \PHPInsight\Sentiment();
    }

    public function index()
    {
        $judul = "Confussion Matrix";

        $data = Sentiment::join('resource as r', 'r.id', '=', 'sentiment_analysis.resource_id')
        ->select('sentiment_analysis.*', 'r.text', 'r.label')
        ->orderBy('r.id', 'asc')->get();

        $actualLabels = [];
        $predictedLabels = [];
        foreach ($data as $item) {
            $actualLabels[] = $item->label;

            if ($item->sentiment == "positif") {
                $predictedLabels[] = "positive";

            } elseif ($item->sentiment == "netral") {
                $predictedLabels[] = "netral";

            } elseif ($item->sentiment == "negatif") {
                $predictedLabels[] = "negative";
            }
        }

        //? Confussion Matrix
        $TP = 0;
        $FP = 0;
        $FN = 0;
        $TN = 0;
        $temp = "";
        foreach ($data as $item) {
            if ($item->sentiment == "positif") {
                $temp = "positive";

            } elseif ($item->sentiment == "netral") {
                $temp = "netral";

            } elseif ($item->sentiment == "negatif") {
                $temp = "negative";
            }

            if ($item->label == "positive" && $temp == "positive") {
                $TP += 1;

            } elseif ($item->label == "positive" && $temp == "negative") {
                $FN += 1;

            } elseif ($item->label == "negative" && $temp == "positive") {
                $FP += 1;

            } elseif ($item->label == "negative" && $temp == "negative") {
                $TN += 1;
            }
        }

        $accuracy =  ($TP+$TN)/($TP+$TN+$FP+$FN);
        $precision =  ($TP)/($TP+$FP);
        $recall =  ($TP)/($TP+$FN);
        $specificity =  ($TN)/($TN+$FP);
        $f1Score =  (2*(($TP)/($TP+$FN))*(($TP)/($TP+$FP))) / ((($TP)/($TP+$FN)) + (($TP)/($TP+$FP)));

        // $akurasi = Accuracy::score($actualLabels, $predictedLabels);
        // $hasilSama = Accuracy::score($actualLabels, $predictedLabels, false);
        // $report = new ClassificationReport($actualLabels, $predictedLabels);

        // dd([
        //     "Akurasi" => $akurasi,
        //     "Hasil Sama" => $hasilSama,
        //     "Report Precision" => $report->getPrecision(),
        //     "Report Recall" => $report->getRecall(),
        //     "Report F1Score" => $report->getF1score(),
        //     "TP" => $TP,
        //     "FP" => $FP,
        //     "FN" => $FN,
        //     "TN" => $TN,
        //     "Accuracy" => ($TP+$TN)/($TP+$TN+$FP+$FN),
        //     "Precision" => ($TP)/($TP+$FP),
        //     "Recall" => ($TP)/($TP+$FN),
        //     "Specificity" => ($TN)/($TN+$FP),
        //     "F1Score" => (2*(($TP)/($TP+$FN))*(($TP)/($TP+$FP))) / ((($TP)/($TP+$FN)) + (($TP)/($TP+$FP))),
        // ]);

        return view('dashboard.sentiment.confussionMatrix', [
            "judul" => $judul,
            "TP" => $TP,
            "FP" => $FP,
            "FN" => $FN,
            "TN" => $TN,
            "accuracy" => $accuracy,
            "precision" => $precision,
            "recall" => $recall,
            "specificity" => $specificity,
            "f1Score" => $f1Score,
        ]);
    }
}