<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            ['kode_kelas'=> 'X IPA', 'nama_kelas' => 'A'],
            ['kode_kelas'=> 'X IPA', 'nama_kelas' => 'B'],
            ['kode_kelas'=> 'X IPS', 'nama_kelas' => 'A'],
            ['kode_kelas'=> 'X IPS', 'nama_kelas' => 'B'],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}
