<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\KelasMapel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{    
    public function index($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $jam = Jam::where('is_active', 1)->orderBy('jam_mulai')->get();
        $jadwal_data = Jadwal::where('kelas_id', $kelas_id)->with('mapel', 'jam')->get();
        
        return view('jadwal.index', compact('kelas', 'jam', 'jadwal_data'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_id' => 'required|exists:jam,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Check for existing schedule in the same class, day, and time
        $existingJadwal = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('jam_id', $request->jam_id)
            ->exists();

        if ($existingJadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal pada hari dan jam tersebut sudah ada untuk kelas ini.'
            ], 422);
        }

        // Get the pengajar_id and tahun_ajaran from kelas_mapel and kelas
        $kelasMapel = KelasMapel::where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->first();

        if (!$kelasMapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mapel tidak ditemukan untuk kelas ini.'
            ], 422);
        }

        $kelas = Kelas::findOrFail($request->kelas_id);
        $tahunAjaran = $kelas->tahun_ajaran_id;

        // Check if the pengajar is already scheduled in another class at the same time and same tahun_ajaran
        $teacherConflict = Jadwal::join('kelas_mapel', function ($join) {
                $join->on('jadwal.kelas_id', '=', 'kelas_mapel.kelas_id')
                     ->on('jadwal.mapel_id', '=', 'kelas_mapel.mapel_id');
            })
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
            ->where('kelas_mapel.pengajar_id', $kelasMapel->pengajar_id)
            ->where('jadwal.hari', $request->hari)
            ->where('jadwal.jam_id', $request->jam_id)
            ->where('jadwal.kelas_id', '!=', $request->kelas_id) // Exclude the current class
            ->where('kelas.tahun_ajaran_id', $tahunAjaran) // Same academic year
            ->exists();

        if ($teacherConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Pengajar sudah memiliki jadwal di kelas lain pada hari, jam, dan tahun ajaran yang sama.'
            ], 422);
        }

        try {
            DB::transaction(function () use ($request) {
                Jadwal::create([
                    'kelas_id' => $request->kelas_id,
                    'mapel_id' => $request->mapel_id,
                    'hari' => $request->hari,
                    'jam_id' => $request->jam_id,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        try {
            $jadwal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jadwal: ' . $e->getMessage()
            ], 500);
        }
    }
}