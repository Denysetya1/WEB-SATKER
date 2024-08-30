<?php

namespace App\Filament\Resources\PemeriksaanPidsusResource\Pages;

use App\Filament\Resources\PemeriksaanPidsusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePemeriksaanPidsuses extends ManageRecords
{
    protected static string $resource = PemeriksaanPidsusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Saksi')
                ->modalHeading('Tambah Data Saksi')
                ->modalSubmitActionLabel('Tambah')
                ->createAnother(false)
                ->closeModalByClickingAway(false)
                ->successNotificationTitle('Data Saksi Ditambahkan')
                ->stickyModalHeader()
                ->stickyModalFooter(),
        ];
    }
    public function getTitle(): string
    {
        return 'Pemeriksaan Pidsus';
    }
}
