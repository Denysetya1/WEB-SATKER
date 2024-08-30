<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struktural extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'desstruktur_id',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function desstruktur()
    {
        return $this->belongsTo(Desstruktur::class);
    }
}
