<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat_asal',
        'kota_asal',
        'prov_asal',
        'satker_asal',
        'tgl_masuk_pertama',
        'jabatan_id',
        'bidang_id',
        'pangkat_id',
        'jabatan',
        'no_nrp',
        'no_nip',
        'photoInfo1',
        'photoInfo2',
        'paraf_1',
        'paraf_2',
        'paraf_3',
    ];

    protected $dates = ['tanggal_lahir', 'tgl_masuk_pertama'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_info')
            // ->singleFile()
            ->acceptsMimeTypes([
                'image/jpg', 'image/jpeg',
                'image/png', 'text/csv', 'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/pdf', 'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.rar', 'text/plain', 'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip'
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function struktural()
    {
        return $this->hasOne(Struktural::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function riwayatpendidikan()
    {
        return $this->hasMany(Riwayatpendidikan::class);
    }

    public function sk()
    {
        return $this->hasMany(Sk::class);
    }
    public function identitas_saksi(): BelongsToMany
    {
        return $this->belongsToMany(IdentitasSaksi::class, 'pemeriksaan_pidsuses');
    }
}
