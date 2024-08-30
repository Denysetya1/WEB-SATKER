<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenissk extends Model
{
    use HasFactory;

    public $fillable = [
        'deskripsi'
    ];

    public function sk()
    {
        # code...
    }
}
