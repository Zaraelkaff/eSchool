<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            // KELAS 2025/2026
            [
                'master_kelas_id' => 1,
                'wali_kelas_id' => 1,
                'tahun_ajaran_id'=> 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'master_kelas_id' => 2,
                'wali_kelas_id' => 2,
                'tahun_ajaran_id'=> 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'master_kelas_id' => 3,
                'wali_kelas_id' => 3,
                'tahun_ajaran_id'=> 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'master_kelas_id' => 4,
                'wali_kelas_id' => 4,
                'tahun_ajaran_id'=> 5,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // KELAS 2024/2025
            [
                'master_kelas_id' => 1,
                'wali_kelas_id' => 5,
                'tahun_ajaran_id'=> 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'master_kelas_id' => 2,
                'wali_kelas_id' => 6,
                'tahun_ajaran_id'=> 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KELAS 2023/2024
            [
                'master_kelas_id' => 1,
                'wali_kelas_id' => 8,
                'tahun_ajaran_id'=> 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
