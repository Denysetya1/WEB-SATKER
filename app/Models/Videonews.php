<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videonews extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['published_at', 'approved_at'];
}
