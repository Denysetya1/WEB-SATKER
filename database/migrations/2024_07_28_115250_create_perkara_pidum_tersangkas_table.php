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
        Schema::create('perkara_pidum_tersangkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("perkara_pidum_id")
                ->constrained(table: 'perkara_pidums')
                ->cascadeOnDelete();
            $table->foreignId("identitas_tersangka_id")
                ->constrained(table: 'identitas_tersangkas')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkara_pidum_tersangkas');
    }
};
