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
        Schema::create('inventarisbarangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventariskantor_id');
            $table->unsignedBigInteger('inventarisruang_id');
            $table->string('kode_unik')->unique();
            $table->string('nama_barang');
            $table->string('merk_barang');
            $table->string('kode_barang')->unique();
            $table->string('tahun_barang');
            $table->string('jumlah_barang');
            $table->string('penguasaan_barang');
            $table->unsignedBigInteger('ketkondisi_id');
            $table->string('kode_qr');
            $table->string('foto_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::table('inventarisbarangs', function(Blueprint $table) {
            $table->foreign('inventariskantor_id')->references('id')->on('inventariskantors')->onDelete('cascade');
            $table->foreign('inventarisruang_id')->references('id')->on('inventarisruangs')->onDelete('cascade');
            $table->foreign('ketkondisi_id')->references('id')->on('ketkondisis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarisbarangs');
    }
};
