<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class IdentitasSaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'no_ktp',
        'no_wa',
        'pekerjaan',
        'tgl_lahir',
        'tempat_lahir',
        'umur',
        'alamat',
        'agama',
        'jenis_kelamin',
    ];
    public function perkara_pidsus(): BelongsToMany
    {
        return $this->belongsToMany(PerkaraPidsus::class, 'pemeriksaan_pidsuses');
    }
    public function barang_bukti_pinjam(): HasMany
    {
        return $this->hasMany(BarangBuktiPinjam::class);
    }
    public function pegawai(): BelongsToMany
    {
        return $this->belongsToMany(Pegawai::class, 'pemeriksaan_pidsuses');
    }
    public static function getForm(): array
    {
        return [
            Forms\Components\Fieldset::make('Perkara')
            ->schema([
                Forms\Components\Select::make('perkara_pidsus_id')
                    ->label('Saksi Dalam Perkara')
                    ->placeholder('Pilih Perkara')
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                    ])
                    ->createOptionForm(PerkaraPidsus::getForm())
                    ->searchable()
                    ->relationship(name: 'perkara_pidsus', titleAttribute: 'nama_kasus')
                    // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                    // ->pivotData([
                    //     'is_primary' => true,
                    // ])
                    ->pivotData(function (Get $get){
                        return [
                            'pegawai_id' => $get('pegawai_id'),
                            'tgl_pemeriksaan' => $get('tgl_pemeriksaan'),
                        ];
                    })
                    ->columnSpanFull(),
                Forms\Components\Select::make('pegawai_id')
                    ->label('Pemeriksa Saksi')
                    ->placeholder('Pilih Pemeriksa')
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib Diisi.',
                    ])
                    // ->createOptionForm(PerkaraPidsus::getForm())
                    ->relationship(name: 'pegawai')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_nip} - {$record->user->name}")
                    ->searchable(['no_nip', 'name'])
                    // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                    ->columnSpan(5),
                Forms\Components\DatePicker::make('tgl_pemeriksaan')
                    ->label('Tanggal Mulai Pemeriksaan')
                    ->native(false)
                    ->columnSpan(3)
            ])->columns(8),
            Forms\Components\Fieldset::make('Identitas Perkara')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('no_ktp')
                        ->label('No. KTP')
                        ->unique()
                        ->maxLength(255)
                        ->columnSpan(2),
                    ButtonGroup::make('jenis_kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ])
                        ->required()
                        ->onColor('wisteria')
                        ->offColor('gray')
                        ->gridDirection('row')
                        ->default('Laki-laki')
                        ->columnSpan(2),
                ])
                ->columns(4),
            Forms\Components\Fieldset::make('Biodata')
                ->schema([
                    Forms\Components\TextInput::make('no_wa')
                        ->label('No. WA')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('agama')
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('pekerjaan')
                        ->maxLength(255)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('tempat_lahir')
                        ->maxLength(255)
                        ->columnSpan(3),
                    Forms\Components\DatePicker::make('tgl_lahir')
                        ->columnSpan(2)
                        ->reactive()
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('umur', Carbon::parse($state)->age);
                        }),
                    Forms\Components\TextInput::make('umur')
                        ->readOnly()
                        ->columnSpan(1),
                    Forms\Components\Textarea::make('alamat')
                        ->autosize()
                        ->columnSpanFull(),
                ])
                ->columns(6),
            ];
    }
}
