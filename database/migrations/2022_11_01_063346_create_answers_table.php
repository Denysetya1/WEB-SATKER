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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('partisipan_id');
            $table->string('jawaban');
            $table->timestamps();
        });

        Schema::table('answers', function(Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('partisipan_id')->references('id')->on('partisipans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
