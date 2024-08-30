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
        Schema::table('perkara_pidums', function (Blueprint $table) {
            $table->timestamp('masuk_at')->after('no_spdp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perkara_pidums', function (Blueprint $table) {
            $table->dropColumn('masuk_at');
        });
    }
};
