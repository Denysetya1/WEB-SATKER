<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Forms;
use Filament\Forms\Set;
use illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AdministrasiPidum extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'slug',
    ];

    // public function tahapan_administrasi(): HasMany
    // {
    //     return $this->hasMany(TahapanAdministrasi::class);
    // }

    public function tahapan_perkaras(): BelongsToMany
    {
        return $this->belongsToMany(TahapanPerkara::class, 'tahapan_administrasis', 'tahapan_perkara_id', 'administrasi_pidum_id');
    }

    public static function getForm(): array
    {
        return [
            Forms\Components\TextInput::make('label')
                ->live(onBlur: true)
                ->required()
                ->unique('administrasi_pidums', 'label')
                ->validationMessages([
                    'required' => 'Wajib Diisi.',
                    'unique' => 'Berkas Administrasi Sudah Ada.',
                ])
                ->afterStateUpdated(function (String $operation, $state, Set $set) {
                    if($operation === 'edit' ){
                        return;
                    }
                    $slug = Str::slug($state);
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersNumber = strlen($characters);
                    $code = '';
                    while (strlen($code) < 5) {
                        $position = rand(0, $charactersNumber - 1);
                        $character = $characters[$position];
                        $code = $code.$character;
                    }
                    $code = $slug.'_'.$code;
                    $set('slug', $code);
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique('administrasi_pidums', 'slug')
                ->readOnly(),
        ];
    }
    // use LogsActivity;
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['label', 'slug']);
    // }
    public function pidum_aktiviti(): HasMany
    {
        return $this->hasMany(PerkaraPidum::class);
    }
}
