<?php

namespace App\Filament\Resources\AdministrasiPidumResource\Pages;

use App\Filament\Resources\AdministrasiPidumResource;
use App\Models\TahapanAdministrasi;
use App\Models\TahapanPerkara;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ManageAdministrasiPidums extends ManageRecords
{
    protected static string $resource = AdministrasiPidumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tahapan Perkara')
                ->modalHeading('Tambah Tahapan Perkara')
                ->modalSubmitActionLabel('Tambah')
                ->closeModalByClickingAway(false)
                ->using(function (array $data) {
                    // foreach ($data['administrasi'] as $key => $item){
                    //     $data['administrasi_pidum_id'] = $item;
                    //     $model::create($data);
                    // }
                    // dd($data);
                    $data['tahapan_perkara_id'] = $data['tahap'];
                    TahapanAdministrasi::create($data);
                })
                ->successNotificationTitle('Tahap dan Berkas Administrasi Ditambahkan')
                ,
        ];
    }
    // public function getTabs(): array
    // {
    //     $data = ['all' => Tab::make('Semua')->badge(TahapanAdministrasi::query()->count())
    //     ->badgeColor('success')];
    //     $tahapan = TahapanPerkara::all();
    //     foreach ($tahapan as $key => $tahap) {
    //         $data[$tahap['tahap']] = Tab::make()
    //         ->modifyQueryUsing(fn (Builder $query) => $query->where('tahapan_perkara_id', $tahap['id']))
    //         ->badge(TahapanAdministrasi::query()->where('tahapan_perkara_id', $tahap['id'])->count())
    //         ->badgeColor(fn () =>
    //             TahapanAdministrasi::query()->where('tahapan_perkara_id', $tahap['id'])->count() < 1 ? 'danger' : 'success'
    //         );
    //     }
    //     return $data;
    // }
    public function getTitle(): string
    {
        return 'Tahapan Administrasi';
    }
}
