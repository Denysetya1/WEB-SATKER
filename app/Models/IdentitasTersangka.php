<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class IdentitasTersangka extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'riwayat_pendidikan',
        'tgl_lahir',
        'tempat_lahir',
        'umur',
        'alamat',
        'agama',
        'jenis_kelamin',
    ];
    public static function getForm(): array
    {
        return [
            Forms\Components\Fieldset::make('Identitas')
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
                    Forms\Components\TextInput::make('riwayat_pendidikan')
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
    // public function perkara_pidum(): HasOne
    // {
    //     return $this->hasOne(PerkaraPidum::class);
    // }
    public function perkara_pidum(): BelongsToMany
    {
        return $this->belongsToMany(PerkaraPidum::class, 'perkara_pidum_tersangkas');
    }
}
