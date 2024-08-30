<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdministrasiPidumResource\Pages;
use App\Filament\Resources\AdministrasiPidumResource\RelationManagers;
use App\Models\AdministrasiPidum;
use App\Models\TahapanAdministrasi;
use App\Models\TahapanPerkara;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdministrasiPidumResource extends Resource
{
    protected static ?string $model = TahapanPerkara::class;
    protected static ?string $modelLabel = 'Berkas Administrasi';
    protected static ?string $navigationGroup = 'Pidum';
    protected static ?string $navigationLabel = 'Pengaturan Administrasi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return TahapanAdministrasi::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(TahapanPerkara::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Stack::make([
                    Tables\Columns\TextColumn::make('tahap')
                        ->badge()
                        ->color('info')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('administrasi_pidums.label')
                        ->searchable()
                        ->badge()
                        ->color('success')
                        ->separator(','),
                // ]),
            ])
            // ->contentGrid([
            //     'sm' => 2,
            //     'md' => 4,
            //     'xl' => 6,
            // ])
            ->filters([
                //
            ])
            // ->defaultGroup('tahapan_perkara.tahap')
            // ->groups([
            //     Group::make('tahapan_perkara.tahap')
            //         ->collapsible(),
            // ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->iconButton()
                    ->tooltip('Edit Berkas')
                    ->form(TahapanAdministrasi::getForm())
                    ->modalSubmitActionLabel('Simpan Perubahan')
                    ->closeModalByClickingAway(false)
                    ->successNotificationTitle('Berkas Administrasi Disimpan'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus Tahapan Perkara dan Seluruh Berkasnya')
                    ->successNotificationTitle('Berkas Administrasi Dihapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Berkas Administrasi Pilihan Dihapus'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAdministrasiPidums::route('/'),
        ];
    }
}
