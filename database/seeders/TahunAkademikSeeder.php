<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ta = [
            [
                'tahun_akademik'=> '2024/2025',
                'semester' => 'Ganjil',
                'is_active' => true,
            ],
            [
                'tahun_akademik'=> '2024/2025',
                'semester' => 'Genap',
                'is_active' => true,
            ],

        ];

        foreach ($ta as $t) {
            TahunAkademik::created($t);

        }
    }
}
