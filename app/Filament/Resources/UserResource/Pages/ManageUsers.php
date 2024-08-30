<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Pegawai;
use App\Models\Struktural;
use App\Models\User;
use BezhanSalleh\FilamentExceptions\Facades\FilamentExceptions;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return 'Management Akun';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Akun')
                ->modalHeading('Tambah Akun')
                ->modalSubmitActionLabel('Tambah')
                ->using(function (array $data) {
                    $cek = Pegawai::where('no_nip', $data['nip'])->first();
                    if ($cek) {
                        $cekUser = User::find($cek['user_id']);
                        if ($cekUser) {
                            Notification::make()
                                ->danger()
                                ->title('NIP Sudah Terdaftar')
                                ->send();
                        }
                    }
                    $data['password'] = Hash::make($data['nip']);
                    $data['active'] = true;
                    try {
                        $user = User::create($data);
                        $user->assignRole('pegawai');
                    } catch (TooManyRequestsException $exception) {
                        FilamentExceptions::report($exception);
                        Notification::make()
                            ->danger()
                            ->title('Terjadi Kesalahan Menambahkan Akun')
                            ->send();
                        return null;
                    }
                    $data['user_id'] = $user->id;
                    $data['no_nip'] = $user->nip;
                    $data['bidang_id'] = 6;
                    $pegawai = Pegawai::create($data);
                    $data2['pegawai_id'] = $pegawai->id;
                    $data2['desstruktur_id'] = 5;
                    Struktural::create($data2);
                })
                ->successNotification(
                    Notification::make()
                         ->success()
                         ->title('Akun Berhasil Di Tambahkan'),
                 ),
        ];
    }
}
