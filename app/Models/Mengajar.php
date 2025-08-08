<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mengajar extends Model
{
    protected $table = 'mengajar';

    protected $fillable = [
        'tahun_akademik_id',
        'semester',
        'guru_id',
        'mapel_id',
        'kelas_id',
        'kkm',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function getSemesterAttribute(): string
    {
        return strtoupper($this->attributes['semester']);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
