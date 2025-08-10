<?php

namespace App\Models;

use Filament\Forms\Components\Builder;
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

    public function getKelasInfoAttribute(): string
    {
        if (! $this->kelas) {
            return '-';
        }

        return "{$this->kelas->kode_kelas} - {$this->kelas->nama_kelas}";
    }

    public function scopeOrderByKelasInfo($query, $direction = 'asc')
    {
        return $query
            ->join('kelas', 'mengajar.kelas_id', '=', 'kelas.id')
            ->orderByRaw("CONCAT_WS(' ', kelas.kode_kelas, kelas.nama_kelas) {$direction}")
            ->select('mengajar.*');
    }

    /**
     * Default Sorting by Kelas untuk komponen filament table
     */
    public static function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with('kelas')
            ->orderByKelasInfo();
    }
}
