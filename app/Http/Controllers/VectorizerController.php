<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vectorizer;
use App\Models\Sentiment;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TokenCountVectorizer;

class VectorizerController extends Controller
{
    public function index()
    {
        $judul = "Vectorizer";
        $data = Vectorizer::all();

        return view('dashboard.vectorizer.index', [
            'judul' => $judul,
            'dataPositive' => $data->where('sentiment', 'positive'),
            'dataNegative' => $data->where('sentiment', 'negative'),
        ]);
    }

    public function vectorizer()
    {
        $data = Sentiment::join('preprocessing as p', 'p.resource_id', '=', 'sentiment_analysis.resource_id')->select('p.stemming', 'sentiment_analysis.sentiment')->get();
        $sentence = [];
        $sentiment = ["positive", 'negative'];
        foreach ($sentiment as $value) {
            foreach ($data->where('sentiment', $value) as $item) {
                $sentence[$value][] = $item->stemming;
            }
        }

        Vectorizer::truncate();

        foreach ($sentiment as $senti) {
            $bayes = new TokenCountVectorizer(new WhitespaceTokenizer());
            $bayes->fit($sentence[$senti]);
            $bayes->transform($sentence[$senti]);

            $resultBayes = (array) $bayes;
            foreach ($resultBayes["\x00Phpml\FeatureExtraction\TokenCountVectorizer\x00frequencies"] as $value => $item) {
                Vectorizer::insert([
                    'word' => $value,
                    'total' => $item,
                    'sentiment' => $senti,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
