<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat'
    ];

    public function searchScopes(Builder $query, string $term): Builder
    {
        return $query->where('nip', 'like', "%{$term}%")
            ->orWhere('nama', 'like', "%{$term}%")
            ->orWhere('alamat', 'like', "%{$term}%");
    }


    public function getNamaWaliKelasAttribute(): string
    {
        return "{$this->nama}";
    }

    // 1 Guru bisa mengajar beberapa Mata Pelajaran yang diajarkan
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    public function rombel()
    {
        return $this->hasMany(Rombel::class);
    }

    // Mata pelajaran yang diajarkan (bisa duplicate, panggil ->distinct('id') kalau perlu unik)
    public function mapelDiajarkan()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            Mengajar::class,
            'guru_id',    // foreign key di mengajar menuju guru
            'id',         // key di mapel
            'id',         // local key guru
            'mapel_id'    // foreign key di mengajar menuju mapel
        );
    }

    // Kelas tempat dia mengajar
    public function kelasDiajarkan()
    {
        return $this->hasManyThrough(
            Kelas::class,
            Mengajar::class,
            'guru_id',
            'id',
            'id',
            'kelas_id'
        );
    }

    // Tahun akademik yang terlibat dalam penugasan dia
    public function tahunAkademikTerlibat()
    {
        return $this->hasManyThrough(
            TahunAkademik::class,
            Mengajar::class,
            'guru_id',
            'id',
            'id',
            'tahun_akademik_id'
        );
    }
}
