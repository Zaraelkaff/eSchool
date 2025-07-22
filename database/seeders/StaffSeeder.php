<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaList = ['Ahmad', 'Budi', 'Citra', 'Dina', 'Eko', 'Fajar', 'Gina', 'Hari', 'Indah', 'Joko', 'Kiki', 'Lina', 'Mega', 'Nina', 'Oki', 'Putri', 'Rani', 'Sita', 'Tono', 'Umar'];
        $universitas = ['Universitas A', 'Universitas B', 'Universitas C', 'Universitas D', 'Universitas E', 'Universitas F'];

        $staff = [];

        for ($i = 0; $i < 20; $i++) {
            $nama = $namaList[$i];
            $jenisKelamin = $i % 2 === 0 ? 'L' : 'P';
            $tanggalLahir = Carbon::create(rand(1985, 1998), rand(1, 12), rand(1, 28));
            $lulusan = $universitas[array_rand($universitas)];

            $staff[] = [
                'NIK' => str_pad((string)rand(100000000000000, 999999999999999), 16, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'gelar_depan' => null,
                'gelar_belakang' => $i === 19 ? 'S.AB.' : 'S.Pd.', // Admin di akhir
                'jenis_kelamin' => $jenisKelamin,
                'tgl_lahir' => $tanggalLahir->format('Y-m-d'),
                'alamat' => 'Jl. Pendidikan No. ' . rand(1, 100),
                'notelp' => '08' . rand(1111111111, 9999999999),
                'lulusan' => $lulusan,
                'tgl_masuk' => '2020-07-15',
                'tgl_keluar' => null,
                'users_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('staff')->insert($staff);
    }
}
