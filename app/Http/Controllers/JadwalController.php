<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\KelasMapel;
use App\Models\Staff;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class JadwalController extends Controller
{    
    public function index($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $jam = Jam::where('is_active', 1)->orderBy('jam_mulai')->get();
        $jadwal_data = Jadwal::whereHas('kelasMapel', function ($query) use ($kelas_id) {
            $query->where('kelas_id', $kelas_id);
        })->with('kelasMapel.mapel', 'kelasMapel.pengajar', 'jam')->get();
        
        return view('jadwal.index', compact('kelas', 'jam', 'jadwal_data'));
    }

    public function jadwalGuru(Request $request, $staff)
    {
        $guru = Staff::findOrFail($staff);
        $tahunAjarans = TahunAjaran::where('is_active', 1)->orderBy('tahun_ajaran', 'desc')->get();
        $today = Carbon::now(); // Tanggal hari ini: 25 Juli 2025

        // Default tahun ajaran berdasarkan tanggal hari ini
        $defaultTahunAjaran = $tahunAjarans->firstWhere(function ($tahun) use ($today) {
            return $today->between($tahun->tgl_mulai, $tahun->tgl_selesai);
        }) ?? $tahunAjarans->first();

        $selectedTahunAjaranId = $request->input('tahun_ajaran_id', $defaultTahunAjaran->id);

        $jadwal_data = Jadwal::whereHas('kelasMapel', function ($query) use ($staff) {
            $query->where('pengajar_id', $staff);
        })->with(['kelasMapel' => function ($query) use ($selectedTahunAjaranId) {
            $query->whereHas('kelas', function ($q) use ($selectedTahunAjaranId) {
                $q->where('tahun_ajaran_id', $selectedTahunAjaranId);
            })->with('mapel', 'kelas.master_kelas');
        }, 'jam'])->get()->filter(function ($jadwal) {
            return $jadwal->kelasMapel !== null;
        });

        $all_jams = Jam::where('is_active', 1)->orderBy('jam_mulai')->get();

        return view('jadwal.guru', compact('guru', 'tahunAjarans', 'selectedTahunAjaranId', 'jadwal_data', 'all_jams'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_mapel_id' => 'required|exists:kelas_mapel,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_id' => 'required|exists:jam,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Ambil kelas_id dari kelas_mapel_id untuk validasi
        $kelasMapel = KelasMapel::findOrFail($request->kelas_mapel_id);
        $kelasId = $kelasMapel->kelas_id;

        // Validasi jadwal yang sudah ada
        $existingJadwal = Jadwal::where('kelas_mapel_id', $request->kelas_mapel_id)
            ->where('hari', $request->hari)
            ->where('jam_id', $request->jam_id)
            ->exists();

        if ($existingJadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal pada hari dan jam tersebut sudah ada untuk kelas ini.'
            ], 422);
        }

        // Validasi konflik pengajar
        $kelas = Kelas::findOrFail($kelasId);
        $tahunAjaran = $kelas->tahun_ajaran_id;

        $teacherConflict = Jadwal::whereHas('kelasMapel', function ($query) use ($kelasMapel, $request, $kelasId, $tahunAjaran) {
            $query->where('pengajar_id', $kelasMapel->pengajar_id)
                  ->where('kelas_id', '!=', $kelasId)
                  ->whereHas('kelas', function ($q) use ($tahunAjaran) {
                      $q->where('tahun_ajaran_id', $tahunAjaran);
                  });
        })
            ->where('hari', $request->hari)
            ->where('jam_id', $request->jam_id)
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
                    'kelas_mapel_id' => $request->kelas_mapel_id,
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