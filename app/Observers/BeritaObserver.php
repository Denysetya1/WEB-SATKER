<?php

namespace App\Observers;

use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaObserver
{
    /**
     * Handle the Fotocover "created" event.
     */
    public function updated(Berita $berita): void
    {
        if ($berita->isDirty('gambar_berita')) {
            if (!is_null($berita->gambar_berita)) {
                Storage::disk('public')->delete($berita->getOriginal('gambar_berita'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(Berita $berita): void
    {
        if (!is_null($berita->gambar_berita)) {
            Storage::disk('public')->delete($berita->gambar_berita);
        }
    }
}
