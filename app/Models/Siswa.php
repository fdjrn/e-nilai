<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nisn',
        'nik',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'hobi',
        'cita_cita',
        'status_anak',
        'jumlah_sdr',
        'anak_ke',
        'alamat',
        'nik_ayah',
        'nama_ayah',
        'pend_ayah',
        'pkr_ayah',
        'nik_ibu',
        'nama_ibu',
        'pend_ibu',
        'pkr_ibu',
        'alamat_ortu',
        'tgl_masuk',
        'tgl_keluar',
        'status',
    ];
}
