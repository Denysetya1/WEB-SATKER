<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjangpendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function riwayatpendidikan()
    {
        return $this->hasMany(Riwayatpendidikan::class);
    }
}
