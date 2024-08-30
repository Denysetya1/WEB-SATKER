<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desstruktur extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'icon',
    ];

    public function struktural()
    {
        return $this->hasOne(Struktural::class);
    }
}
