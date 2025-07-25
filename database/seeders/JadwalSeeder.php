<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal')->insert([
            ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>4, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Senin', 'mapel_id'=>4, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>2, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Selasa', 'mapel_id'=>2, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>7, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>7, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>9, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Rabu', 'mapel_id'=>9, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>6, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Kamis', 'mapel_id'=>6, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>8, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Jumat', 'mapel_id'=>8, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>2, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>1, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>9, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>9, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>6, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Senin', 'mapel_id'=>6, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Selasa', 'mapel_id'=>3, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>2, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>8, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Rabu', 'mapel_id'=>8, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>5, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>2, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>4, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Kamis', 'mapel_id'=>4, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>1, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>1, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Jumat', 'mapel_id'=>10, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            
            ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>7, 'jam_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>7, 'jam_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>12, 'jam_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>5, 'jam_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['kelas_id'=>2, 'hari'=>'Sabtu', 'mapel_id'=>11, 'jam_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
