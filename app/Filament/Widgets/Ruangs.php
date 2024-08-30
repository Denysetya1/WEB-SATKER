<?php

namespace App\Filament\Widgets;

use App\Models\Ruang;
use BezhanSalleh\FilamentExceptions\Facades\FilamentExceptions;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ruangs extends BaseWidget
{
    use LivewireAlert;
    protected static bool $isDiscovered = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ruang::query()
            )
            ->headerActions([
                Tables\Actions\Action::make('addRuang')
                    ->label('Tambah Ruang')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Tambah Ruang')
                    ->modalSubmitActionLabel('Tambah')
                    ->form([
                        TextInput::make('name')->label('Nama Ruang')
                            ->required(),
                        // ...
                    ])->modalWidth(MaxWidth::Small),
            ])
            ->columns([
                TextColumn::make('nama')->label('Nama Ruang')
            ])
            ->emptyStateHeading('Belum Ada Barang Inventaris')
            ->emptyStateDescription('Setelah Menambahkan Barang Inventaris, Barang Inventaris akan muncul di sini.')
            ->emptyStateActions([
                Tables\Actions\Action::make('addRuang')
                    ->label('Tambah Ruang')
                    ->color('wisteria')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Tambah Ruang')
                    ->modalSubmitActionLabel('Tambah')
                    ->form([
                        TextInput::make('name')->label('Nama Ruang')
                            ->required(),
                        // ...
                    ])->modalWidth(MaxWidth::Small)
                    ->action(function (array $data) {
                        $data['kantor_id'] = 1;
                        try {
                            Ruang::create($data);
                            $this->alert('success', 'Ruang Berhasil Di Tambahkan', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => false,
                            ]);
                        } catch (\Throwable $th) {
                            FilamentExceptions::report($th);
                            $this->alert('error', 'Ada Yang Salah, Ruang Tidak Berhasil Di Simpan', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => false,
                            ]);
                        }
                    }),
            ])
            // ->deferLoading()
            ->actions([
                Tables\Actions\EditAction::make('editRuang')
                    ->color('warning')
                    ->button(),
                Tables\Actions\DeleteAction::make('deleteRuang')
                    ->color('danger2')
                    ->label('Hapus')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->button()->label('Hapus Barang Terpilih'),
            ]);
    }
}
