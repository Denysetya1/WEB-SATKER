<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jumlahbarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_id',
        'bulan',
        'jumlah',
    ];

    public function tahun(): BelongsTo
    {
        return $this->belongsTo(Tahun::class);
    }
}
