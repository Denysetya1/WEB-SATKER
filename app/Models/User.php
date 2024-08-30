<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPanelShield;

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@kejaksaan.go.id');
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_path ? Storage::url($this->profile_photo_path) : null ;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'telegram_chat_id',
        'email',
        'nip',
        'password',
        'active',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }
    public function pidum_aktiviti(): HasOne
    {
        return $this->hasOne(PidumAktiviti::class);
    }

    public function canComment(): bool
    {
        // your conditional logic here
        return true;
    }
    // use LogsActivity;
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['name',
    //     'email',
    //     'nip',]);
    // }
}
