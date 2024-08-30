<?php

namespace App\Models;

use Filament\Forms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PidumAktiviti extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'perkara_pidum_id',
        'tahapan_perkara_id',
        'administrasi_pidum_id',
        'user_id',
        'deadline',
        'file_path',
        'order_column',
        'keterangan',
        'revisi',
        'status',
    ];
    public function perkara_pidum(): BelongsTo
    {
        return $this->belongsTo(PerkaraPidum::class);
    }
    public function tahapan_perkara(): BelongsTo
    {
        return $this->belongsTo(TahapanPerkara::class);
    }
    public function administrasi_pidum(): BelongsTo
    {
        return $this->belongsTo(AdministrasiPidum::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public static function getForm(): array
    {
        return [
            Forms\Components\Grid::make([
                'default' => 12
            ])
            ->schema([
                Forms\Components\Select::make('identitas_tersangka_id')
                    ->label('Tersangka')
                    ->preload()
                    ->placeholder('Pilih Tersangka')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                    ])
                    ->relationship(name: 'identitas_tersangka', titleAttribute: 'nama', ignoreRecord: true,
                        modifyQueryUsing: fn (Builder $query) => $query->whereNotExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                  ->from('perkara_pidums')
                                  ->where('deleted_at', null)
                                  ->whereRaw('identitas_tersangkas.id = perkara_pidums.identitas_tersangka_id');
                        })
                    )
                    // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                    // ->createOptionForm(IdentitasTersangka::getForm())
                    ->native(false)
                    ->searchable()
                    ->columnSpan([
                        'default' => 12,
                    ]),
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
