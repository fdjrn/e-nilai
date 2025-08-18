<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            ['kode_mapel'=> 'MP001', 'nama_mapel' => 'BAHASA INDONESIA'],
            ['kode_mapel'=> 'MP002', 'nama_mapel' => 'BAHASA INGGRIS'],
            ['kode_mapel'=> 'MP003', 'nama_mapel' => 'MATEMATIKA'],

        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}
