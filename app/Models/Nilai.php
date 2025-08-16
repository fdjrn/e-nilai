<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'nslm_1',
        'nslm_2',
        'nslm_3',
        'nslm_4',
        'nslm_5',
        'nslm_6',
        'nslm_7',
        'rata_nslm',
        'nsas',
        'nr',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            // force simpan hasil kalkulasi ke DB
            $model->attributes['rata_nslm'] = $model->rata_nslm;
            $model->attributes['nr'] = $model->nr;
        });
    }

    public function getRataNslmAttribute()
    {
        $nilai = collect([
            $this->nslm_1,
            $this->nslm_2,
            $this->nslm_3,
            $this->nslm_4,
            $this->nslm_5,
            $this->nslm_6,
            $this->nslm_7,
        ])->filter(fn($v) => $v > 0);

        return $nilai->count() > 0 ? round($nilai->avg(), 2) : 0;
    }

    public function getNrAttribute()
    {
        return round(
            (0.6 * $this->rata_nslm) + (0.4 * ($this->nsas ?? 0)),
            2
        );
    }

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

    public function avgRataNslm(): float
    {
        $nilai = collect([
            $this->nslm_1,
            $this->nslm_2,
            $this->nslm_3,
            $this->nslm_4,
            $this->nslm_5,
            $this->nslm_6,
            $this->nslm_7,
        ])->filter(fn($n) => $n > 0);

        return $nilai->isNotEmpty() ? round($nilai->avg(), 2) : 0;
    }

//    public function rataNslm(): Attribute
//    {
//        return Attribute::make(
//            //get: fn ($value) => number_format($value, 2, '.', ','),
//            get: function (){
//                $nilai = collect([
//                    $this->nslm_1,
//                    $this->nslm_2,
//                    $this->nslm_3,
//                    $this->nslm_4,
//                    $this->nslm_5,
//                    $this->nslm_6,
//                    $this->nslm_7,
//                ])->filter(fn($n) => $n > 0);
//                return $nilai->isNotEmpty() ? round($nilai->avg(), 2) : 0;
//            }
//        );
//    }
}
