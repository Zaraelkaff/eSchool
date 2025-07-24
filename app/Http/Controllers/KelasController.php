<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Kelas;
use App\Models\MasterKelas;
use App\Models\TahunAjaran;
use App\Models\Staff;
use App\Models\Jabatan;
use App\Models\JabatanStaff;
use App\Models\Murid;
use App\Models\Mapel;
use App\Models\KelasMapel;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $filter_active = $request->query('filter_active');
        $dataKelas = Kelas::query();
        if ($filter_active === 'aktif') {
            $dataKelas->where('is_active', 1);
        } elseif ($filter_active === 'nonaktif') {
            $dataKelas->where('is_active', 0);
        }
        $dataKelas = $dataKelas->get();
        $masterKelas = MasterKelas::all();
        $tahunAjaran = TahunAjaran::all();
        $waliKelas = JabatanStaff::with('staff', 'jabatan')
            ->whereHas('jabatan', function ($q) {
                $q->where('nama_jabatan', 'guru');
            })
            ->where('is_active', 1)
            ->whereDate('tgl_mulai', '<=', Carbon::today())
            ->where(function ($q) {
                $q->whereNull('tgl_selesai')
                ->orWhere('tgl_selesai', '>', Carbon::today());
            })
            ->get()
            ->pluck('staff')
            ->unique('id');

        return view('kelas.index', compact('dataKelas', 'filter_active','masterKelas', 'tahunAjaran', 'waliKelas'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'master_kelas_id' => 'required|exists:master_kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'wali_kelas_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Validasi wali kelas harus punya jabatan guru aktif
                    $jabatanGuruAktif = JabatanStaff::where('staff_id', $value)
                        ->whereHas('jabatan', function ($q) {
                            $q->where('nama_jabatan', 'guru');
                        })
                        ->where('is_active', 1)
                        ->whereDate('tgl_mulai', '<=', Carbon::today())
                        ->where(function ($q) {
                            $q->whereNull('tgl_selesai')
                            ->orWhere('tgl_selesai', '>', Carbon::today());
                        })
                        ->exists();

                    if (!$jabatanGuruAktif) {
                        $fail('Wali kelas harus merupakan guru aktif.');
                    }
                }
            ],
            'is_active' => 'required|boolean',
        ]);

        // Cek apakah kombinasi master_kelas_id + tahun_ajaran_id sudah ada
        $exists = Kelas::where('master_kelas_id', $validated['master_kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kombinasi' => 'Kelas dengan kombinasi tersebut sudah ada.']);
        }

        $kelas = new Kelas();
        $kelas->master_kelas_id = $request->master_kelas_id;
        $kelas->tahun_ajaran_id = $request->tahun_ajaran_id;
        $kelas->wali_kelas_id = $request->wali_kelas_id;
        $kelas->is_active = $request->is_active;
        $kelas->save();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $kelas = Kelas::findOrFail($id);
        $murids = Murid::whereNotIn('id', $kelas->murid->pluck('id'))->get();
        $mapels = Mapel::whereNotIn('id', $kelas->kelasMapel->pluck('id'))->get();
        $pengajars = JabatanStaff::with('staff', 'jabatan')
            ->whereHas('jabatan', function ($q) {
                $q->where('nama_jabatan', 'guru');
            })
            ->where('is_active', 1)
            ->whereDate('tgl_mulai', '<=', Carbon::today())
            ->where(function ($q) {
                $q->whereNull('tgl_selesai')
                ->orWhere('tgl_selesai', '>', Carbon::today());
            })
            ->get()
            ->pluck('staff')
            ->unique('id');
        return view('kelas.detail', compact('kelas', 'murids', 'mapels', 'pengajars'));
    }

    public function hapusMurid($kelas_id, $murid_id)
    {
        DB::table('kelas_murid')
            ->where('kelas_id', $kelas_id)
            ->where('murid_id', $murid_id)
            ->delete();

        return redirect()->back()->with('success', 'Murid berhasil dihapus dari kelas.');
    }

    public function tambahMurid(Request $request, $kelas_id)
    {
        // Validasi input
        $request->validate([
            'murid_ids' => 'required|array',
            'murid_ids.*' => 'exists:murid,id', // Pastikan semua ID murid valid
        ]);

        try {
            // Cari kelas
            $kelas = Kelas::findOrFail($kelas_id);

            // Ambil murid yang sudah ada di kelas untuk menghindari duplikasi
            $existingMuridIds = $kelas->murid()->pluck('murid.id')->toArray();

            // Filter murid_ids yang belum ada di kelas
            $newMuridIds = array_diff($request->murid_ids, $existingMuridIds);

            if (empty($newMuridIds)) {
                return redirect()->route('kelas.detail', $kelas_id)
                    ->with('warning', 'Tidak ada murid baru yang ditambahkan karena semua murid yang dipilih sudah terdaftar.');
            }

            // Tambahkan murid ke tabel kelas_murid
            $kelas->murid()->attach($newMuridIds);
            // Hitung jumlah murid yang berhasil ditambahkan
            $count = count($newMuridIds);

            return redirect()->route('kelas.detail', $kelas_id)
                ->with('success', "$count Murid berhasil ditambahkan ke kelas.");
        } catch (\Exception $e) {
            return redirect()->route('kelas.detail', $kelas_id)
                ->with('error', 'Gagal menambahkan murid: ' . $e->getMessage());
        }
    }

    public function tambahMapel(Request $request, $kelas_id)
    {
        // Validasi input
        $request->validate([
            'mapel_data' => 'required|array',
            'mapel_data.*.mapel_id' => 'required|exists:mapel,id',
            'mapel_data.*.pengajar_id' => 'required|exists:staff,id',
        ]);
        $kelas = Kelas::findOrFail($kelas_id);
        $existingMapelIds = KelasMapel::where('kelas_id', $kelas_id)->pluck('mapel_id')->toArray();

        $newMapelData = [];
        $duplicates = [];

        foreach ($request->mapel_data as $data) {
            if (in_array($data['mapel_id'], $existingMapelIds)) {
                $duplicates[] = $data['mapel_id'];
            } else {
                $newMapelData[] = [
                    'kelas_id' => $kelas_id,
                    'mapel_id' => $data['mapel_id'],
                    'pengajar_id' => $data['pengajar_id'],
                ];
            }
        }

        if (empty($newMapelData)) {
            return redirect()->route('kelas.detail', $kelas_id)
                ->with(['warning' => 'Tidak ada mata pelajaran baru yang ditambahkan karena semua mapel yang dipilih sudah terdaftar.', 'modal' => 'mapel']);
        }
        foreach ($newMapelData as $data) {
            KelasMapel::create($data);
        }

        $count = count($newMapelData);
        return redirect()->route('kelas.detail', $kelas_id)->with('success', "$count Mata pelajaran berhasil ditambahkan ke kelas.");
    }

    public function hapusMapel($kelas_id, $mapel_id)
    {
        DB::table('kelas_mapel')
            ->where('kelas_id', $kelas_id)
            ->where('mapel_id', $mapel_id)
            ->delete();

        return redirect()->back()->with('success', 'Mapel berhasil dihapus dari kelas.');
    }

    public function editView($id){
        $kelas = Kelas::findOrFail($id);
        $murids = Murid::whereNotIn('id', $kelas->murid->pluck('id'))->get();
        $masterKelas = MasterKelas::all();
        $tahunAjaran = TahunAjaran::all();
        $mapels = Mapel::whereNotIn('id', $kelas->kelasMapel->pluck('id'))->get();
        $guru = JabatanStaff::with('staff', 'jabatan')
            ->whereHas('jabatan', function ($q) {
                $q->where('nama_jabatan', 'guru');
            })
            ->where('is_active', 1)
            ->whereDate('tgl_mulai', '<=', $kelas->tahun_ajaran->tgl_mulai)
            ->where(function ($q) {
                $q->whereNull('tgl_selesai')
                ->orWhere('tgl_selesai', '>', Carbon::today());
            })
            ->get()
            ->pluck('staff')
            ->unique('id');
        return view('kelas.edit', compact('kelas', 'murids', 'masterKelas', 'tahunAjaran', 'guru', 'mapels'));
    }

    public function edit(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $validated = $request->validate([
            'master_kelas_id' => 'required|exists:master_kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'wali_kelas_id' => 'required|exists:staff,id',
            'is_active' => 'required|boolean',
        ]);

        // Validasi wali kelas harus merupakan guru aktif
        $jabatanGuruAktif = JabatanStaff::where('staff_id', $validated['wali_kelas_id'])
            ->whereHas('jabatan', function ($q) {
                $q->where('nama_jabatan', 'guru');
            })
            ->where('is_active', 1)
            ->whereDate('tgl_mulai', '<=', $kelas->tahun_ajaran->tgl_mulai)
            ->exists();

        if (!$jabatanGuruAktif) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['wali_kelas_id' => 'Wali kelas harus merupakan guru aktif.']);
        }
        // Cek apakah kombinasi master_kelas_id + tahun_ajaran_id sudah ada, kecuali data yang sedang diedit
        $exists = Kelas::where('master_kelas_id', $validated['master_kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('id', '!=', $kelas->id) // Kecualikan ID kelas saat ini
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kombinasi' => 'Kelas dengan kombinasi tersebut sudah ada.']);
        }

        $kelas = Kelas::findOrFail($id); // pastikan $id adalah ID kelas yang diedit
        $kelas->master_kelas_id = $request->master_kelas_id;
        $kelas->tahun_ajaran_id = $request->tahun_ajaran_id;
        $kelas->wali_kelas_id = $request->wali_kelas_id;
        $kelas->is_active = $request->is_active;
        $kelas->save();

        return redirect()->route('kelas.detail', $id)->with('success', 'Kelas berhasil diupdate.');
    }

}
