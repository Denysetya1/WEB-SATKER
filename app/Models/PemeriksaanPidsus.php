<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PemeriksaanPidsus extends Model
{
    use HasFactory;
    public $fillable = [
        'perkara_pidsus_id',
        'identitas_saksi_id',
        'pegawais_id',
        'tgl_pemeriksaan',
    ];
}
