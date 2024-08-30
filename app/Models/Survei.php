<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_survei',
    ];

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
