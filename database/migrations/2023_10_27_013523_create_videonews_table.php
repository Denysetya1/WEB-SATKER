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
        Schema::create('videonews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration');
            $table->text('embed_html');
            $table->string('thumbnail_url');
            $table->text('description')->nullable();
            $table->string('external_id');
            $table->date('published_at');
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('videonews');
    }
};
