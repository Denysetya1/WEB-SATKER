<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasilsurvei extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'jumlah_partisipan',
        'jumlah_point',
        'total_skm',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
