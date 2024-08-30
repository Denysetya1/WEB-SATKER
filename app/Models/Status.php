<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'status',
        'pindahke',
        'tgl_pensiun',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
