<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MuridSeeder extends Seeder
{
    public function run(): void
    {
        $namaDepan = ['Ali', 'Budi', 'Citra', 'Dina', 'Eka', 'Fajar', 'Gina', 'Hani', 'Irfan', 'Joko', 'Kiki', 'Lina', 'Mega', 'Nina', 'Oki', 'Putri', 'Qori', 'Rani', 'Sita', 'Tono'];
        $namaAyah = ['Ahmad', 'Bambang', 'Cahyono', 'Dedi', 'Eko', 'Fikri', 'Gunawan', 'Hari', 'Imam', 'Junaedi'];
        $namaIbu = ['Aisyah', 'Bella', 'Citra', 'Dewi', 'Erna', 'Fitri', 'Gita', 'Hilda', 'Indah', 'Juliana'];
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];

        $murid = [];

        for ($i = 0; $i < 20; $i++) {
            if ($i < 5) {
                $tahunMasuk = 2023;
            } elseif ($i < 10) {
                $tahunMasuk = 2024;
            } else {
                $tahunMasuk = 2025;
            }

            $tanggalMasuk = Carbon::create($tahunMasuk, 7, 15);
            $tanggalLahir = $tanggalMasuk->copy()->subYears(7);

            $murid[] = [
                'NIK' => str_pad((string)rand(100000000000000, 999999999999999), 16, '0', STR_PAD_LEFT),
                'NIS' => 'SDN' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT),
                'nama' => $namaDepan[$i],
                'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',
                'tgl_lahir' => $tanggalLahir->format('Y-m-d'),
                'agama' => $agamaList[array_rand($agamaList)],
                'alamat' => 'Jl. Mawar No. ' . rand(1, 100),
                'notelp' => '08' . rand(1111111111, 9999999999),
                'nama_ayah' => $namaAyah[array_rand($namaAyah)],
                'nama_ibu' => $namaIbu[array_rand($namaIbu)],
                'tgl_masuk' => $tanggalMasuk->format('Y-m-d'),
                'tgl_keluar' => null,
                'users_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('murid')->insert($murid);
    }
}
