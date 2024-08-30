<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBarangBukti extends Model
{
    use HasFactory;
    public $fillable = [
        'nama_jenis'
    ];
    public function barang_bukti_pinjam(): HasMany
    {
        return $this->hasMany(BarangBuktiPinjam::class);
    }
}
