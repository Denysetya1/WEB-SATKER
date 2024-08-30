<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanPidsusResource\Pages;
use App\Filament\Resources\PemeriksaanPidsusResource\RelationManagers;
use App\Models\IdentitasSaksi;
use App\Models\PemeriksaanPidsus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemeriksaanPidsusResource extends Resource
{
    protected static ?string $model = IdentitasSaksi::class;
    protected static ?string $modelLabel = 'Pemeriksaan Pidsus';
    protected static ?string $navigationGroup = 'Pidsus';
    protected static ?string $navigationLabel = 'Pemeriksaan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(IdentitasSaksi::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Tables\Grouping\Group::make('perkara_pidsus.nama_kasus')
                    ->collapsible()
                    ->getTitleFromRecordUsing(fn (IdentitasSaksi $record): string => $record->perkara_pidsus[0]['nama_kasus'])
                    ->getKeyFromRecordUsing(fn (IdentitasSaksi $record): string => $record->perkara_pidsus[0]['id']),
            ])
            ->defaultGroup('perkara_pidsus.nama_kasus')
            ->groupingSettingsHidden()
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('tambahBukti')
                    ->color('danube')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Barang Bukti')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->color('breaker')
                    ->modalWidth(MaxWidth::SixExtraLarge)
                    ->modalContent(fn (IdentitasSaksi $record): View => view(
                        'partials.bb-list',
                        ['id' => $record['id']],
                    )),
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManagePemeriksaanPidsuses::route('/'),
        ];
    }
}
