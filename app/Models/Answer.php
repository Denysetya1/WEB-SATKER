<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'partisipan_id',
        'jawaban',
    ];

    public function partisipan()
    {
        return $this->belongsTo(Partisipan::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    // use LogsActivity;
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['question_id',
    //     'partisipan_id',
    //     'jawaban',]);
    // }
}
