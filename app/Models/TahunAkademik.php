<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';

    protected $fillable = [
        'tahun_akademik',
        'semester',
        'is_active'
    ];

    public function getTahunAkademikSemesterAttribute(): string
    {
        return "{$this->tahun_akademik} / {$this->semester}";
    }

    public function getSemesterAttribute(): string
    {
        return strtoupper($this->attributes['semester']);
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    public function rombel()
    {
        return $this->hasMany(Rombel::class);
    }

    public function guruAktif()
    {
        return $this->hasManyThrough(
            Guru::class,
            Mengajar::class,
            'tahun_akademik_id',
            'id',
            'id',
            'guru_id'
        );
    }

    public function mapelDiajarkan()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            Mengajar::class,
            'tahun_akademik_id',
            'id',
            'id',
            'mapel_id'
        );
    }


    public function kelasTerlibat()
    {
        return $this->hasManyThrough(
            Kelas::class,
            Mengajar::class,
            'tahun_akademik_id',
            'id',
            'id',
            'kelas_id'
        );
    }
}
