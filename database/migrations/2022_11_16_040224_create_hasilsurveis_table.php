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
        Schema::create('hasilsurveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->integer('jumlah_partisipan');
            $table->integer('jumlah_point');
            $table->integer('total_skm');
            $table->timestamps();
        });

        Schema::table('hasilsurveis', function(Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasilsurveis');
    }
};
