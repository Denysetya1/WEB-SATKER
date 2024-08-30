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
        Schema::create('pidum_aktivitis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perkara_pidum_id')
                ->constrained(table: 'perkara_pidums')
                ->cascadeOnDelete();
            $table->foreignId('tahapan_perkara_id')
                ->constrained(table: 'tahapan_perkaras')
                ->cascadeOnDelete();
            $table->foreignId('administrasi_pidum_id')
                ->constrained(table: 'administrasi_pidums')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained(table: 'users')
                ->cascadeOnDelete();
            $table->timestamp('deadline');
            $table->string('keterangan');
            $table->string('file_path')->nullable();
            $table->unsignedInteger('order_column');
            $table->string('status')->default('Belum');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pidum_aktivitis');
    }
};
