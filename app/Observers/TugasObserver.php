<?php

namespace App\Observers;

use App\Models\PidumAktiviti;
use Illuminate\Support\Facades\Storage;

class TugasObserver
{
    /**
     * Handle the Fotocover "created" event.
     */
    public function updated(PidumAktiviti $pidumAktiviti): void
    {
        if ($pidumAktiviti->isDirty('file_path')) {
            if (!is_null($pidumAktiviti->getOriginal('file_path'))) {
                Storage::disk('public')->delete($pidumAktiviti->getOriginal('file_path'));
            }
        }
        // elseif (!is_null($pidumAktiviti->getOriginal('file_path')) ) {

        // }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(PidumAktiviti $pidumAktiviti): void
    {
        if (!is_null($pidumAktiviti->file_path)) {
            Storage::disk('public')->delete($pidumAktiviti->file_path);
        }
    }
}
