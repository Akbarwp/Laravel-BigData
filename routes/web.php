<?php

use App\Http\Controllers\ConfussionMatrixController;
use App\Http\Controllers\PreprocessingController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SentimentController;
use App\Http\Controllers\VectorizerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => [],
    'prefix' => 'dashboard'
], function() {

    Route::get('/', [SentimentController::class, 'sentimen'])->name('dashboard');

    Route::group([
        'prefix' => 'resource'
    ], function () {
        Route::get('/', [ResourceController::class, 'index'])->name('resource.index');
        Route::post('/simpan', [ResourceController::class, 'simpan'])->name('resource.simpan');
        Route::post('/import', [ResourceController::class, 'import'])->name('resource.import');
        Route::get('/ubah', [ResourceController::class, 'ubah'])->name('resource.ubah');
        Route::post('/ubah', [ResourceController::class, 'perbarui'])->name('resource.perbarui');
        Route::post('/hapus', [ResourceController::class, 'hapus'])->name('resource.hapus');
        Route::post('/truncate', [ResourceController::class, 'truncate'])->name('resource.truncate');
    });

    Route::group([
        'prefix' => 'preprocessing'
    ], function () {
        Route::get('/', [PreprocessingController::class, 'index'])->name('preprocessing.index');
        Route::post('/preprocessing', [PreprocessingController::class, 'preprocessing'])->name('preprocessing.preprocessing');
    });

    Route::group([
        'prefix' => 'sentimentAnalysis'
    ], function () {
        Route::get('/', [SentimentController::class, 'index'])->name('sentimentAnalysis.index');
        Route::post('/sentimentAnalysis', [SentimentController::class, 'sentimentAnalysis'])->name('sentimentAnalysis.sentimentAnalysis');
    });

    Route::group([
        'prefix' => 'vectorizer'
    ], function () {
        Route::get('/', [VectorizerController::class, 'index'])->name('vectorizer.index');
        Route::post('/vectorizer', [VectorizerController::class, 'vectorizer'])->name('vectorizer.vectorizer');
    });

    Route::group([
        'prefix' => 'confussionMatrix'
    ], function () {
        Route::get('/', [ConfussionMatrixController::class, 'index'])->name('confussionMatrix.index');
    });
});
