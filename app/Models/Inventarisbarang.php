<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventarisbarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruang_id',
        'nama',
        'kode',
        'nup',
        'merk',
        'tahun',
        'jumlah',
        'kondisi',
        'photo_path',
        'qr_path',
    ];

    // protected $appends = [
    //     'photo_path',
    // ];

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }
}
