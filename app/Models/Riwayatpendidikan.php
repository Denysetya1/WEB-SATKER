<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Riwayatpendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'jenjang_id',
        'nama_sekolah',
        'alamat_sekolah',
        'ijazah_link',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jenjangpendidikan()
    {
        return $this->belongsTo(Jenjangpendidikan::class);
    }
}
