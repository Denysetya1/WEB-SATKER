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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_berita')->nullable();
            $table->text('judul');
            $table->string('slug')->unique();
            // $table->string('sinopsis', 255);
            $table->mediumText('isi_berita');
            $table->string('caption_gambar');
            $table->string('author', 40);
            $table->timestamp('published_at')->nullable();

            $table->boolean('featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
};
