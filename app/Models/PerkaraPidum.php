<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerkaraPidum extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'no_spdp',
        'file_path',
        'masuk_at'
    ];
    // public function identitas_tersangka(): BelongsTo
    // {
    //     return $this->belongsTo(IdentitasTersangka::class);
    // }
    public function pidum_aktiviti(): HasMany
    {
        return $this->hasMany(PerkaraPidum::class);
    }
    public function identitas_tersangka(): BelongsToMany
    {
        return $this->belongsToMany(IdentitasTersangka::class, 'perkara_pidum_tersangkas');
    }
    public static function getForm(): array
    {
        return [
            Forms\Components\Grid::make([
                'default' => 12
            ])
            ->schema([
                Forms\Components\Select::make('identitas_tersangka_id')
                    ->multiple()
                    ->label('Tersangka')
                    ->preload()
                    ->placeholder('Pilih Tersangka')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                    ])
                    ->createOptionForm(IdentitasTersangka::getForm())
                    ->searchable()
                    ->relationship(name: 'identitas_tersangka', titleAttribute: 'nama',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNotExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                    ->from('perkara_pidum_tersangkas')
                                    ->where('deleted_at', null)
                                    ->whereRaw('identitas_tersangkas.id = perkara_pidum_tersangkas.identitas_tersangka_id');
                        })
                    )
                    // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                    // ->pivotData([
                    //     'is_primary' => true,
                    // ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_spdp')
                    ->label('No. SPDP')
                    ->required()
                    ->unique()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                        'unique' => 'Nomor SPDP Sudah Ada.',
                    ])
                    ->columnSpan([
                        'sm' => 12,
                        'md' => 6
                    ]),
                Forms\Components\DatePicker::make('masuk_at')
                    ->label('Tanggal Masuk SPDP')
                    ->native(false)
                    ->columnSpan([
                        'sm' => 12,
                        'md' => 6
                    ]),
            ])
        ];
    }
}
