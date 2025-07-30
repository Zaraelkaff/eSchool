<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KelasMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas_mapel')->insert([
            // Kelas 1A 2025/2026
            [
                'kelas_id'=>1,
                'mapel_id'=>2,
                'pengajar_id'=>11
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>3,
                'pengajar_id'=>12
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>4,
                'pengajar_id'=>13
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>5,
                'pengajar_id'=>14
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>6,
                'pengajar_id'=>5
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>7,
                'pengajar_id'=>16
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>8,
                'pengajar_id'=>7
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>9,
                'pengajar_id'=>5
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>10,
                'pengajar_id'=>17
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>11,
                'pengajar_id'=>9
            ],
            [
                'kelas_id'=>1,
                'mapel_id'=>13,
                'pengajar_id'=>1
            ],
            // Kelas 2A 2025/2026
            [
                'kelas_id'=>2,
                'mapel_id'=>2,
                'pengajar_id'=>11
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>3,
                'pengajar_id'=>12
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>4,
                'pengajar_id'=>13
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>5,
                'pengajar_id'=>14
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>6,
                'pengajar_id'=>15
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>7,
                'pengajar_id'=>16
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>8,
                'pengajar_id'=>7
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>9,
                'pengajar_id'=>5
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>10,
                'pengajar_id'=>17
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>11,
                'pengajar_id'=>9
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>12,
                'pengajar_id'=>10
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>13,
                'pengajar_id'=>2
            ],

            // untuk absen kelas
            [
                'kelas_id'=>1,
                'mapel_id'=>1,
                'pengajar_id'=>1 // wali kelas
            ],
            [
                'kelas_id'=>2,
                'mapel_id'=>1,
                'pengajar_id'=>2 // wali kelas
            ],
            [
                'kelas_id'=>3,
                'mapel_id'=>1,
                'pengajar_id'=>3 // wali kelas
            ],
            [
                'kelas_id'=>4,
                'mapel_id'=>1,
                'pengajar_id'=>4 // wali kelas
            ],
            [
                'kelas_id'=>5,
                'mapel_id'=>1,
                'pengajar_id'=>5 // wali kelas
            ],
            [
                'kelas_id'=>6,
                'mapel_id'=>1,
                'pengajar_id'=>6 // wali kelas
            ],
            [
                'kelas_id'=>7,
                'mapel_id'=>1,
                'pengajar_id'=>8 // wali kelas
            ],
        ]);
    }
}
