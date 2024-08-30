<?php

namespace App\Models;

use Filament\Forms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerkaraPidsus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama_kasus',
        'tgl_mulai',
    ];
    public function identitas_saksi(): BelongsToMany
    {
        return $this->belongsToMany(IdentitasSaksi::class, 'pemeriksaan_pidsuses');
    }
    public static function getForm(): array
    {
        return [
            Forms\Components\Grid::make([
                'default' => 12
            ])
            ->schema([
                Forms\Components\TextInput::make('nama_kasus')
                    ->label('Nama Perkara/Kasus')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                    ])
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tgl_mulai')
                    ->label('Tanggal Mulai Perkara')
                    ->native(false)
                    ->columnSpanFull(),
            ])
        ];
    }
}
