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
        Schema::create('pemeriksaan_pidsuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("perkara_pidsus_id")
                ->constrained(table: 'perkara_pidsuses')
                ->cascadeOnDelete();
            $table->foreignId("identitas_saksi_id")
                ->constrained(table: 'identitas_saksis')
                ->cascadeOnDelete();
            $table->foreignId("pegawai_id")
                ->constrained(table: 'pegawais')
                ->cascadeOnDelete();
            $table->timestamp('tgl_pemeriksaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_pidsuses');
    }
};
