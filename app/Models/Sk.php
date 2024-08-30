<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sk extends Model
{
    use HasFactory;

    public $fillable = [
        'pegawai_id',
        'jenissk_id',
        'ketsk_id',
        'nomor_sk',
        'tmt',
        'skmedia_link',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jenissk()
    {
        return $this->belongsTo(Jenissk::class);
    }

    public function ketsk()
    {
        return $this->belongsTo(Ketsk::class);
    }
}
