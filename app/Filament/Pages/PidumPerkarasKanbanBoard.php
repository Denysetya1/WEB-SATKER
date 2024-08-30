<?php

namespace App\Filament\Pages;

use App\Enums\PidumAktivitisStatus;
use App\Events\PidumPerkaraChange;
use App\Filament\Widgets\PerkaraPidums;
use App\Models\AdministrasiPidum;
use App\Models\PerkaraPidum;
use App\Models\PidumAktiviti;
use App\Models\TahapanAdministrasi;
use App\Models\TahapanPerkara;
use App\Notifications\HapusTugasNotification;
use App\Notifications\TugasNotification;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use Livewire\Attributes\On;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class PidumPerkarasKanbanBoard extends KanbanBoard implements HasActions, HasInfolists
{
    use LivewireAlert;
    use InteractsWithActions, InteractsWithInfolists;
    protected static string $model = PidumAktiviti::class;
    protected static string $statusEnum = PidumAktivitisStatus::class;
    protected static ?string $title = 'Perkara Pidum';
    // protected static string $recordTitleAttribute = 'keterangan';
    protected static ?string $navigationLabel = 'Perkara';
    protected static ?string $navigationGroup = 'Pidum';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'perkara-pidum';
    public bool $disableEditModal = true;
    protected string $editModalTitle = 'Edit Tugas';
    // protected string $editModalWidth = '2xl';
    protected string $editModalSaveButtonLabel = 'Simpan';
    protected string $editModalCancelButtonLabel = 'Batal';
    public $search, $upload = 'file', $fileTugas = [], $perkaras;

    public function mount(): void {
        $this->perkaras = PerkaraPidum::query()->with('identitas_tersangka')->get();
    }
    #[On('refresh-Component')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }
    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         PerkaraPidums::class
    //     ];
    // }
    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
    protected function getEditModalFormSchema(null|int $recordId): array
    {
        if($this->upload == 'file'){
            return [
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Tugas')
                    ->directory('file-tugas')
                    ->moveFiles()
                    ->downloadable()
                    ->uploadingMessage('Uploading File...')
                    ->acceptedFileTypes(['application/pdf']),
                // PdfViewerField::make('file_path')
                //     ->label('File Tugas')
                //     ->minHeight('40svh')
            ];
        }
        else if ($this->upload == 'revisi'){
            return [
                Forms\Components\TextArea::make('revisi')
                        ->label('Keterangan Revisi')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                        ]),
            ];
        }
        else {
            return [
                Forms\Components\Grid::make([
                    'default' => 12
                ])
                ->schema([
                    Forms\Components\Select::make('perkara_pidum_id')
                        ->label('Perkara')
                        ->allowHtml()
                        ->preload()
                        ->placeholder('Pilih Perkara')
                        ->required()
                        ->validationMessages([
                            'required' => 'Wajib Diisi.',
                        ])
                        // ->relationship(name: 'perkara_pidum', titleAttribute: 'no_spdp', ignoreRecord: true)
                        // ->createOptionForm(IdentitasTersangka::getForm())
                        ->getSearchResultsUsing(function (string $search) {
                            $this->search = $search;
                            $promosi = PerkaraPidum::where('no_spdp', 'like', "%{$search}%")
                            ->orWhereHas('identitas_tersangka', function ($query) {
                                $query->where('nama', 'like', "%{$this->search}%");
                            })
                            ->limit(50)->get();

                            return $promosi->mapWithKeys(function ($promo) {
                                  return [$promo->getKey() => static::getCleanOptionString($promo)];
                            })->toArray();
                        })
                        ->getOptionLabelUsing(function ($value): string {
                            $promo = PerkaraPidum::find($value);

                            return static::getCleanOptionString($promo);
                        })
                        ->native(false)
                        ->searchable()
                        ->columnSpan([
                            'default' => 12,
                        ]),
                    Forms\Components\Select::make('tahapan_perkara_id')
                        ->label('Tahap')
                        ->preload()
                        ->placeholder('Pilih Tahap')
                        ->required()
                        ->validationMessages([
                            'required' => 'Wajib Diisi.',
                        ])
                        ->options(TahapanPerkara::all()->pluck('tahap', 'id'))
                        // ->relationship(name: 'tahapan_perkara', titleAttribute: 'tahap')
                        // ->createOptionForm(IdentitasTersangka::getForm())
                        ->native(false)
                        ->searchable()
                        ->live()
                        ->columnSpan([
                            'sm' => 12,
                            'md' => 4,
                        ]),
                    Forms\Components\Select::make('administrasi_pidum_id')
                        ->label('Berkas')
                        ->preload()
                        ->placeholder('Pilih Tahap')
                        ->required()
                        ->validationMessages([
                            'required' => 'Wajib Diisi.',
                        ])
                        ->options(fn (Get $get): Collection => DB::table('tahapan_administrasis')
                            ->join('administrasi_pidums', function (JoinClause $join) {
                                $join->on('tahapan_administrasis.administrasi_pidum_id', '=', 'administrasi_pidums.id');
                            })
                            ->where('tahapan_administrasis.tahapan_perkara_id', $get('tahapan_perkara_id'))
                            ->pluck('administrasi_pidums.label', 'administrasi_pidums.id')
                        )
                        // ->relationship(name: 'administrasi_pidum', titleAttribute: 'label')
                        // ->createOptionForm(IdentitasTersangka::getForm())
                        ->native(false)
                        ->searchable()
                        ->columnSpan([
                            'sm' => 12,
                            'md' => 4,
                        ]),
                    Forms\Components\DatePicker::make('deadline')
                        ->label('Tanggal Deadline Tugas')
                        ->required()
                        ->native(false)
                        ->columnSpan([
                            'sm' => 12,
                            'md' => 4,
                        ]),
                    Forms\Components\TextArea::make('keterangan')
                        ->label('Deskripsi Tugas')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                        ]),
                ])
            ];
        };
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('perkaraList')->label('Perkara')
                ->closeModalByClickingAway(false)
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->color('breaker')
                ->modalWidth(MaxWidth::SixExtraLarge)
                ->modalContent(fn (): View => view(
                    'partials.perkarasList',
                    ['records' => $this->perkaras],
                ))
            ,
            Action::make('createTugas')
                ->label('Tambah Tugas')
                ->color('info')
                ->model(PidumAktiviti::class)
                ->closeModalByClickingAway(false)
                ->modalHeading('Tambah Tugas')
                ->modalSubmitActionLabel('Tambah')
                ->form([
                    Forms\Components\Grid::make([
                        'default' => 12
                    ])
                    ->schema([
                        Forms\Components\Select::make('perkara_pidum_id')
                            ->label('Perkara')
                            ->allowHtml()
                            ->preload()
                            ->placeholder('Pilih Perkara')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib Diisi.',
                            ])
                            // ->relationship(name: 'perkara_pidum', titleAttribute: 'no_spdp', ignoreRecord: true)
                            // ->createOptionForm(IdentitasTersangka::getForm())
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                $this->search = $search;
                                $promosi = PerkaraPidum::where('no_spdp', 'like', "%{$search}%")
                                ->orWhereHas('identitas_tersangka', function ($query) {
                                    $query->where('nama', 'like', "%{$this->search}%");
                                })
                                ->limit(50)->get();

                                return $promosi->mapWithKeys(function ($promo) {
                                      return [$promo->getKey() => static::getCleanOptionString($promo)];
                                })->toArray();
                            })
                            ->getOptionLabelUsing(function ($value): string {
                                $promo = PerkaraPidum::find($value);

                                return static::getCleanOptionString($promo);
                            })
                            // ->createOptionForm(PidumAktiviti::getForm())
                            ->native(false)
                            ->columnSpan([
                                'default' => 12,
                            ]),
                        Forms\Components\Select::make('tahapan_perkara_id')
                            ->label('Tahap')
                            ->preload()
                            ->placeholder('Pilih Tahap')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib Diisi.',
                            ])
                            ->relationship(
                                name: 'tahapan_perkara',
                                titleAttribute: 'tahap',
                                ignoreRecord: true,
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('id'))
                            // ->createOptionForm(IdentitasTersangka::getForm())
                            ->native(false)
                            ->searchable()
                            ->live()
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Forms\Components\Select::make('administrasi_pidum_id')
                            ->label('Berkas')
                            ->preload()
                            ->placeholder('Pilih Tahap')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib Diisi.',
                            ])
                            // ->createOptionForm(IdentitasTersangka::getForm())
                            ->options(fn (Get $get): Collection => DB::table('tahapan_administrasis')
                                ->join('administrasi_pidums', function (JoinClause $join) {
                                    $join->on('tahapan_administrasis.administrasi_pidum_id', '=', 'administrasi_pidums.id');
                                })
                                ->where('tahapan_administrasis.tahapan_perkara_id', $get('tahapan_perkara_id'))
                                ->pluck('administrasi_pidums.label', 'administrasi_pidums.id'))
                            ->native(false)
                            ->searchable()
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Forms\Components\DatePicker::make('deadline')
                            ->label('Tanggal Deadline Tugas')
                            ->required()
                            ->native(false)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ]),
                        Forms\Components\TextArea::make('keterangan')
                            ->label('Deskripsi Tugas')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                            ]),

                    ])
                ])
                ->action(function (array $data) {
                    $data['user_id'] = auth()->id();
                    $activities = auth()->user()->pidum_aktiviti()->create($data);
                    // $activities = PidumAktiviti::create($data);
                    Notification::route('telegram', '-4245000877')->notify(new TugasNotification($activities['id']));
                    $this->alert('success', 'Tugas Baru Berhasil Dibuat', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => false,
                    ]);
                    PidumPerkaraChange::broadcast()->toOthers();
                }),
            Action::make('purgeCompletedTask')
                ->label('Hapus Tugas Selesai')
                ->color('danger')
                ->action(function () {
                    PidumAktiviti::query()->where('status', PidumAktivitisStatus::Selesai)->delete();
                    PidumPerkaraChange::broadcast()->toOthers();
                })
                ->requiresConfirmation()
                ->modalHeading('Hapus Tugas Selesai')
                ->modalDescription('Anda Yakin Ingin Menghapus Tugas Yang Sudah Selesai?')
                ->modalSubmitActionLabel('Ya')
        ];
    }
    protected function records(): Collection
    {
        return PidumAktiviti::where('deleted_at', '=' , null)->ordered()->get();
    }
    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        if (Auth::user()) {
        // if (Auth::user()->pegawai->bidang->deskripsi == 'Pidana Umum') {
            // if ($status == PidumAktivitisStatus::Proses) {
            //     PidumAktiviti::find($recordId)->update(['status' => $status, 'user_id' => Auth::id()]);
            //     $this->alert('info', 'Tugas Sedang Di Buat', [
            //         'position' => 'center',
            //         'timer' => 3000,
            //         'toast' => false,
            //     ]);
            // } else {
            // }
            $cek = PidumAktiviti::find($recordId)->pluck('status');
            if($status == 'Belum'){
                $this->alert('warning', 'Tugas Belum Di Buat', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
            } elseif($status == 'Proses'){
                if($cek[0] == 'Belum' OR $cek[0] == 'Revisi'){
                    PidumAktiviti::find($recordId)->update(['user_id' => Auth::id()]);
                }
                $this->alert('info', 'Tugas Sedang Di Buat', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
            } elseif($status == 'Selesai'){
                PidumAktiviti::find($recordId)->update(['revisi' => null]);
                PidumAktiviti::find($recordId)->update(['user_id' => Auth::id()]);
                $this->alert('success', 'Tugas Telah Di Buat', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
            } elseif($status == 'Revisi'){
                PidumAktiviti::find($recordId)->update(['user_id' => Auth::id()]);
                $this->editModalRecordId = $recordId;
                $this->upload = 'revisi';
                $this->alert('warning', 'Tugas Ada Di Revisi', [
                    'position' => 'center',
                    'timer' => 1000,
                    'toast' => false,
                ]);
                $data = $this->getEloquentQuery()->find($recordId)->toArray();
                $this->form($this->form);
                $this->form->fill($data);

                $this->dispatch('open-modal', id: 'kanban--revisi-modal');
            }
            PidumAktiviti::find($recordId)->update(['status' => $status]);
            PidumAktiviti::setNewOrder($toOrderedIds);
        } else {
            $this->alert('error', 'Maaf Hanya Staff Pidum Yang Bisa Mengubah', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
        // parent::onStatusChanged($recordId, $status, $fromOrderedIds, $toOrderedIds);
        // PidumPerkaraChange::broadcast()->toOthers();
    }
    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        PidumAktiviti::setNewOrder($orderedIds);
        $this->alert('success', 'Urutan Dirubah', [
            'position' => 'center',
            'timer' => 1000,
            'toast' => true,
        ]);
        // PidumPerkaraChange::broadcast()->toOthers();
    }
    public static function getCleanOptionString(Model $model): string
    {
        return
                view('partials.select-result')
                    ->with('no_spdp', $model?->no_spdp)
                    ->with('nama', $model?->identitas_tersangka->nama)
                    ->render()
        ;
    }
    public function editModalFormSubmitted(): void
    {
        $this->editRecord($this->editModalRecordId, $this->form->getState(), $this->editModalFormState);

        $this->editModalRecordId = null;
        $this->form->fill();

        $this->dispatch('close-modal', id: 'kanban--edit-record-modal2');
        $this->alert('success', 'Tugas Berhasil Diedit', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
        ]);
        // PidumPerkaraChange::broadcast()->toOthers();
    }
    public function uploadFileModalFormSubmitted(): void
    {
        $this->editRecord($this->editModalRecordId, $this->form->getState(), $this->editModalFormState);
        $this->editModalRecordId = null;
        $this->form->fill();

        $this->dispatch('close-modal', id: 'kanban--upload-file-modal');
        $this->alert('success', 'File Tugas Berhasil Diupload', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
        ]);
        // PidumPerkaraChange::broadcast()->toOthers();
    }
    public function revisiModalFormSubmitted(): void
    {
        $this->editRecord($this->editModalRecordId, $this->form->getState(), $this->editModalFormState);
        $this->editModalRecordId = null;
        $this->form->fill();

        $this->dispatch('close-modal', id: 'kanban--revisi-modal');
        $this->alert('success', 'Berhasil Menambahkan Revisi', [
            'position' => 'center',
            'timer' => 1500,
            'toast' => false,
        ]);
        // PidumPerkaraChange::broadcast()->toOthers();
    }
    public function editClicked(int $recordId): void
    {
        $this->editModalRecordId = $recordId;
        $this->upload = 'edit';
        /**
         * todo - the following line is a hacky fix
         * figure why sometimes form schema is created before this
         * method when a RichText is present in the form schema
         **/
        $data = $this->getEloquentQuery()->find($recordId)->toArray();
        $this->form($this->form);
        $this->form->fill($data);

        $this->dispatch('open-modal', id: 'kanban--edit-record-modal2');
    }
    public function revisiAction(): Action
    {
        return Action::make('revisi')
            ->label('Edit Ket Revisi')
            ->color('warning')
            ->size(ActionSize::Small)
            ->action(function (array $arguments) {
                $this->editModalRecordId = $arguments['record'];
                $this->upload = 'revisi';
                /**
                 * todo - the following line is a hacky fix
                 * figure why sometimes form schema is created before this
                 * method when a RichText is present in the form schema
                 **/
                $data = $this->getEloquentQuery()->find($arguments)->toArray();
                $this->form($this->form);
                $this->form->fill($data);

                $this->dispatch('open-modal', id: 'kanban--revisi-modal');
            });
    }
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label('')
            ->color('danger')
            ->iconButton()
            ->icon('heroicon-m-trash')
            ->size(ActionSize::Small)
            ->action(function (array $arguments) {
                $post = PidumAktiviti::find($arguments['record']);
                Notification::route('telegram', '-4245000877')->notify(new HapusTugasNotification($arguments['record']));
                $post->delete();
                $this->alert('success', 'Tugas Berhasil Dihapus', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
                // PidumPerkaraChange::broadcast()->toOthers();
                // $this->dispatch('refresh-Component');
            })
            ->requiresConfirmation()
            ->modalHeading('Hapus Tugas')
            ->modalDescription('Anda Yakin Menghapus Tugas?')
            ->modalSubmitActionLabel('Ya, Hapus')
            ->modalCancelActionLabel('Batal');
    }
    public function uploadAction(): Action
    {
        return Action::make('upload')
            ->label('Upload Tugas')
            ->color('info')
            // ->iconButton()
            ->icon('heroicon-m-document')
            ->size(ActionSize::Small)
            ->action(function (array $arguments) {
                $this->editModalRecordId = $arguments['record'];
                $this->upload = 'file';
                /**
                 * todo - the following line is a hacky fix
                 * figure why sometimes form schema is created before this
                 * method when a RichText is present in the form schema
                 **/
                $data = $this->getEloquentQuery()->find($arguments)->toArray();
                $this->form($this->form);
                $this->form->fill($data);

                $this->dispatch('open-modal', id: 'kanban--upload-file-modal');
            });
    }
    public function viewUploadAction(): Action
    {
        return Action::make('viewUpload')
            ->label('Lihat Tugas')
            ->color('wisteria')
            // ->iconButton()
            ->icon('heroicon-m-document')
            ->size(ActionSize::Small)
            ->action(function (array $arguments) {
                /**
                 * todo - the following line is a hacky fix
                 * figure why sometimes form schema is created before this
                 * method when a RichText is present in the form schema
                 **/
                $data = $this->getEloquentQuery()->find($arguments)->toArray();
                // $data[0]['file_path'] = Storage::url($data[0]['file_path']);
                // dd($data);
                $this->fileTugas = $data[0];
                // return response()->download(
                //     $this->invoice->file_path, 'invoice.pdf'
                // );
                $this->dispatch('open-modal', id: 'kanban--view-file-modal');
            });
    }
    public function deleteUploadAction(): Action
    {
        return Action::make('deleteUpload')
            ->label('Delete File')
            ->color('danger')
            // ->iconButton()
            ->icon('heroicon-m-trash')
            ->size(ActionSize::Small)
            ->action(function (array $arguments) {
                $post = PidumAktiviti::find($arguments['record']);
                $data['file_path'] = null;
                $post->update($data);
                $this->alert('success', 'Tugas Berhasil Dihapus', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
                // PidumPerkaraChange::broadcast()->toOthers();
            })
            ->requiresConfirmation()
            ->modalHeading('Hapus File Tugas')
            ->modalDescription('Anda Yakin Menghapus File Tugas?')
            ->modalSubmitActionLabel('Ya, Hapus')
            ->modalCancelActionLabel('Batal');
    }
    public function fileInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state($this->fileTugas)
            ->schema([
                PdfViewerEntry::make('file_path')
                    ->label('View the PDF')
                    ->minHeight('50svh')
                    // ->fileUrl(Storage::url($this->fileTugas['file_path']))
            ]);
    }
    #[On('echo:pidum-perkara-change,PidumPerkaraChange')]
    public function pidumPerkaraChanged(): void
    {

    }
}
