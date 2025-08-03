<?php

namespace Database\Seeders;

use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = [
            ['nip'=> '197909102009121002', 'nama' => 'MUKHTAR LUTHFI, S.Pd.I', 'tempat_lahir' => 'LIMAMAR', 'tgl_lahir' => Carbon::parse('1979-09-10'), 'jenis_kelamin' => 'L'],
            ['nip'=> '198402302009122001', 'nama' => 'NURUL HAYATI, S.Pd', 'tempat_lahir' => 'SAMPIT', 'tgl_lahir' => Carbon::parse('1984-02-30'), 'jenis_kelamin' => 'P'],
            ['nip'=> '199604272020121011', 'nama' => 'AHMAD AROFAT, S. Pd', 'tempat_lahir' => 'KOTAWARINGIN TIMUR', 'tgl_lahir' => Carbon::parse('1996-04-27'), 'jenis_kelamin' => 'L'],
        ];

        foreach ($guru as $g) {
            Guru::create($g);
        }
    }
}
