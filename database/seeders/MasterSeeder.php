<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatan')->insert([
            [
                'nama_jabatan' => 'admin',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'kepsek',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'guru',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'OB',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('master_kelas')->insert([
            [
                'nama_kelas' => '1A',
                'level' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nama_kelas' => '2A',
                'level' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nama_kelas' => '3A',
                'level' => 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nama_kelas' => '1B',
                'level' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nama_kelas' => '2B',
                'level' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nama_kelas' => '3B',
                'level' => 3,
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        DB::table('tahun_ajaran')->insert([
            [
                'tahun_ajaran' => '2021/2022',
                'tgl_mulai' => '2021-07-15',
                'tgl_selesai' => '2022-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2022/2023',
                'tgl_mulai' => '2022-07-15',
                'tgl_selesai' => '2023-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2023/2024',
                'tgl_mulai' => '2023-07-15',
                'tgl_selesai' => '2024-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2024/2025',
                'tgl_mulai' => '2024-07-15',
                'tgl_selesai' => '2025-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2025/2026',
                'tgl_mulai' => '2025-07-15',
                'tgl_selesai' => '2026-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('mapel')->insert([
            [
                'nama_mapel'=>'kelas',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Matematika',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'IPA',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'IPS',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Seni Budaya',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Sejarah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Bahasa Indonesia',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'PJOK',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'PPKN',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Bahasa Inggris',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Agama',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Komputer',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mapel'=>'Istirahat',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $jamList = [
            ['jam_mulai' => '07:00:00', 'jam_selesai' => '08:00:00'],
            ['jam_mulai' => '08:00:00', 'jam_selesai' => '09:00:00'],
            ['jam_mulai' => '09:00:00', 'jam_selesai' => '10:00:00'],
            ['jam_mulai' => '11:00:00', 'jam_selesai' => '12:00:00'],
            ['jam_mulai' => '12:00:00', 'jam_selesai' => '13:00:00'],
        ];
        foreach ($jamList as $jam) {
            DB::table('jam')->insert([
                'jam_mulai' => $jam['jam_mulai'],
                'jam_selesai' => $jam['jam_selesai'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
