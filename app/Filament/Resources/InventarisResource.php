<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages;
use App\Filament\Resources\InventarisResource\RelationManagers;
use App\Livewire\NotifAlert;
use App\Models\Inventarisbarang;
use App\Models\Jumlahbarang;
use App\Models\Ruang;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Carbon\Carbon;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid as ComponentsGrid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists;
use Filament\Infolists\Components\Grid as InfolistsComponentsGrid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class InventarisResource extends Resource implements HasShieldPermissions
{
    use LivewireAlert;
    protected static ?string $model = Inventarisbarang::class;
    protected static ?string $modelLabel = 'Inventaris';
    protected static ?string $navigationLabel = 'Inventaris BMN';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected ?string $ruang = Ruang::class;
    // protected static ?string $slug = 'inventaris';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistsComponentsGrid::make([
                    'default' => 8,
                ])
                ->schema([
                    ComponentsSection::make('Foto QR')
                        ->schema([
                            ViewEntry::make('qr_path')
                                // ->disk('qr')
                                // ->extraImgAttributes([
                                //     'alt' => 'Foto QR',
                                //     'loading' => 'lazy',
                                // ])
                                ->view('partials.qr-image-view')
                        ])->columnSpan(3),
                    ComponentsSection::make('Foto Barang')
                        ->schema([
                            ImageEntry::make('photo_path')->label('')
                                ->height('16rem')
                                ->alignment(Alignment::Center)
                                ->extraImgAttributes([
                                    'alt' => 'Foto Barang',
                                    'loading' => 'lazy',
                                ])
                                ->extraAttributes(['class' => 'justify-center'])
                        ])->columnSpan(5),
                    ComponentsSection::make('Detail Barang')
                        ->schema([
                            InfolistsComponentsGrid::make([
                                'default' => 6,
                            ])
                            ->schema([
                                TextEntry::make('nama')->label('Nama Barang')->columnSpan(['sm' => 6,'xl' => 3]),
                                TextEntry::make('kode')->label('Kode Barang')->columnSpan(['sm' => 6,'xl' => 3]),
                                TextEntry::make('merk')->label('Merk/Type')->columnSpan(['sm' => 6,'xl' => 3]),
                                TextEntry::make('tahun')->label('Tahun Pengadaan')->columnSpan(['sm' => 3,'xl' => 2]),
                                TextEntry::make('nup')->label('NUP')->columnSpan(['sm' => 3,'xl' => 1]),
                                TextEntry::make('jumlah')->label('Jumlah')->columnSpan(['sm' => 2,'xl' => 2]),
                                TextEntry::make('kondisi')->label('Kondisi')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                    })
                                    ->columnSpan(['sm' => 2,'xl' => 2]),
                                TextEntry::make('ruang.nama')->label('Ruang')->columnSpan(['sm' => 2,'xl' => 2]),
                            ]),
                        ])->columnSpan(8),
                ]),
                // Infolists\Components\TextEntry::make('nama'),
            ]);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nama Ruangan')
                    ->description('Ruang Tempat Barang Berada')
                    ->aside()
                    ->schema([
                        Select::make('ruang_id')->relationship('ruang', 'nama')->native(false)
                            ->label('Pilih Ruang')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->getSearchResultsUsing(fn (string $search): array => Ruang::where('nama', 'like', "%{$search}%")->limit(50)->pluck('nama', 'id')->toArray())
                            ->getOptionLabelUsing(fn ($value): ?string => Ruang::find($value)?->name),
                    ]),
                ComponentsGrid::make([
                        'default' => 8,
                    ])
                    ->schema([
                        Section::make('Foto Barang')
                            ->schema([
                                FileUpload::make('photo_path')
                                    ->directory('foto-barang')
                                    ->label('Foto Barang')
                                    ->image()
                                    ->optimize('webp')
                                    ->resize(50)
                                    // ->maxSize(1024)
                                    ->imagePreviewHeight('375')
                                    ->loadingIndicatorPosition('left')
                                    ->panelLayout('integrated')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->required()
                            ])->columnSpan(3),
                        Section::make('Detail Barang')
                            ->schema([
                                ComponentsGrid::make([
                                    'default' => 6,
                                ])
                                ->schema([
                                    TextInput::make('nama')->label('Nama Barang')->live(onBlur: true)->required()->columnSpan(6)
                                        ->afterStateUpdated(function (String $operation, $state, Set $set) {
                                            if($operation === 'edit' ){
                                                return;
                                            }
                                            $slug = Str::slug($state);
                                            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                            $charactersNumber = strlen($characters);
                                            $code = '';
                                            while (strlen($code) < 6) {
                                                $position = rand(0, $charactersNumber - 1);
                                                $character = $characters[$position];
                                                $code = $code.$character;
                                            }
                                            $code = $slug.'_'.$code;
                                            $cek = Inventarisbarang::where('qr_path', $code)->first();
                                            if($cek) {
                                                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                $charactersNumber = strlen($characters);
                                                $code = '';
                                                while (strlen($code) < 6) {
                                                    $position = rand(0, $charactersNumber - 1);
                                                    $character = $characters[$position];
                                                    $code = $code.$character;
                                                }
                                                $code = $slug.'_'.$code;
                                            }
                                            $set('qr_path', $code);
                                        }),
                                    TextInput::make('qr_path')->label('QR')->required()->columnSpan(6)->readOnly()
                                        ->helperText(new HtmlString('
                                                <p class="font-semibold text-sm text-custom-600 dark:text-custom-400" style="--c-400:var(--danger-400);--c-600:var(--danger-600);">*Terisi Otomatis</p>
                                                <p wire:loading.flex wire:target="mountedTableActionsData.0.nama" class="text-warning" wire:ignore>
                                                    <x-base.loading-icon
                                                        class="w-2 h-2 text-warning"
                                                        icon="ball-triangle"
                                                    />Loading...
                                                </p>
                                            ')),
                                    TextInput::make('kode')->label('Kode Barang')->required()->columnSpan(6),
                                    TextInput::make('merk')->label('Merk/Type')->required()->columnSpan(4),
                                    TextInput::make('tahun')->label('Tahun Pengadaan')->required()->columnSpan(2),
                                    TextInput::make('nup')->label('NUP')->required()->columnSpan(2),
                                    TextInput::make('jumlah')->label('Jumlah')->required()->columnSpan(2),
                                    Select::make('kondisi')->native(false)
                                        ->label('Kondisi Barang')
                                        ->required()
                                        ->options([
                                            'Baik' => 'Baik',
                                            'Rusak Ringan' => 'Rusak Ringan',
                                            'Rusak Berat' => 'Rusak Berat',
                                        ])
                                        ->searchable()
                                        ->preload()
                                        ->default('Baik')
                                        ->selectablePlaceholder(false)
                                        ->columnSpan(2),
                                ]),
                            ])->columnSpan(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Inventaris')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Input Barang Inventaris')
                    ->modalSubmitActionLabel('Tambah')
                    ->createAnother(false)
                    ->action(function (array $data) {
                        // dd($data);
                        $data['qr_path'] = $data['qr_path'].'.png';
                        $qrpath = public_path('storage/Photo-QR/'.$data['qr_path']);
                        QrCode::format('png')->style('round')->eye('circle')->generate($data['qr_path'], $qrpath);
                        $jumlahbrng = Jumlahbarang::whereHas('tahun', function ($query) {
                            $query->where('tahun', now()->format('Y'));
                        })->where('bulan', now()->format('m'))->first();
                        $jumlahbrng['jumlah'] = $jumlahbrng['jumlah']+1;
                        $jumlahbrng->save();
                        Inventarisbarang::create($data);
                        Notification::make()
                            ->success()
                            ->title('Barang Berhasil Ditambahkan')
                            ->seconds(2)
                            // ->persistent()
                            ->send();
                    }),
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('ruang.nama')
                        ->extraAttributes(['class' => 'mb-2'])
                        ->badge()
                        ->alignCenter()
                        ->weight(FontWeight::Light)
                        ->size(TextColumnSize::Small)
                        ->color('primary'),
                    ImageColumn::make('photo_path')
                        ->simpleLightbox()
                        ->height(160),
                    TextColumn::make('nama')
                        ->searchable()
                        ->extraAttributes(['class' => 'mt-2'])
                        ->alignCenter()
                        ->weight(FontWeight::Bold)
                        ->size(TextColumnSize::Small)
                        ->limit(25)
                        ->tooltip(function (TextColumn $column): ?string {
                            $state = $column->getState();
                            if (strlen($state) <= $column->getCharacterLimit()) {
                                return null;
                            }
                            return $state;
                        }),
                    TextColumn::make('merk')
                        ->alignCenter()
                        ->searchable()
                        ->weight(FontWeight::Light)
                        ->size(TextColumnSize::Small),
                    BadgeableColumn::make('kode')
                        ->alignCenter()
                        ->weight(FontWeight::Light)
                        ->size(TextColumnSize::Small)
                        ->suffixBadges([
                            Badge::make('hot')
                                ->label(fn(Model $record) => $record->kondisi)
                                ->color(function(Model $record) {
                                    return match ($record->kondisi) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                    };
                                }),
                        ])->asPills(),
                ])
            ])
            ->contentGrid(['md' => 3, 'xl' => 4])
            ->emptyStateHeading('Belum Ada Barang Inventaris')
            ->emptyStateDescription('Setelah Menambahkan Barang Inventaris, Barang Inventaris akan muncul di sini.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Tambah Inventaris'),
            ])
            ->extremePaginationLinks()
            ->deferLoading()
            ->recordClasses(fn (Model $record) => match ($record->kondisi) {
                'Baik' => 'bg-success-10',
                'Rusak Ringan' => 'bg-warning-10',
                'Rusak Berat' => 'bg-danger-10',
                default => null,
            })
            ->filters([
                SelectFilter::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat',
                    ])->native(false),
                Filter::make('tahun')
                    ->form([
                        \Filament\Forms\Components\Grid::make([
                            'default' => 2,
                        ])
                            ->schema([
                                DatePicker::make('tahun_form')->label('Tahun Mulai')
                                    ->format('Y')
                                    ->displayFormat('Y')
                                    ->native(false),
                                DatePicker::make('tahun_until')->label('Tahun Akhir')
                                    ->format('Y')
                                    ->displayFormat('Y')
                                    ->native(false),
                            ])
                        // Section::make('Tahun Pengadaan')
                        //     ->description('Rentang Tahun Pengadaan. Gunakan Tahun Mulai untuk mencari pada 1 tahun saja')
                        //     ->schema([
                        //     ])->columnSpanFull(),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['tahun_form'] ?? null) {
                            if ($data['tahun_until'] ?? null) {
                                $indicators[] = Indicator::make('Tahun Pengadaan Mulai ' . Carbon::parse($data['tahun_form'])->format('Y'))
                                    ->removeField('tahun_form');
                            } else {
                                $indicators[] = Indicator::make('Tahun Pengadaan ' . Carbon::parse($data['tahun_form'])->format('Y'))
                                    ->removeField('tahun_form');
                            }
                        }

                        if ($data['tahun_until'] ?? null) {
                            $indicators[] = Indicator::make('Tahun Pengadaan Sampai ' . Carbon::parse($data['tahun_until'])->format('Y'))
                                ->removeField('tahun_until');
                        }

                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tahun_form'],
                                fn (Builder $query, $date): Builder => $query->where('tahun', '>=', $date),
                            )
                            ->when(
                                $data['tahun_until'],
                                fn (Builder $query, $date): Builder => $query->where('tahun', '<=', $date),
                            );
                    })
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(3)
            ->filtersFormSchema(fn (array $filters): array => [
                $filters['kondisi'],
                Section::make('Tahun Pengadaan')
                    ->description('Rentang Tahun Pengadaan. Gunakan Tahun Mulai untuk mencari pada 1 tahun saja. Pilih tanggal mana saja setelah memilih tahun')
                    ->schema([
                        $filters['tahun'],
                        // $filters['tahun_until'],
                    ])->columns(1)
                    ->columnspan(2)
                    ->collapsible()
                    ->persistCollapsed(),
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->color('warning')
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\ViewAction::make('viewInventaris')
                    ->color('danube'),
                Tables\Actions\EditAction::make('editInventaris')
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger2'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->button()->label('Hapus Barang Terpilih'),
                // BulkAction::make('editQR')->button()->label('Hapus Barang Terpilih')
                //     ->action(function (Collection $records) {
                //         foreach($records as $key => $item){
                //             $item['qr_path'] = $item['qr_path'].'.png';
                //             $item->save();
                //         };
                //     }),
                BulkAction::make('downloadQR')->button()->label('Download QR')
                    ->action(function (Collection $records) {
                        $templateProcessor = new TemplateProcessor(public_path('template/print_qr.docx'));
                        foreach($records as $key => $item){
                            $files[$key] = [
                                'logo' => array('path' => public_path('images/Pagimana_Logo.png'), 'width' => 60, 'height' => 60, 'ratio' => false),
                                'qr' => array('path' => public_path('storage/Photo-QR/'.$item['qr_path']), 'width' => 60, 'height' => 60, 'ratio' => false),
                                'kode' => $item['kode']
                            ];
                        };
                        $replacements = array();
                        $i = 0;
                        foreach($files as $block_qr => $qr) {
                            $replacements[] = array(
                                'logo' => '${logo_'.$i.'}',
                                'qr' => '${qr_'.$i.'}',
                                'kode' => '${kode_'.$i.'}'
                            );

                            $i++;
                        }
                        // dd($replacements, $files);
                        $templateProcessor->cloneBlock('block_qr', count($replacements), true, false, $replacements);
                        # Table row cloning
                        $i = 0;
                        foreach($files as $key => $row) {
                            $templateProcessor->setImageValue("logo_{$key}", $row['logo']);
                            $templateProcessor->setImageValue("qr_{$key}", $row['qr']);
                            $templateProcessor->setValue("kode_{$key}", $row['kode']);
                            // $i++;
                        }
                        // dd($values);
                        $pathToSave = public_path('storage/print/print_qr.docx');
                        $templateProcessor->saveAs($pathToSave);
                        return response()->download($pathToSave);
                    })
                    ,
                // Tables\Actions\BulkActionGroup::make([
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInventaris::route('/'),
        ];
    }

    public function notif($type, $title = ''): void {
        $this->alert($type, $title, [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
        ]);
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'active';
    }

}
