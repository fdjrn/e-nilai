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

    public function getKodeNamaKelasAttribute(): string
    {
        return "{$this->kode_kelas} - {$this->nama_kelas}";
    }

    public function getFullKelasNameAttribute()
    {
        return "{$this->kode_kelas} - {$this->nama_kelas}";
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    public function rombel()
    {
        return $this->hasMany(Rombel::class);
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

    // Default daftar nama kelas yang ditampilkan
    public static function getListKelas()
    {
        return self::query()->select('kode_kelas')
            ->distinct()
            ->orderBy('kode_kelas', 'asc')
            ->pluck('kode_kelas', 'kode_kelas');
    }

    public static function getDefaultKelas()
    {
        return static::select('id','nama_kelas')
            ->orderBy('nama_kelas')
            ->first();
    }
}
