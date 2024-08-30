<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        // 'sinopsis',
        'isi_berita',
        'gambar_berita',
        'caption_gambar',
        'author',
        'featured',
        'published_at'
    ];

    // protected $dates = ['published_at'];

    protected $casts = [
        'featured' => 'boolean',
        'published_at' => 'datetime',
        // 'gambar_berita' => 'array',
    ];

    // public function beritapertag() {
    //     return $this->hasOne(Beritapertag::class, 'id_berita');
    // }
    public function scopePublished($query) {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query) {
        $query->where('featured', true);
    }

    public function getExcerpt() {
        return Str::limit(strip_tags($this->body),150);
    }

    public function getReadingTime(){
        $mins = round(str_word_count($this->body) / 250);
        return ($mins < 1) ? 1 : $mins;
    }
}
