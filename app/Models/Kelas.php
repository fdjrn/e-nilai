<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
    ];

    public function getKodeNamaKelasAttribute():string
    {
        return "{$this->kode_kelas} - {$this->nama_kelas}";
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    // Guru-guru yang mengajar di kelas ini (unik secara logika bisa di-`->distinct()` di query)
    public function guruPengajar()
    {
        return $this->hasManyThrough(
            Guru::class,
            Mengajar::class,
            'kelas_id',   // foreign key di mengajar menuju kelas
            'id',         // key di guru
            'id',         // local key di kelas
            'guru_id'     // foreign key di mengajar menuju guru
        );
    }

    // Mata pelajaran yang diajarkan di kelas ini
    public function mapelDiajarkan()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            Mengajar::class,
            'kelas_id',
            'id',
            'id',
            'mapel_id'
        );
    }

    // Tahun akademik terkait melalui mengajar
    public function tahunAkademikTerlibat()
    {
        return $this->hasManyThrough(
            TahunAkademik::class,
            Mengajar::class,
            'kelas_id',
            'id',
            'id',
            'tahun_akademik_id'
        );
    }
}
