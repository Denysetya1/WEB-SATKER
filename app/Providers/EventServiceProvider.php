<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Inventarisbarang;
use App\Models\PidumAktiviti;
use App\Models\Riwayatpendidikan;
use App\Models\Ruang;
use App\Models\Sk;
use App\Models\User;
use App\Observers\BeritaObserver;
use App\Observers\InventarisObserver;
use App\Observers\PegawaiObserver;
use App\Observers\RiwayatpendidikanObserver;
use App\Observers\RuangObserver;
use App\Observers\SkObserver;
use App\Observers\TugasObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Ruang::observe(RuangObserver::class);
        Inventarisbarang::observe(InventarisObserver::class);
        User::observe(PegawaiObserver::class);
        Sk::observe(SkObserver::class);
        Riwayatpendidikan::observe(RiwayatpendidikanObserver::class);
        Berita::observe(BeritaObserver::class);
        PidumAktiviti::observe(TugasObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
