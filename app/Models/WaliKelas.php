<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Mengelompokkan dan menghitung jumlah siswa dalam rombel berdasarkan kelas.
     */
    public function jumlahSiswaPerKelas(): Collection
    {
        return DB::table('wali_kelas as wk')
            ->leftJoin('rombel as r', 'wk.id', '=', 'r.wali_kelas_id')
            ->leftJoin('kelas as k', 'wk.kelas_id', '=', 'k.id')
            ->selectRaw('k.kode_kelas, COUNT(r.id) as jumlah')
            ->where('wk.guru_id', $this->guru_id)
            ->groupBy('k.kode_kelas')
            ->pluck('jumlah', 'kode_kelas');
    }

    public function jumlahSiswa(): int
    {
        return DB::table('wali_kelas as wk')
            ->leftJoin('rombel as r', 'wk.id', '=', 'r.wali_kelas_id')
            ->where('wk.guru_id', $this->guru_id)
            ->where('wk.kelas_id', $this->kelas_id)
            ->where('r.tahun_akademik_id', $this->tahun_akademik_id)
            ->count();
    }
}
