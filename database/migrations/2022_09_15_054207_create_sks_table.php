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
        Schema::create('sks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jenissk_id')->nullable();
            $table->unsignedBigInteger('ketsk_id')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->time('tmt')->nullable();
            $table->string('skmedia_link')->nullable();
            $table->timestamps();
        });

        Schema::table('sks', function(Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->foreign('jenissk_id')->references('id')->on('jenissks');
            $table->foreign('ketsk_id')->references('id')->on('ketsks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sks');
    }
};
