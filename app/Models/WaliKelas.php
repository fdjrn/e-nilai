<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';

    protected $fillable = [
        'tahun_akademik_id',
        'semester',
        'kelas_id',
        'guru_id',

    ];

    public function getSemesterAttribute(): string
    {
        return strtoupper($this->attributes['semester']);
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function rombel()
    {
        return $this->hasMany(Rombel::class);
    }
}
