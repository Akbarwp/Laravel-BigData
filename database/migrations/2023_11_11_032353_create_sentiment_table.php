<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->id();
            $table->string('acara_tv');
            $table->integer('jumlah_retweet');
            $table->text('text');
            $table->timestamps();
        });

        Schema::create('preprocessing', function (Blueprint $table) {
            $table->id();
            $table->text('case_folding')->nullable();
            $table->text('tokenize')->nullable();
            $table->text('stemming')->nullable();
            $table->foreignId('resource_id');
            $table->timestamps();
        });

        Schema::create('sentiment_analysis', function (Blueprint $table) {
            $table->id();
            $table->double('positive');
            $table->double('netral');
            $table->double('negative');
            $table->string('sentiment');
            $table->foreignId('resource_id');
            $table->timestamps();
        });

        Schema::create('data_testing', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->text('preprocessing')->nullable();
            $table->string('sentiment');
            $table->timestamps();
        });

        Schema::create('naive_bayes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_testing_id');
            $table->string('result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('naive_bayes');
        Schema::dropIfExists('data_testing');
        Schema::dropIfExists('sentiment_analysis');
        Schema::dropIfExists('preprocessing');
        Schema::dropIfExists('resource');
    }
};
