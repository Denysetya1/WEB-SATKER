<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'survei_id',
        'pertanyaan',
    ];

    public function survei()
    {
        return $this->belongsTo(Survei::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    public function hasilsurvei()
    {
        return $this->hasOne(Hasilsurvei::class);
    }
}
