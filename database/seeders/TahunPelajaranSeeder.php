<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tapel = [
            ['tahun_pelajaran'=> '2024/2025'],

        ];

        foreach ($tapel as $t) {
            TahunPelajaran::created($t);

        }
    }
}
