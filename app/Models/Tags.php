<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_names',
        'slug',
        'text_color',
        'bg_color'
    ];

    // public function beritapertag()
    // {
    //     return $this->hasOne(Beritapertag::class, 'id_tag');
    // }
}
