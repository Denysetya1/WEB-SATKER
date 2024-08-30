<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function sop()
    {
        return $this->hasMany(Sop::class);
    }
}
