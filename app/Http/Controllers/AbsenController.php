<?php
namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kelas;
use App\Models\MasterKelas;
use App\Models\TahunAjaran;
use App\Models\Murid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    // Kode indexAdmin dari Anda (tidak diubah)
    public function indexAdmin(Request $request)
    {
        // Ambil data untuk filter
        $masterKelas = MasterKelas::where('is_active', true)->get();
        $tahunAjaran = TahunAjaran::where('is_active', true)->get();

        // Filter
        $kelasId = $request->query('kelas_id');
        $tahunAjaranId = $request->query('tahun_ajaran_id');
        $monthYear = $request->query('month_year'); // Format: YYYY-MM

        $data = [];
        $errorMessage = null;

        if ($tahunAjaranId && $monthYear) {
            // Validasi tahun ajaran
            $selectedTahunAjaran = TahunAjaran::find($tahunAjaranId);
            if ($selectedTahunAjaran) {
                $monthYearCarbon = Carbon::createFromFormat('Y-m', $monthYear);
                $start = Carbon::parse($selectedTahunAjaran->tgl_mulai);
                $end = Carbon::parse($selectedTahunAjaran->tgl_selesai);
                $startMonth = Carbon::parse($start)->startOfMonth();
                $endMonth = Carbon::parse($end)->endOfMonth();
                if ($monthYearCarbon < $startMonth || $monthYearCarbon > $endMonth) {
                    $errorMessage = "Tahun ajaran dimulai dari {$start->format('F Y')} sampai {$end->format('F Y')}";
                } else {
                    // Ambil kelas yang akan ditampilkan
                    $kelasList = $kelasId && $kelasId !== 'all'
                        ? Kelas::where('master_kelas_id', $kelasId)->where('tahun_ajaran_id', $tahunAjaranId)->get()
                        : Kelas::where('tahun_ajaran_id', $tahunAjaranId)->get();

                    foreach ($kelasList as $kelas) {
                        $murid = $kelas->murid()->get();
                        $absen = Absen::where('kelas_id', $kelas->id)
                            ->whereMonth('tanggal', $monthYearCarbon->month)
                            ->whereYear('tanggal', $monthYearCarbon->year)
                            ->get()
                            ->keyBy(function ($item) {
                                return $item->murid_id . '-' . $item->tanggal->format('Y-m-d');
                            });

                        $daysInMonth = $monthYearCarbon->daysInMonth;
                        $data[$kelas->id] = [
                            'kelas' => $kelas,
                            'murid' => $murid,
                            'absen' => $absen,
                            'days' => range(1, $daysInMonth),
                        ];
                    }
                }
            }
        }

        return view('absen.admin.index', compact('masterKelas', 'tahunAjaran', 'data', 'errorMessage', 'kelasId', 'tahunAjaranId', 'monthYear'));
    }

    // Kode formAdmin (tidak diubah, sudah menangani kasus filter kosong)
    public function formAdmin(Request $request, $kelasId = null)
    {
        // Ambil data untuk filter
        $masterKelas = MasterKelas::where('is_active', true)->get();
        $tahunAjaran = TahunAjaran::where('is_active', true)->get();

        // Filter
        $masterKelasId = $request->query('master_kelas_id');
        $tahunAjaranId = $request->query('tahun_ajaran_id');
        $tanggal = $request->query('tanggal'); // Format: YYYY-MM-DD

        // Jika ada kelas_id dari link, set default master_kelas_id dan tahun_ajaran_id
        if ($kelasId) {
            $kelas = Kelas::findOrFail($kelasId);
            $masterKelasId = $masterKelasId ?? $kelas->master_kelas_id;
            $tahunAjaranId = $tahunAjaranId ?? $kelas->tahun_ajaran_id;
        }

        $data = [];
        $errorMessage = null;

        if ($masterKelasId && $tahunAjaranId && $tanggal) {
            // Validasi tahun ajaran
            $selectedTahunAjaran = TahunAjaran::find($tahunAjaranId);
            if ($selectedTahunAjaran) {
                $tanggalCarbon = Carbon::parse($tanggal);
                $start = Carbon::parse($selectedTahunAjaran->tgl_mulai);
                $end = Carbon::parse($selectedTahunAjaran->tgl_selesai);

                if ($tanggalCarbon->lt($start) || $tanggalCarbon->gt($end)) {
                    $errorMessage = "Tahun ajaran dimulai dari {$start->format('F Y')} sampai {$end->format('F Y')}";
                } else {
                    // Ambil kelas berdasarkan master_kelas_id dan tahun_ajaran_id
                    $kelas = Kelas::where('master_kelas_id', $masterKelasId)
                        ->where('tahun_ajaran_id', $tahunAjaranId)
                        ->firstOrFail();
                    $absen = Absen::where('kelas_id', $kelas->id)
                        ->where('tanggal', $tanggal)
                        ->get()
                        ->keyBy('murid_id');

                    $data = [
                        'kelas' => $kelas,
                        'murid' => $kelas->murid,
                        'absen' => $absen,
                        'tanggal' => $tanggal,
                    ];
                }
            }
        }

        return view('absen.admin.form', compact('masterKelas', 'tahunAjaran', 'data', 'errorMessage', 'masterKelasId', 'tahunAjaranId', 'tanggal'));
    }

    // Kode storeAdmin dari perbaikan sebelumnya (dengan pesan sukses/info)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date_format:Y-m-d',
            'status' => 'array',
            'keterangan' => 'array',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $selectedTahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);
        $tanggal = Carbon::parse($request->tanggal);

        // Validasi tahun ajaran
        $start = Carbon::parse($selectedTahunAjaran->tgl_mulai);
        $end = Carbon::parse($selectedTahunAjaran->tgl_selesai);
        if ($tanggal->lt($start) || $tanggal->gt($end)) {
            return back()->with('error', "Tahun ajaran dimulai dari {$start->format('F Y')} sampai {$end->format('F Y')}");
        }

        // Ambil absen yang sudah ada
        $existingAbsen = Absen::where('kelas_id', $request->kelas_id)
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('murid_id');

        $changed = false; // Flag untuk mengecek apakah ada perubahan

        // Proses absen untuk setiap murid
        foreach ($kelas->murid as $murid) {
            $muridId = $murid->id;
            $newStatus = $request->status[$muridId] ?? null;
            $newKeterangan = $request->keterangan[$muridId] ?? null;

            if ($newStatus && in_array($newStatus, ['H', 'I', 'S', 'A'])) {
                $existing = $existingAbsen[$muridId] ?? null;
                if ($existing) {
                    // Update hanya jika status atau keterangan berubah
                    if ($existing->status !== $newStatus || $existing->keterangan !== $newKeterangan) {
                        $existing->update([
                            'status' => $newStatus,
                            'keterangan' => $newKeterangan,
                        ]);
                        $changed = true;
                    }
                } else {
                    // Buat absen baru
                    Absen::create([
                        'tanggal' => $tanggal,
                        'kelas_id' => $request->kelas_id,
                        'murid_id' => $muridId,
                        'status' => $newStatus,
                        'keterangan' => $newKeterangan,
                    ]);
                    $changed = true;
                }
            }
        }

        // Redirect dengan parameter filter untuk mempertahankan state
        $redirect = redirect()->route('absen.admin.form', [
            'kelas_id' => $request->kelas_id,
            'master_kelas_id' => $kelas->master_kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tanggal' => $request->tanggal,
        ]);

        // Set pesan sukses atau info
        if ($changed) {
            return $redirect->with('success', 'Absen berhasil disimpan.');
        } else {
            return $redirect->with('info', 'Tidak ada perubahan pada data absen.');
        }
    }
}