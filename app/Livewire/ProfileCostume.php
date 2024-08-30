<?php

namespace App\Livewire;

use App\Models\Bidang;
use App\Models\Desstruktur;
use App\Models\Jabatan;
use App\Models\Pangkat;
use App\Models\Pegawai;
use App\Models\Struktural;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProfileCostume extends MyProfileComponent
{
    use LivewireAlert;
    protected string $view = "livewire.profile-costume";
    //
    public $user;
    public $userClass;
    public ?array $data;

    public function mount()
    {
        $this->user = User::with('pegawai')->find(Filament::getCurrentPanel()->auth()->user()->id);
        // dd($this->user->pegawai->no_nip);
        $this->data['name'] = $this->user->name;
        $this->data['email'] = $this->user->email;
        $this->data['no_nip'] = $this->user->pegawai->no_nip;
        $this->data['no_nrp'] = $this->user->pegawai->no_nrp;
        $this->data['no_hp'] = $this->user->pegawai->no_hp;
        $this->data['profile_photo_path'] = $this->user->profile_photo_path;
        $this->data['jabatan'] = $this->user->pegawai->jabatan;
        $this->data['tgl_masuk_pertama'] = $this->user->pegawai->tgl_masuk_pertama;
        $this->data['jabatan_id'] = $this->user->pegawai->jabatan_id;
        $this->data['pangkat_id'] = $this->user->pegawai->pangkat_id;
        $this->data['struktural'] = $this->user->pegawai->struktural->desstruktur_id;
        $this->data['bidang_id'] = $this->user->pegawai->bidang_id;
        $this->data['jenis_kelamin'] = $this->user->pegawai->jenis_kelamin;
        $this->data['tempat_lahir'] = $this->user->pegawai->tempat_lahir;
        $this->data['tanggal_lahir'] = $this->user->pegawai->tanggal_lahir;
        $this->data['prov_asal'] = $this->user->pegawai->prov_asal;
        $this->data['kota_asal'] = $this->user->pegawai->kota_asal;
        $this->data['alamat_asal'] = $this->user->pegawai->alamat_asal;
        $this->form->fill($this->data);
    }
    public function form(Form $form): Form
    {
        // dd($this->data);
        return $form
            ->schema([
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
                                            ->required()
                                            ->validationMessages([
                                                'required' => ':attribute Wajib Diisi.',
                                            ])
                                            ->columnSpan(['default' => 8]),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->unique()
                                            ->validationMessages([
                                                'email' => 'Gunakan Email Valid.',
                                                'required' => ':attribute Wajib Diisi.',
                                                'unique' => ':attribute Sudah Digunakan.',
                                            ])
                                            ->columnSpan(['default' => 8, 'sm' => 8, 'md' => 5]),
                                        TextInput::make('no_hp')
                                            ->label('No. WA')->tel()
                                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                            ->required()
                                            ->unique(table: Pegawai::class, column: 'no_hp',
                                                ignorable: Pegawai::where('user_id', '=', Auth::user()->id)->first()
                                                )
                                            ->validationMessages([
                                                'required' => ':attribute Wajib Diisi.',
                                                'unique' => 'No. WA Sudah Digunakan.',
                                            ])
                                            ->columnSpan(['default' => 8, 'md' => 3]),
                                        TextInput::make('no_nip')
                                            ->label('NIP')
                                            ->required()
                                            ->unique(table: Pegawai::class, ignorable: Pegawai::where('user_id', '=', Auth::user()->id)->first())
                                            ->validationMessages([
                                                'required' => ':attribute Wajib Diisi.',
                                                'unique' => 'NIP Sudah Digunakan.',
                                            ])
                                            ->columnSpan(['default' => 8, 'sm' => 5]),
                                        TextInput::make('no_nrp')
                                            ->label('NRP')
                                            ->required()
                                            ->unique(table: Pegawai::class, ignorable: Pegawai::where('user_id', '=', Auth::user()->id)->first())
                                            ->validationMessages([
                                                'required' => ':attribute Wajib Diisi.',
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
                                        TextInput::make('jabatan')->label('Jabatan Pada SK Terakhir')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Jabatan Wajib Diisi.',
                                            ])
                                            ->columnSpan(['default' => 12, 'sm' => 8]),
                                        DatePicker::make('tgl_masuk_pertama')->label('TMT SK')
                                            ->native(false)
                                            ->displayFormat('d F Y')
                                            ->columnSpan(['default' => 12, 'sm' => 4]),
                                        Select::make('jabatan_id')->label('Golongan')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Golongan Wajib Diisi.',
                                            ])
                                            ->options(Jabatan::query()->pluck('deskripsi', 'id'))
                                            ->live()->native(false)
                                            ->placeholder('Pilih Golongan')
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
                                        Select::make('pangkat_id')->native(false)->label('Pangkat')
                                            ->required()
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
                                        Select::make('struktural')->native(false)->label('Struktural')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Struktural Wajib Diisi.',
                                            ])
                                            ->placeholder('Pilih Struktural')
                                            ->options(function (Get $get) {
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
                                            ->required()
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
                                            ->required()
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
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Kota Lahir Wajib Diisi.',
                                            ])
                                            ->columnSpan(['default' => 12, 'md' => 7]),
                                        DatePicker::make('tanggal_lahir')->native(false)
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Tanggal Lahir Wajib Diisi.',
                                            ])
                                        ->displayFormat('d F Y')
                                        ->columnSpan(['default' => 12, 'md' => 5]),
                                        TextInput::make('prov_asal')
                                            ->label('Provinsi Asal')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Provinsi Asal Wajib Diisi.',
                                            ])
                                            ->columnSpan(['default' => 12, 'md' => 6]),
                                        TextInput::make('kota_asal')
                                            ->label('Kota Asal')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Kota Asal Wajib Diisi.',
                                            ])
                                            ->columnSpan(['default' => 12, 'md' => 6]),
                                        TextInput::make('alamat_asal')
                                            ->label('Alamat Asal')
                                            ->required()
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
            ])->statePath('data');
    }

    public function submit(): void
    {
        $data = collect($this->form->getState())->all();
        $struktur = Struktural::where('pegawai_id', $this->user->pegawai->id)->first();
        if($struktur){
            $data2['pegawai_id'] = $this->user->pegawai->id;
            $data2['desstruktur_id'] = $data['struktural'];
            $struktur->update($data2);
        } else {
            $data2['pegawai_id'] = $this->user->pegawai->id;
            $data2['desstruktur_id'] = $data['struktural'];
            Struktural::create($data2);
        };
        $data['nip'] = $data['no_nip'];
        $this->user->update($data);
        $this->user->pegawai->update($data);
        $this->alert('success', 'Profile Berhasil Disimpan!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
           ]);
    }
}
