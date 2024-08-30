<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partisipan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pekerjaan',
        'usia',
        'jenis_kelamin',
        'pendidikan',
        'pendidikan_akhir',
    ];

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

}
