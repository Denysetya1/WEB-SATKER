<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Forms;
use Filament\Forms\Set;
use illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TahapanAdministrasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahapan_perkara_id',
        'administrasi_pidum_id',
    ];

    // public function tahapan_perkara(): BelongsTo
    // {
    //     return $this->belongsTo(TahapanPerkara::class);
    // }
    public function administrasi_pidum(): BelongsTo
    {
        return $this->belongsTo(AdministrasiPidum::class);
    }
    // public function administrasi_pidum(): BelongsToMany
    // {
    //     return $this->belongsToMany(AdministrasiPidum::class, 'tahapan_administrasis');
    // }
    public static function getForm(): array
    {
        return [
            Forms\Components\Select::make('tahap')
                ->label('Tahap Perkara')
                ->preload()
                ->placeholder('Pilih Tahap')
                ->required()
                ->validationMessages([
                    'required' => 'Wajib Diisi.',
                ])
                // ->relationship(name: 'tahapan_perkara', titleAttribute: 'tahap')
                ->options(TahapanPerkara::all()->pluck('tahap', 'id'))
                ->createOptionForm(TahapanPerkara::getForm())
                ->native(false)
                ->searchable(),
            Forms\Components\Select::make('administrasi_pidum_id')
                ->multiple()
                ->label('Berkas')
                ->preload()
                ->placeholder('Pilih Berkas')
                ->required()
                ->validationMessages([
                    'required' => 'Wajib Diisi.',
                ])
                ->createOptionForm(AdministrasiPidum::getForm())
                ->relationship(name: 'administrasi_pidums', titleAttribute: 'label')
                // ->options(AdministrasiPidum::all()->pluck('label', 'id'))
                ->native(false)
                ->searchable(),
        ];
    }
    // use LogsActivity;
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['tahapan_perkara_id', 'administrasi_pidum_id']);
    // }
}
