<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PegawaiObserver
{
    public function updated(User $user): void
    {
        if ($user->isDirty('profile_photo_path')) {
            if (!is_null($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->getOriginal('profile_photo_path'));
            }
        }
    }

    /**
     * Handle the Fotocover "deleted" event.
     */
    public function deleted(User $user): void
    {
        if (!is_null($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
    }
}
