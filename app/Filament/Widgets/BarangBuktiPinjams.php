<?php

namespace App\Filament\Widgets;

use App\Models\BarangBuktiPinjam;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class BarangBuktiPinjams extends BaseWidget
{
    public $saksi, $id;
    protected static bool $isDiscovered = false;
    protected static ?string $modelLabel = 'Barang Bukti';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                BarangBuktiPinjam::query()->where('identitas_saksi_id', $this->id)
            )
            ->heading(false)
            ->headerActions([
                Tables\Actions\CreateAction::make('addBB')
                    ->label('Tambah BB')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Tambah BB')
                    ->modalSubmitActionLabel('Tambah')
                    ->form(BarangBuktiPinjam::getForm())
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->using(function (array $data, string $model): Model {
                        return $model::create($data);
                    })
                    ,
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_bb')
                        ->label('Nama Barang Bukti')
                        ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                        ->searchable(),
                Tables\Columns\TextColumn::make('tgl_pinjam')
                        ->label('Tanggal Pinjam')
                        ->date('d F Y')
                        ->sortable(),
                Tables\Columns\CheckboxColumn::make('status_ada')
            ]);
    }
}
