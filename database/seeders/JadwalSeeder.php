<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal')->insert([
            ['kelas_mapel_id'=>1, 'hari'=>'Senin', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>1, 'hari'=>'Senin', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Senin', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>4, 'hari'=>'Senin', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>4, 'hari'=>'Senin', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>4, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>4, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>3, 'hari'=>'Selasa', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>3, 'hari'=>'Selasa', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Selasa', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>2, 'hari'=>'Selasa', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>2, 'hari'=>'Selasa', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>2, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>2, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>7, 'hari'=>'Rabu', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>7, 'hari'=>'Rabu', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Rabu', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>9, 'hari'=>'Rabu', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>9, 'hari'=>'Rabu', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>7, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>7, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>9, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>9, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>1, 'hari'=>'Kamis', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>1, 'hari'=>'Kamis', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Kamis', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>6, 'hari'=>'Kamis', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>6, 'hari'=>'Kamis', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>6, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>6, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>10, 'hari'=>'Jumat', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>10, 'hari'=>'Jumat', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Jumat', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>8, 'hari'=>'Jumat', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>8, 'hari'=>'Jumat', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>8, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>8, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>2, 'hari'=>'Sabtu', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>2, 'hari'=>'Sabtu', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>11, 'hari'=>'Sabtu', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>5, 'hari'=>'Sabtu', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>5, 'hari'=>'Sabtu', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>2, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>20, 'hari'=>'Senin', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>20, 'hari'=>'Senin', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Senin', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>17, 'hari'=>'Senin', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>17, 'hari'=>'Senin', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>9, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>9, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>6, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>6, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>12, 'hari'=>'Selasa', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>12, 'hari'=>'Selasa', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Selasa', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>14, 'hari'=>'Selasa', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>14, 'hari'=>'Selasa', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>13, 'hari'=>'Rabu', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>13, 'hari'=>'Rabu', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Rabu', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>19, 'hari'=>'Rabu', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>19, 'hari'=>'Rabu', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>2, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>8, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>8, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>16, 'hari'=>'Kamis', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>16, 'hari'=>'Kamis', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Kamis', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>15, 'hari'=>'Kamis', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>15, 'hari'=>'Kamis', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>5, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>4, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>4, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>12, 'hari'=>'Jumat', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>12, 'hari'=>'Jumat', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Jumat', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>21, 'hari'=>'Jumat', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>21, 'hari'=>'Jumat', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_mapel_id'=>18, 'hari'=>'Sabtu', 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>18, 'hari'=>'Sabtu', 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>23, 'hari'=>'Sabtu', 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>16, 'hari'=>'Sabtu', 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_mapel_id'=>22, 'hari'=>'Sabtu', 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],

            // ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>7, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>7, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            // ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>11, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
