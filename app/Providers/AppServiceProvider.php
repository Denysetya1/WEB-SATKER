<?php

namespace App\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Notifications\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('Html5QrcodeScanner', 'https://unpkg.com/html5-qrcode'),
            Js::make('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11'),
            // Js::make('scan-qr', __DIR__ . '/../../resources/js/scan-qr/scan-qr.js')->module(),
            Js::make('custom-script', __DIR__ . '/../../resources/js/livewire-alert/livewire-alert.js'),
        ]);

        Notification::configureUsing(function (Notification $notification): void {
            $notification->view('notifications.notifsweet');
        });
    }
}
