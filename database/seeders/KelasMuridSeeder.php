<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelasMuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas_murid')->insert([
            // murid 1-5
            [
                'kelas_id' => 3,
                'murid_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'murid_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'murid_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'murid_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'murid_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 6,
                'murid_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 6,
                'murid_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 6,
                'murid_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 6,
                'murid_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 6,
                'murid_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 7,
                'murid_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 7,
                'murid_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 7,
                'murid_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 7,
                'murid_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 7,
                'murid_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // murid 6-10
            [
                'kelas_id' => 2,
                'murid_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'murid_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'murid_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'murid_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'murid_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 5,
                'murid_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 5,
                'murid_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 5,
                'murid_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 5,
                'murid_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 5,
                'murid_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // murid 11-15
            [
                'kelas_id' => 1,
                'murid_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'murid_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'murid_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'murid_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'murid_id' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // murid 16-20
            [
                'kelas_id' => 4,
                'murid_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 4,
                'murid_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 4,
                'murid_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 4,
                'murid_id' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 4,
                'murid_id' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
