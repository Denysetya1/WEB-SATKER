<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kantor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    protected $hidden = [
        'kode'
    ];

    protected $appends = [
        'photo_path',
    ];

    public function ruang(): HasMany
    {
        return $this->hasMany(Ruang::class);
    }
}
