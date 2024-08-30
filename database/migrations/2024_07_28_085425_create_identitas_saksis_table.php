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
        Schema::create('identitas_saksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_ktp')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->string('alamat')->nullable();
            $table->string('agama')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_saksis');
    }
};
