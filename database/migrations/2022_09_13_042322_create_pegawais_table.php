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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_hp')->unique()->nullable();
            $table->string('alamat_asal')->nullable();
            $table->string('kota_asal')->nullable();
            $table->string('prov_asal')->nullable();
            $table->string('satker_asal')->nullable();
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->unsignedBigInteger('pangkat_id')->nullable();
            $table->string('jabatan')->nullable();
            $table->bigInteger('no_nrp')->unique();
            $table->bigInteger('no_nip')->unique();
            $table->string('photoInfo1', 2048)->nullable();
            $table->string('photoInfo2', 2048)->nullable();
            $table->date('tgl_masuk_pertama')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('paraf_1')->nullable();
            $table->string('paraf_2')->nullable();
            $table->string('paraf_3')->nullable();
            $table->timestamps();
        });

        Schema::table('pegawais', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bidang_id')->references('id')->on('bidangs');
            $table->foreign('pangkat_id')->references('id')->on('pangkats');
            $table->foreign('jabatan_id')->references('id')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
