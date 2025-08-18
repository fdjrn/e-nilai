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
            ['kode_kelas'=> '10001', 'nama_kelas' => '10-A'],
            ['kode_kelas'=> '10002', 'nama_kelas' => '10-B'],
            ['kode_kelas'=> '10003', 'nama_kelas' => '10-C'],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}
