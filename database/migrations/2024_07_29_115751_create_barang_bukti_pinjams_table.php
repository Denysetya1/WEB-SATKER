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
        Schema::create('barang_bukti_pinjams', function (Blueprint $table) {
            $table->id();
            $table->foreignId("identitas_saksi_id")
                ->constrained(table: 'identitas_saksis')
                ->cascadeOnDelete();
            $table->foreignId("jenis_barang_bukti_id")
                ->constrained(table: 'jenis_barang_buktis')
                ->cascadeOnDelete();
            $table->string('nama_bb');
            $table->string('jumlah');
            $table->date('tgl_pinjam');
            $table->time('jam_pinjam');
            $table->boolean('status_ada')->default(false);
            $table->boolean('status_kembali')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_bukti_pinjams');
    }
};
