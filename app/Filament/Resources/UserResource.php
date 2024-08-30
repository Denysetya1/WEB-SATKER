<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Bidang;
use App\Models\Desstruktur;
use App\Models\Jabatan;
use App\Models\Pangkat;
use App\Models\Pegawai;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Management Akun';
    protected static ?string $navigationLabel = 'Management Akun';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->unique()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'NIP Wajib Diisi.',
                        'unique' => 'NIP Sudah Digunakan.',
                    ]),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique()
                    ->maxLength(255)
                    ->endsWith(['@kejaksaan.go.id'])
                    ->validationMessages([
                        'email' => 'Gunakan Email Valid.',
                        'required' => 'Email Wajib Diisi.',
                        'unique' => 'Email Sudah Digunakan.',
                        'endsWith' => 'Email Wajib menggunakan @kejaksaan.go.id',
                    ]),
                // Forms\Components\TextInput::make('password')
                //     ->password()
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Toggle::make('active')
                //     ->required(),
                // Forms\Components\Select::make('roles')
                //     ->relationship('roles', 'name',
                //         modifyQueryUsing: function (Builder $query, User $user) {
                //             if ($user->hasRole(['admin', 'pegawai'])) {
                //                 $query->whereNot('name', 'super_admin');
                //             }
                //         }
                //     )
                //     ->multiple()
                //     ->required()
                //     ->preload()
                //     ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_path')->label('Photo')
                    ->default(asset('images/avatar_default.png'))
                    ->circular()
                    ->simpleLightbox()
                    ->wrap(),
                \LaraZeus\Popover\Tables\PopoverColumn::make('name')->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->trigger('hover') // support click and hover
                    ->placement('right') // for more: https://alpinejs.dev/plugins/anchor#positioning
                    ->offset(10) // int px, for more: https://alpinejs.dev/plugins/anchor#offset
                    ->popOverMaxWidth('none')
                    ->icon('heroicon-o-chevron-right')
                    ->content(fn($record) => view('partials.popover-user', ['record' => $record])),
                Tables\Columns\TextColumn::make('nip')->label('NIP')
                    ->searchable()
                    ->sortable()
                    ->default(0),
                Tables\Columns\TextColumn::make('pegawai.no_nrp')->label('NRP')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->limit(15)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-c-check')
                    ->offIcon('heroicon-c-x-mark')
                    ->sortable()
                    ->tooltip(fn (Model $record) => $record->active ? 'Nonaktifkan' : 'Aktifkan')
                    ->afterStateUpdated(function ($state) {
                        if($state == true){
                            Notification::make()
                                ->success()
                                ->title('Akun Di Aktifkan')
                                ->send();
                        } else {
                            Notification::make()
                                ->danger()
                                ->title('Akun Di Nonaktifkan')
                                ->send();
                        }
                    }),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')
                    ->default('pegawai')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'pegawai' => 'Pegawai',
                        'admin' => 'Admin',
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make('editUser')
                    ->tooltip('Edit Profile Pegawai')
                    ->modalHeading('Update Profile Pegawai')
                    ->iconButton()
                    ->mutateRecordDataUsing(function (array $data, User $user): array {
                        $data['no_nip'] = $user->pegawai->no_nip;
                        $data['no_nrp'] = $user->pegawai->no_nrp;
                        $data['no_hp'] = $user->pegawai->no_hp;
                        $data['profile_photo_path'] = $user->profile_photo_path;
                        $data['jabatan'] = $user->pegawai->jabatan;
                        $data['tgl_masuk_pertama'] = $user->pegawai->tgl_masuk_pertama;
                        $data['jabatan_id'] = $user->pegawai->jabatan_id;
                        $data['pangkat_id'] = $user->pegawai->pangkat_id;
                        $data['struktural'] = $user->pegawai->struktural->desstruktur_id;
                        $data['bidang_id'] = $user->pegawai->bidang_id;
                        $data['jenis_kelamin'] = $user->pegawai->jenis_kelamin;
                        $data['tempat_lahir'] = $user->pegawai->tempat_lahir;
                        $data['tanggal_lahir'] = $user->pegawai->tanggal_lahir;
                        $data['prov_asal'] = $user->pegawai->prov_asal;
                        $data['kota_asal'] = $user->pegawai->kota_asal;
                        $data['alamat_asal'] = $user->pegawai->alamat_asal;

                        return $data;
                    })
                    ->form([
                        Grid::make([
                            'default' => 6,
                        ])
                        ->schema([
                            Section::make('Foto Pegawai')
                                ->schema([
                                    FileUpload::make('profile_photo_path')
                                        ->label('Foto Latar Kuning')
                                        ->directory('foto-pegawai')
                                        ->image()
                                        ->optimize('webp')
                                        ->resize(50)
                                        ->imagePreviewHeight('200')
                                        ->loadingIndicatorPosition('left')
                                        ->panelLayout('integrated')
                                        ->removeUploadedFileButtonPosition('right')
                                        ->uploadButtonPosition('left')
                                        ->uploadProgressIndicatorPosition('left')
                                        ->columnSpan(4),
                                ])
                                ->columnSpan(['default' => 6, 'sm' => 2]),
                            Tabs::make('Tabs')
                                ->tabs([
                                    Tabs\Tab::make('Identitas')
                                        ->schema([
                                            Grid::make([
                                                'default' => 8
                                            ])
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nama Lengkap dan Gelar')
                                                    ->required(!Auth::user()->hasRole('super_admin'))
                                                    ->validationMessages([
                                                        'required' => 'Nama Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(['default' => 8]),
                                                TextInput::make('email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required(!Auth::user()->hasRole('super_admin'))
                                                    ->validationMessages([
                                                        'email' => 'Gunakan Email Valid.',
                                                        'required' => 'Email Wajib Diisi.',
                                                        'unique' => 'Email Sudah Digunakan.',
                                                    ])
                                                    ->columnSpan(['default' => 8, 'sm' => 8, 'md' => 5]),
                                                TextInput::make('no_hp')
                                                    ->label('No. WA')
                                                    ->tel()
                                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                    ->required(!Auth::user()->hasRole('super_admin'))
                                                    ->unique(table: Pegawai::class, ignorable: function(User $user){
                                                        return Pegawai::where('user_id', '=', $user->id)->first();
                                                    })
                                                    ->validationMessages([
                                                        'required' => 'No WA Wajib Diisi.',
                                                        'unique' => 'No. WA Sudah Digunakan.',
                                                    ])
                                                    ->columnSpan(['default' => 8, 'md' => 3]),
                                                TextInput::make('no_nip')
                                                    ->label('NIP')
                                                    ->required(!Auth::user()->hasRole('super_admin'))
                                                    ->unique(table: Pegawai::class, ignorable: function(User $user){
                                                        return Pegawai::where('user_id', '=', $user->id)->first();
                                                    })
                                                    ->validationMessages([
                                                        'required' => 'NIP Wajib Diisi.',
                                                        'unique' => 'NIP Sudah Digunakan.',
                                                    ])
                                                    ->columnSpan(['default' => 8, 'sm' => 5]),
                                                TextInput::make('no_nrp')
                                                    ->label('NRP')
                                                    ->required(!Auth::user()->hasRole('super_admin'))
                                                    ->unique(table: Pegawai::class, ignorable: function(User $user){
                                                        return Pegawai::where('user_id', '=', $user->id)->first();
                                                    })
                                                    ->validationMessages([
                                                        'required' => 'NRP Wajib Diisi.',
                                                        'unique' => 'NRP Sudah Digunakan.',
                                                    ])
                                                    ->columnSpan(['default' => 8, 'sm' => 3]),
                                            ])
                                        ]),
                                    Tabs\Tab::make('Kepangkatan')
                                        ->schema([
                                            Grid::make([
                                                'default' => 12,
                                            ])
                                            ->schema([
                                                TextInput::make('jabatan')
                                                    ->label('Jabatan Pada SK Terakhir')
                                                    ->validationMessages([
                                                        'required' => 'Jabatan Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(['default' => 12, 'sm' => 8]),
                                                DatePicker::make('tgl_masuk_pertama')->label('TMT SK')
                                                    ->native(false)
                                                    ->displayFormat('d F Y')
                                                    ->columnSpan(['default' => 12, 'sm' => 4]),
                                                Select::make('jabatan_id')
                                                    ->label('Golongan Jabatan (TU/Jaksa)')
                                                    ->validationMessages([
                                                        'required' => 'Golongan Wajib Diisi.',
                                                    ])
                                                    ->options(Jabatan::query()->pluck('deskripsi', 'id'))
                                                    ->live()->native(false)
                                                    ->placeholder('Pilih Golongan Jabatan')
                                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                        if($get('pangkat_id') != null){
                                                            $pangkat = Pangkat::find($get('pangkat_id'));
                                                            if($state == 1 && $get('pangkat_id') > 17){
                                                                $change = Pangkat::where([['golongan', $pangkat['golongan']], ['id', '!=', $pangkat['id']], ['jenis', 'tu']])->first();
                                                                $set('pangkat_id', $change['id']);
                                                            } elseif(($state == 2 OR $state == 3) && $get('pangkat_id') < 18){
                                                                $change = Pangkat::where([['golongan', $pangkat['golongan']], ['id', '!=', $pangkat['id']], ['jenis', 'jaksa']])->first();
                                                                $set('pangkat_id', $change['id']);
                                                            }
                                                        }
                                                    })
                                                    ->columnSpan(['default' => 12, 'sm' => 6]),
                                                Select::make('pangkat_id')->native(false)
                                                    ->label('Pangkat')
                                                    ->validationMessages([
                                                        'required' => 'Pangkat Wajib Diisi.',
                                                    ])
                                                    ->placeholder('Pilih Pangkat')
                                                    ->options(
                                                        function (Get $get) {
                                                            if($get('jabatan_id') != null){
                                                                if($get('jabatan_id') == 1){
                                                                    return Pangkat::where('jenis', 'tu')->get()->mapWithKeys(function ($pangkat) {
                                                                        return [$pangkat->id => $pangkat->golongan . ' - ' . $pangkat->nama_gol];
                                                                    })->toArray();
                                                                } elseif($get('jabatan_id') == 2 OR $get('jabatan_id') == 3) {
                                                                    return Pangkat::where('jenis', 'jaksa')->get()->mapWithKeys(function ($pangkat) {
                                                                        return [$pangkat->id => $pangkat->golongan . ' - ' . $pangkat->nama_gol];
                                                                    })->toArray();
                                                                }
                                                            } else {
                                                                return [null => 'Pilih Golongan Jabatan Terlebih Dahulu'];
                                                            }
                                                        })->helperText(new HtmlString
                                                            ('<p wire:loading.flex wire:target="mountedActionsData.0.jabatan_id" class="text-warning" wire:ignore>
                                                                Loading...
                                                            </p>')
                                                        )
                                                    ->searchable()
                                                    ->columnSpan(['default' => 12, 'sm' => 6]),
                                                Select::make('struktural')->native(false)
                                                    ->label('Struktural')
                                                    ->validationMessages([
                                                        'required' => 'Struktural Wajib Diisi.',
                                                    ])
                                                    ->placeholder('Pilih Struktural')
                                                    ->options(function (Get $get, User $user) {
                                                        if ($user->pegawai->struktural){
                                                            if($user->pegawai->jabatan_id == 1){
                                                                return Desstruktur::query()->where('id', '=', 5)->pluck('deskripsi', 'id')->toArray();
                                                            } else {
                                                                return Desstruktur::query()->pluck('deskripsi', 'id')->toArray();
                                                            }
                                                        }
                                                        if($get('jabatan_id') != null){
                                                            if($get('jabatan_id') == 1){
                                                                return Desstruktur::query()->where('id', '=', 5)->pluck('deskripsi', 'id')->toArray();
                                                            } elseif($get('jabatan_id') == 2 OR $get('jabatan_id') == 3) {
                                                                return Desstruktur::query()->pluck('deskripsi', 'id')->toArray();
                                                            }
                                                        } else {
                                                            return [null => 'Pilih Golongan Jabatan Terlebih Dahulu'];
                                                        }
                                                    })->columnSpan(['default' => 12, 'sm' => 6]),
                                                Select::make('bidang_id')->label('Bidang')
                                                    ->validationMessages([
                                                        'required' => 'Bidang Wajib Diisi.',
                                                    ])
                                                    ->placeholder('Pilih Bidang')
                                                    ->options(Bidang::query()
                                                    ->pluck('deskripsi', 'id'))
                                                    ->live()->native(false)
                                                    ->columnSpan(['default' => 12, 'sm' => 6]),

                                            ]),
                                        ]),
                                    Tabs\Tab::make('Biodata')
                                        ->schema([
                                            Grid::make([
                                                'default' => 12,
                                            ])
                                            ->schema([
                                                Select::make('jenis_kelamin')->label('Jenis Kelamin')
                                                    ->validationMessages([
                                                        'required' => 'Jenis Kelamin Wajib Diisi.',
                                                    ])
                                                    ->options([
                                                        'L' => 'Laki - Laki',
                                                        'P' => 'Perempuan'
                                                    ])
                                                    ->placeholder('Pilih Jenis Kelamin')
                                                    ->native(false)
                                                    ->columnSpan(['default' => 12]),
                                                TextInput::make('tempat_lahir')->label('Kota Lahir')
                                                    ->validationMessages([
                                                        'required' => 'Kota Lahir Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(['default' => 12, 'md' => 7]),
                                                DatePicker::make('tanggal_lahir')->native(false)
                                                    ->validationMessages([
                                                        'required' => 'Tanggal Lahir Wajib Diisi.',
                                                    ])
                                                    ->displayFormat('d F Y')
                                                    ->columnSpan(['default' => 12, 'md' => 5]),
                                                TextInput::make('prov_asal')
                                                    ->label('Provinsi Asal')
                                                    ->validationMessages([
                                                        'required' => 'Provinsi Asal Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(['default' => 12, 'md' => 6]),
                                                TextInput::make('kota_asal')
                                                    ->label('Kota Asal')
                                                    ->validationMessages([
                                                        'required' => 'Kota Asal Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(['default' => 12, 'md' => 6]),
                                                TextInput::make('alamat_asal')
                                                    ->label('Alamat Asal')
                                                    ->validationMessages([
                                                        'required' => 'Alamat Asal Wajib Diisi.',
                                                    ])
                                                    ->columnSpan(12),
                                            ]),
                                        ]),
                                ])
                                ->columnSpan(['default' => 6, 'sm' => 4])
                                ->persistTab()
                                ->id('identitas-tabs'),
                        ]),
                    ])->using(function (Model $record, array $data): Model {
                        $data['nip'] = $data['no_nip'];
                        $record->update($data);
                        $record->pegawai->update($data);

                        return $record;
                    }),
                Tables\Actions\EditAction::make('updatePassword')
                    ->tooltip('Update Password')
                    ->modalHeading('Update Password')
                    ->icon('heroicon-c-key')
                    ->iconButton()
                    ->color('wisteria')
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label(__('Password Baru'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->rules(
                                [Password::min(8)
                                    ->mixedCase()
                                    ->numbers()
                                    ->symbols()
                                    ->letters()]
                            )
                            ->autocomplete('new-password')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation')
                            ->validationAttribute('Password')
                            ->validationMessages([
                                'required' => 'Password Wajib Diisi.',
                                'mixedCase' => 'Password Wajib Menggunakan Huruf Besar dan Kecil.',
                                'letters' => 'Password Wajib Menggunakan Minimal 1 huruf.',
                                'numbers' => 'Password Wajib Menggunakan Minimal 1 Angka.',
                                'symbols' => 'Password Wajib Menggunakan Minimal 1 Symbol.',
                                'min' => 'Password Minimal 8 karakter.',
                            ]),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->label(__('Password Konfirmasi'))
                            ->password()
                            ->same('password')
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            // ->visible(fn (Get $get): bool => filled($get('password')))
                            ->dehydrated(false)
                            ->validationMessages([
                                'same' => 'Password Konfirmasi Tidak Sesuai.',
                            ]),
                    ])
                    ->modalWidth(MaxWidth::Small)
                    ->closeModalByClickingAway(false)
                    // ->mutateFormDataUsing(function (array $data): array {
                    //     $data['password'] = Hash::make($data['new_password']);

                    //     return $data;
                    // })
                    ->successNotification(
                        Notification::make()
                             ->success()
                             ->title('Password Berhasil Di Update'),
                     ),
                Tables\Actions\EditAction::make('updateRole')
                    ->tooltip('Update Role')
                    ->modalHeading('Update Role')
                    ->icon('heroicon-c-user')
                    ->iconButton()
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name',
                            modifyQueryUsing: function (Builder $query, User $user) {
                                if ($user->hasRole(['admin', 'pegawai'])) {
                                    $query->whereNot('name', 'super_admin');
                                }
                            }
                        )
                        ->multiple()
                        ->preload()
                        ->searchable()
                    ])
                    ->modalWidth(MaxWidth::Small)
                    ->closeModalByClickingAway(false)
                    // ->mutateFormDataUsing(function (array $data): array {
                    //     $data['password'] = Hash::make($data['new_password']);

                    //     return $data;
                    // })
                    ->successNotification(
                        Notification::make()
                             ->success()
                             ->title('Role Berhasil Di Update'),
                     ),
                Tables\Actions\DeleteAction::make('deleteUser')
                    ->iconButton()
                    ->tooltip('Hapus Akun'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
