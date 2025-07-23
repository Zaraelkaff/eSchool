<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanstaff = [];

        for ($i = 0; $i < 20; $i++) {
            $jabatanstaff[]=[
                'staff_id' => $i+1,
                'jabatan_id' => $i === 19 ? 1 : ($i === 18 ? 2 : 3),
                'tgl_mulai'=>'2020-07-15',
                'tgl_selesai' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];            
        }

        DB::table('jabatan_staff')->insert($jabatanstaff);
    }
}
