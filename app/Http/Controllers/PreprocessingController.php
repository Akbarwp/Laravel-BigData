<?php

namespace App\Http\Controllers;

use App\Models\Preprocessing;
use Sastrawi\Stemmer\StemmerFactory;
use voku\helper\StopWords;

class PreprocessingController extends Controller
{
    public function index()
    {
        $judul = "Preprocessing";
        $data = Preprocessing::orderBy('resource_id', 'asc')->get();

        return view('dashboard.preprocessing.index', [
            "judul" => $judul,
            "data" => $data,
        ]);
    }

    public function preprocessing()
    {
        // $linkHttpRegex = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
        // $linkHttpsRegex = "@(http?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
        // $hashtagRegex = "/#\S+\s*/";
        // $usernameRegex = "/(\s+|^)@\S+/";

        $stopWords = new StopWords();
        $stopWords = (array) $stopWords->getStopWordsFromLanguage('id');
        $stopWords3 = array($stopWords)[0];

        $stemmerFactory = new StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        $data = Preprocessing::orderBy('resource_id', 'asc')->get();

        foreach ($data as $item) {
            // $cleanHashtag = preg_replace($hashtagRegex, "", $item->case_folding);
            // $cleanLink = preg_replace($linkHttpRegex, "", $cleanHashtag);
            // $cleanLinks = preg_replace($linkHttpsRegex, "", $cleanLink);
            // $cleanUsername = preg_replace($usernameRegex, "", $cleanLinks);

            // $wordsFromSearchString = str_word_count($cleanUsername, true);
            $wordsFromSearchString = str_word_count($item->case_folding, true);
            $semiFinalWords = array_diff($wordsFromSearchString, $stopWords3);
            $finalWords = implode(" ", $semiFinalWords);
            // $finalWords = implode(" ", $wordsFromSearchString);

            $stemming = $stemmer->stem($finalWords);

            Preprocessing::where('resource_id', $item->resource_id)->update([
                'tokenize' => $finalWords,
                'stemming' => $stemming,
            ]);
        }

        return redirect('dashboard/preprocessing')->with('berhasil', "Data berhasil dilakukan preprocessing!");
    }
}
