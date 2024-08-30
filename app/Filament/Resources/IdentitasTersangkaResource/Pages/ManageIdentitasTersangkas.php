<?php

namespace App\Filament\Resources\IdentitasTersangkaResource\Pages;

use App\Filament\Resources\IdentitasTersangkaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIdentitasTersangkas extends ManageRecords
{
    protected static string $resource = IdentitasTersangkaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Tersangka')
                ->modalHeading('Tambah Data Tersangka')
                ->modalSubmitActionLabel('Tambah')
                ->closeModalByClickingAway(false)
                ->successNotificationTitle('Data Tersangka Ditambahkan')
                ,
        ];
    }
    public function getTitle(): string
    {
        return 'Database Tersangka';
    }
}
