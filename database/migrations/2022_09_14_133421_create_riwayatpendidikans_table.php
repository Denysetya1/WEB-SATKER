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
        Schema::create('riwayatpendidikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jenjangpendidikan_id')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->string('ijazah_link')->nullable();
            $table->timestamps();
        });

        Schema::table('riwayatpendidikans', function(Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->foreign('jenjangpendidikan_id')->references('id')->on('jenjangpendidikans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayatpendidikans');
    }
};
