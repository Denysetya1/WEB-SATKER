<?php

namespace App\Livewire\Home;

use App\Models\Inventarisbarang;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Navbar extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.home.navbar');
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
}
