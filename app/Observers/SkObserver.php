<?php

namespace App\Observers;

use App\Models\Sk;
use Illuminate\Support\Facades\Storage;

class SkObserver
{
    public function updated(Sk $sk): void
    {
        if ($sk->isDirty('skmedia_link')) {
            if (!is_null($sk->skmedia_link)) {
                Storage::disk('public')->delete($sk->getOriginal('skmedia_link'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(Sk $sk): void
    {
        if (!is_null($sk->skmedia_link)) {
            Storage::disk('public')->delete($sk->skmedia_link);
        }
    }
}
