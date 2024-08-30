<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beritapertag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_berita',
        'id_tag'
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
