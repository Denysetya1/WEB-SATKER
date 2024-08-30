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

class TahapanPerkara extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahap',
        'color',
        'slug',
    ];

    // public function tahapan_administrasi(): HasMany
    // {
    //     return $this->hasMany(TahapanAdministrasi::class);
    // }

    public function administrasi_pidums(): BelongsToMany
    {
        return $this->belongsToMany(AdministrasiPidum::class, 'tahapan_administrasis');
    }
    public static function getForm(): array
    {
        return [
            Forms\Components\TextInput::make('tahap')
                ->live(onBlur: true)
                ->required()
                ->unique()
                ->validationMessages([
                    'required' => 'Wajib Diisi.',
                    'unique' => 'Tahapan Sudah Ada.',
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
                ->unique('tahapan_perkaras', 'slug')
                ->readOnly(),
        ];
    }
    // use LogsActivity;
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['tahap', 'slug']);
    // }
    public function pidum_aktiviti(): HasMany
    {
        return $this->hasMany(PerkaraPidum::class);
    }
}
