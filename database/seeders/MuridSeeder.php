<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaDepan = ['Ali', 'Budi', 'Citra', 'Dina', 'Eka', 'Fajar', 'Gina', 'Hani', 'Irfan', 'Joko', 'Kiki', 'Lina', 'Mega', 'Nina', 'Oki', 'Putri', 'Qori', 'Rani', 'Sita', 'Tono'];
        $namaAyah = ['Ahmad', 'Bambang', 'Cahyono', 'Dedi', 'Eko', 'Fikri', 'Gunawan', 'Hari', 'Imam', 'Junaedi'];
        $namaIbu = ['Aisyah', 'Bella', 'Citra', 'Dewi', 'Erna', 'Fitri', 'Gita', 'Hilda', 'Indah', 'Juliana'];
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];

        $murid = [];

        for ($i = 0; $i < 20; $i++) {
            $grup = intdiv($i, 5); // Kelompok 0-3
            $tanggalMasuk = Carbon::create(2022 + $grup, 7, 15); // 2022, 2023, 2024, 2025
            $tanggalLahir = $tanggalMasuk->copy()->subYears(7); // Umur masuk SD 7 tahun

            $murid[] = [
                'NIK' => str_pad((string)rand(100000000000000, 999999999999999), 16, '0', STR_PAD_LEFT),
                'NIS' => 'SDN' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT),
                'nama' => $namaDepan[$i],
                'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',
                'tgl_lahir' => $tanggalLahir->format('Y-m-d'),
                'agama' => $agamaList[rand(0, count($agamaList) - 1)],
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
