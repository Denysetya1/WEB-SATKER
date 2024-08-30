<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkaraPidumTersangka extends Model
{
    use HasFactory;
    protected $fillable = [
        'perkara_pidum_id',
        'identitas_tersangka_id',
    ];
}
