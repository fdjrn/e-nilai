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
            ['kode_mapel'=> 'BND', 'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel'=> 'BNG', 'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel'=> 'MTK', 'nama_mapel' => 'Matematika'],
            ['kode_mapel'=> 'BIO', 'nama_mapel' => 'Biologi'],

        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}
