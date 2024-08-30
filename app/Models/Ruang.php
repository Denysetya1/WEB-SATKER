<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kantor_id',
        'nama',
        'photo_path',
    ];

    protected $hidden = [
        'kode'
    ];

    // protected $appends = [
    //     'photo_path',
    // ];

    public function kantor(): BelongsTo
    {
        return $this->belongsTo(Kantor::class);
    }

    public function barang(): HasMany
    {
        return $this->hasMany(Inventarisbarang::class);
    }
}
