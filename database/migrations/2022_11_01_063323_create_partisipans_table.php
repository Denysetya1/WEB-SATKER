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
        Schema::create('partisipans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pekerjaan');
            $table->smallInteger('usia');
            $table->string('jenis_kelamin', 9);
            $table->string('pendidikan')->nullable();
            $table->string('pendidikan_akhir');
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
        Schema::dropIfExists('partisipans');
    }
};
