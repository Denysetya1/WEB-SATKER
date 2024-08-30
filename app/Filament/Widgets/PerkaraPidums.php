<?php

namespace App\Filament\Widgets;

use App\Models\IdentitasTersangka;
use App\Models\PerkaraPidum;
use App\Models\PidumAktiviti;
use App\Notifications\SpdpMasukNotification;
use App\Notifications\TelegramNotification;
use App\Notifications\TugasNotification;
use BezhanSalleh\FilamentExceptions\Facades\FilamentExceptions;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;
use DateTime;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Indicator;
use Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PerkaraPidums extends BaseWidget
{
    use LivewireAlert;
    protected static bool $isDiscovered = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PerkaraPidum::query()->with('identitas_tersangka')
            )
            ->heading(false)
            ->headerActions([
                Tables\Actions\CreateAction::make('addPerkara')
                    ->label('Tambah Perkara')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Tambah Perkara')
                    ->modalSubmitActionLabel('Tambah')
                    ->form(PerkaraPidum::getForm())
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->using(function (array $data, string $model): Model {
                        return $model::create($data);
                    })
                    ->after(function (PerkaraPidum $perkara) {
                        // dd($perkara->identitas_tersangka);
                        Notification::route('telegram', '-4245000877')->notify(new SpdpMasukNotification($perkara->with('identitas_tersangka')->get()));
                        $aktivity['perkara_pidum_id'] = $perkara['id'];
                        $aktivity['tahapan_perkara_id'] = 3;
                        $aktivity['administrasi_pidum_id'] = 1;
                        $aktivity['user_id'] = Auth::id();
                        $aktivity['keterangan'] = 'Buat P-16 dari SPDP No. '.$perkara['no_spdp'];
                        $aktivity['deadline'] = Carbon::parse($perkara['masuk_at'])->addDays();
                        $aktivity['status'] = 'Belum';
                        $activities = PidumAktiviti::create($aktivity);
                        Notification::route('telegram', '-4245000877')->notify(new TugasNotification($activities['id']));
                        $this->dispatch('refresh-Component');
                    })
                    ,
            ])
            ->columns([
                Tables\Columns\TextColumn::make('no_spdp')
                    ->label('No. SPDP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identitas_tersangka.nama')
                    ->label('Nama Tersangka')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masuk_at')
                    ->label('Tanggal Masuk')
                    ->date('d F Y')
                    ->sortable(),
            ])
            ->paginated([5,10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Belum Ada Perkara Pidum')
            ->emptyStateDescription('Silahkan Menambahkan Perkara, Perkara akan muncul di sini.')
            ->emptyStateActions([
                Tables\Actions\Action::make('addPerkara')
                    ->label('Tambah Perkara')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Tambah Perkara')
                    ->modalSubmitActionLabel('Tambah')
                    ->form([
                        Forms\Components\Grid::make([
                            'default' => 12
                        ])
                        ->schema([
                            Forms\Components\Select::make('identitas_tersangka_id')
                                ->label('Tahap Perkara')
                                ->preload()
                                ->placeholder('Pilih Tahap')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib Diisi.',
                                ])
                                ->relationship(name: 'identitas_tersangka', titleAttribute: 'nama', ignoreRecord: true)
                                // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                                ->createOptionForm(IdentitasTersangka::getForm())
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
                    ])->modalWidth(MaxWidth::FourExtraLarge)
                    ->action(function (array $data) {
                        // dd($data);
                        try {
                            PerkaraPidum::create($data);
                            $this->alert('success', 'Perkara Berhasil Di Tambahkan', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => false,
                            ]);
                        } catch (\Throwable $th) {
                            $this->alert('error', 'Ada Yang Salah, Perkara Tidak Berhasil Di Simpan', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => false,
                            ]);
                        }
                    }),
            ])
            ->filters([
                Filter::make('masuk_at')
                    ->label('Tanggal Surat Masuk')
                    ->form([
                        Grid::make([
                            'default' => 2
                        ])
                            ->schema([
                                Select::make('month')
                                    ->label('Bulan')
                                    ->options(function () {
                                        $size = count(range(1, Carbon::MONTHS_PER_YEAR));
                                        $bulan = [];
                                        for ($i = 1; $i <= $size; $i++) {
                                            $human = DateTime::createFromFormat('!m', $i)->format('F'); // https://stackoverflow.com/a/18467892/6056864

                                            $bulan[$i] = $human;
                                        }
                                        return $bulan;
                                    })
                                    // ->default(date('F'))
                                    ->placeholder('Bulan')
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 2,
                                    ]),
                                Select::make('year')
                                    ->label('Tahun')
                                    ->options(function () {
                                        $years = [];

                                        for ($year = 2019; $year <= date('Y'); $year++) {
                                            $years[$year] = $year;
                                        }

                                        return $years;
                                    })
                                    // ->default(date('Y'))
                                    ->native(false)
                                    ->placeholder('Tahun')
                                    ->selectablePlaceholder(false)
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 2,
                                    ]),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $date = now()->startOfMonth();

                        if ($data['month']) {
                            $date->setMonth((int)$data['month']);
                        }

                        if ($data['year']) {
                            $date->setYear((int)$data['year']);
                        }

                        return $query
                            ->when(
                                $date,
                                fn (Builder $query, $date): Builder => $query->whereDate('masuk_at', '>=', $date->startOfMonth()),
                            )
                            ->when(
                                $date,
                                fn (Builder $query, $date): Builder => $query->whereDate('masuk_at', '<=', $date->endOfMonth()),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['month'] ?? null) {
                            $indicators[] = Indicator::make('SPDP Masuk Pada Bulan ' . DateTime::createFromFormat('!m', $data['month'])->format('F'))
                                ->removeField('month');
                        }

                        if ($data['year'] ?? null) {
                            $indicators[] = Indicator::make('SPDP Masuk Pada Tahun ' . $data['year'])
                                ->removeField('year');
                        }

                        return $indicators;
                    })
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->form([
                        Forms\Components\Grid::make([
                            'default' => 12
                        ])
                        ->schema([
                            Forms\Components\Select::make('identitas_tersangka_id')
                                ->label('Tahap Perkara')
                                ->preload()
                                ->placeholder('Pilih Tahap')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib Diisi.',
                                ])
                                ->relationship(name: 'identitas_tersangka', titleAttribute: 'nama')
                                // ->options(IdentitasTersangka::all()->pluck('nama', 'id'))
                                ->createOptionForm(IdentitasTersangka::getForm())
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
                    ]),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Data Tersangka Dihapus')
                    ->before(function (Model $record) {
                        $record['no_spdp'] = $record['no_spdp'].'-deleted';
                        $tugas = PidumAktiviti::where('perkara_pidum_id', $record['id'])->first();
                        $tugas['deleted_at'] = now();
                        $tugas->save();
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function getMonths(): Generator {
        $size = count(range(1, Carbon::MONTHS_PER_YEAR));
        for ($i = 1; $i <= $size; $i++) {
            $human = DateTime::createFromFormat('!m', $i)->format('F'); // https://stackoverflow.com/a/18467892/6056864

            yield $human;
        }
        dd($human);
    }
}
