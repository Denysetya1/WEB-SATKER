<?php

namespace App\Observers;

use App\Models\Inventarisbarang;
use Illuminate\Support\Facades\Storage;

class InventarisObserver
{
    /**
     * Handle the Fotocover "created" event.
     */
    public function updated(Inventarisbarang $barang): void
    {
        if ($barang->isDirty('photo_path')) {
            if (!is_null($barang->photo_path)) {
                Storage::disk('public')->delete($barang->getOriginal('photo_path'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(Inventarisbarang $barang): void
    {
        if (!is_null($barang->photo_path)) {
            Storage::disk('public')->delete($barang->photo_path);
        }
        if (!is_null($barang->qr_path)) {
            Storage::disk('public')->delete('Photo-QR/'.$barang->qr_path.'.svg');
        }
    }
}
