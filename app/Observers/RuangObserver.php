<?php

namespace App\Observers;

use App\Models\Ruang;
use Illuminate\Support\Facades\Storage;

class RuangObserver
{
    /**
     * Handle the Fotocover "created" event.
     */
    public function updated(Ruang $ruang): void
    {
        if ($ruang->isDirty('photo_path')) {
            if (!is_null($ruang->photo_path)) {
                Storage::disk('public')->delete($ruang->getOriginal('photo_path'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(Ruang $ruang): void
    {
        if (!is_null($ruang->photo_path)) {
            Storage::disk('public')->delete($ruang->photo_path);
        }
    }
}
