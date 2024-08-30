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
        Schema::create('tahapan_administrasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("tahapan_perkara_id")
                ->constrained(table: 'tahapan_perkaras')
                ->cascadeOnDelete();
            $table->foreignId("administrasi_pidum_id")
                ->constrained(table: 'administrasi_pidums')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan_administrasis');
    }
};
