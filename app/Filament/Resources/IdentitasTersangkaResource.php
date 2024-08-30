<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdentitasTersangkaResource\Pages;
use App\Filament\Resources\IdentitasTersangkaResource\RelationManagers;
use App\Models\IdentitasTersangka;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class IdentitasTersangkaResource extends Resource
{
    protected static ?string $model = IdentitasTersangka::class;
    protected static ?string $modelLabel = 'Database Tersangka';
    // protected static ?string $navigationGroup = 'Pidum';
    protected static ?string $navigationLabel = 'Database Tersangka';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Identitas')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('no_ktp')
                            ->label('No. KTP')
                            ->unique()
                            ->maxLength(255)
                            ->columnSpan(2),
                        ButtonGroup::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->onColor('wisteria')
                            ->offColor('gray')
                            ->gridDirection('row')
                            ->default('Laki-laki')
                            ->columnSpan(2),
                    ])
                    ->columns(4),
                Fieldset::make('Biodata')
                    ->schema([
                        Forms\Components\TextInput::make('no_wa')
                            ->label('No. WA')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('agama')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('riwayat_pendidikan')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->maxLength(255)
                            ->columnSpan(3),
                        Forms\Components\DatePicker::make('tgl_lahir')
                            ->columnSpan(2)
                            ->reactive()
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('umur', Carbon::parse($state)->age);
                            }),
                        Forms\Components\TextInput::make('umur')
                            ->readOnly()
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('alamat')
                            ->autosize()
                            ->columnSpanFull(),
                    ])
                    ->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_ktp')
                    ->label('No. KTP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_wa')
                    ->label('No. WA')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('riwayat_pendidikan')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('tgl_lahir')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('tempat_lahir')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('umur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('agama')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Data Tersangka Dihapus'),
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
            'index' => Pages\ManageIdentitasTersangkas::route('/'),
        ];
    }
}
