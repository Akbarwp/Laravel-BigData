<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vectorizer;
use App\Models\Preprocessing;
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
            'data' => $data,
        ]);
    }

    public function vectorizer()
    {
        $data = Preprocessing::all();
        $sentence = [];
        foreach ($data as $item) {
            $sentence[] = $item->stemming;
        }
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($sentence);
        $vectorizer->transform($sentence);

        Vectorizer::truncate();

        $result = (array) $vectorizer;
        foreach ($result["\x00Phpml\FeatureExtraction\TokenCountVectorizer\x00frequencies"] as $value => $item) {
            Vectorizer::insert([
                'word' => $value,
                'total' => $item,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
