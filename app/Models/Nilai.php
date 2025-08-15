<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'tahun_akademik_id',
            'semester',
            'kelas_id',
            'mapel_id',
            'siswa_id',
            'nilai_tp1',
            'nilai_tp2',
            'nilai_tp3',
            'nilai_tp4',
            'nilai_tp5',
            'nilai_tp6',
            'nilai_tp7',
            'rata_tp',
            'nilai_uh1',
            'nilai_uh2',
            'nilai_uh3',
            'nilai_uh4',
            'nilai_uh5',
            'nilai_uh6',
            'nilai_uh7',
            'rata_uh',
            'nilai_pts',
            'nilai_uas',
            'nilai_akhir',
            'nilai_huruf',
            'deskripsi',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
