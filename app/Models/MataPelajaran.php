<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    // Guru yang mengajarkan mata pelajaran ini
    public function guruPengajar()
    {
        return $this->hasManyThrough(
            Guru::class,
            Mengajar::class,
            'mapel_id',
            'id',
            'id',
            'guru_id'
        );
    }

    // Kelas tempat mata pelajaran ini diajarkan
    public function kelasDiajarkan()
    {
        return $this->hasManyThrough(
            Kelas::class,
            Mengajar::class,
            'mapel_id',
            'id',
            'id',
            'kelas_id'
        );
    }

    public function tahunAkademikTerlibat()
    {
        return $this->hasManyThrough(
            TahunAkademik::class,
            Mengajar::class,
            'mapel_id',
            'id',
            'id',
            'tahun_akademik_id'
        );
    }
}
