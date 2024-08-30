<?php

namespace App\Observers;

use App\Models\Riwayatpendidikan;
use Illuminate\Support\Facades\Storage;

class RiwayatpendidikanObserver
{
    public function updated(Riwayatpendidikan $riwayat): void
    {
        if ($riwayat->isDirty('ijazah_link')) {
            if (!is_null($riwayat->ijazah_link)) {
                Storage::disk('public')->delete($riwayat->getOriginal('ijazah_link'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(Riwayatpendidikan $riwayat): void
    {
        if (!is_null($riwayat->ijazah_link)) {
            Storage::disk('public')->delete($riwayat->ijazah_link);
        }
    }
}
