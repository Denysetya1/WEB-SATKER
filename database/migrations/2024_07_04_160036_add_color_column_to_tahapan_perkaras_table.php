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
        Schema::table('tahapan_perkaras', function (Blueprint $table) {
            $table->string('color')->nullable()->after('tahap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahapan_perkaras', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
