<?php

use App\Models\Berita;
use App\Models\Tag;
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
        Schema::create('beritapertags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Berita::class);
            $table->foreignIdFor(Tag::class);
            $table->timestamps();
        });

        // Schema::table('beritapertags', function(Blueprint $table) {
        //     $table->foreign('id_berita')->references('id')->on('beritas')->onDelete('cascade');
        //     $table->foreign('id_tag')->references('id')->on('tags')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritapertags');
    }
};
