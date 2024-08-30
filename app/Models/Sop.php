<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidang_id',
        'deskripsi_sop',
        'mediasop'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}
