<?php

namespace App\Filament\Resources\InventarisResource\Pages;

use App\Filament\Resources\InventarisResource;
use App\Models\Inventarisbarang;
use App\Models\Ruang;
use AymanAlhattami\FilamentContextMenu\Actions\RefreshAction;
use AymanAlhattami\FilamentContextMenu\ContextMenuDivider;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use AymanAlhattami\FilamentContextMenu\Traits\PageHasContextMenu;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class ManageInventaris extends ManageRecords implements HasShieldPermissions
{
    use LivewireAlert;
    use PageHasContextMenu;
    protected static string $resource = InventarisResource::class;

    public $ruang;

    public function mount(): void {
        $this->ruang = Ruang::get();
    }

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

    public static function getContextMenuActions(): array
    {
        return [
            RefreshAction::make(),
            ContextMenuDivider::make(),
            \Filament\Actions\CreateAction::make()
                ->link()
                ->icon('heroicon-m-pencil-square')
                ->color('grey')
                ->model(Ruang::class)
                ->form([
                TextInput::make('name')
                    ->required(),
                // ...
                ]),

        ];
    }
    public function getTabs(): array
    {
        $data = ['all' => Tab::make('Semua')->badge(Inventarisbarang::query()->count())
        ->badgeColor('success')];
        $ruangs = Ruang::all();
        foreach ($ruangs as $key => $ruang) {
            $data[$ruang['nama']] = Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('ruang_id', $ruang['id']))
            ->badge(Inventarisbarang::query()->where('ruang_id', $ruang['id'])->count())
            ->badgeColor('success');
        }
        // dd($data);
        return $data;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'active';
    }

    public function getTitle(): string
    {
        return 'Inventaris BMN';
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\Action::make('scanQR')->label('Scan QR')
    //             ->closeModalByClickingAway(false)
    //             ->modalContent(fn (Action $action): View => view(
    //                 'partials.scanqrmodal',
    //                 ['action' => $action],
    //             ))
    //             // ->modalContent(view('partials.scanqrmodal'))
    //             ->modalHeading(false)
    //             ->registerModalActions([
    //                 Actions\Action::make('startScanQR')->label('Mulai Scan')
    //                     ->action(function () {
    //                         $this->dispatch('scanQR');
    //                     }),
    //             ]),
    //     ];
    // }

    public function getHeader(): ?View
    {
        return view('partials.inventaris-header');
    }

    public function scanQr($kode)
    {
        $cek = Inventarisbarang::where('qr_path', $kode.'.png')->first();
        if ($cek != null) {
            $this->dispatch('startQR');
            $this->alert(
                'success',
                '',
                [
                    'position' => 'center',
                    'timer' => null,
                    'toast' => false,
                    'imageUrl' => url('storage/'.$cek['photo_path']),
                    'imageWidth' => 400,
                    'imageHeight' => 200,
                    'imageAlt' => $cek['nama'],
                    'html' => 'Merk '. $cek['merk'] .', Tahun '. $cek['tahun'] .'</br> ' .
                    'Kode '. $cek['kode'] .'</br>' .
                    'Kondisi ' . $cek['kondisi'],
                ]
            );
            // $this->dispatch('swal',
            //     title: $cek['nama'],
            //     imageUrl: url('public/storage/'.$cek['photo_path']),
            //     imageWidth: 400,
            //     imageHeight: 200,
            //     imageAlt: $cek['nama'],
            //     html: 'Merk '. $cek['merk'] .', Tahun '. $cek['tahun'] .'</br> ' .
            //     'Kode '. $cek['kode'] .'</br>' .
            //     'Kondisi ' . $cek['kondisi'],
            // );
        } else {
            $this->alert('error', 'Barang Tidak Terdaftar!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
               ]);
            $this->dispatch('startQR');
            // $this->dispatch('swal',
            //     title: 'Barang Tidak Terdaftar!',
            //     // 'timer' => 3000,
            //     customClass: [
            //         'confirmButton' => 'btn btn-primary'
            //     ],
            //     icon: 'error',
            //     buttonsStyling: false
            // );
        }

    }

    public function ruangAction(): Action {
        return Actions\Action::make('ruang')->label('Ruang')
        ->closeModalByClickingAway(false)
        ->modalSubmitAction(false)
        ->color('breaker')
        ->modalContent(fn (): View => view(
            'partials.ruangList',
            ['records' => $this->ruang],
        ))
        ;
    }
}
