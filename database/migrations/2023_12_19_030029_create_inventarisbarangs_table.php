<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventarisbarangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruang_id')->nullable();
            $table->string('nama');
            $table->string('kode');
            $table->tinyInteger('nup');
            $table->string('merk');
            $table->string('tahun');
            $table->tinyInteger('jumlah');
            $table->string('kondisi');
            $table->string('photo_path');
            $table->string('qr_path')->unique();
            $table->timestamps();
        });

        Schema::table('inventarisbarangs', function(Blueprint $table) {
            $table->foreign('ruang_id')->references('id')->on('ruangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarisbarangs');
    }
};
