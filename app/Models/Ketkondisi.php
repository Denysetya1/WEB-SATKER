<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketkondisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ket',
        'color',
        'icon',
    ];

    public function inventarisbarang()
    {
        return $this->hasMany(Inventarisbarang::class);
    }
}
