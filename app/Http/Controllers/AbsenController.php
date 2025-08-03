<?php
namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kelas;
use App\Models\MasterKelas;
use App\Models\TahunAjaran;
use App\Models\Murid;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
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

    public function indexWaliKelas(Request $request)
    {
        // Ambil staff terkait pengguna login
        $staff = Staff::where('users_id', Auth::id())->first();
        if (!$staff) {
            return redirect()->route('absen.wali_kelas.index')->with('error', 'Anda tidak memiliki kelas yang dikelola.');
        }

        // Ambil kelas yang dikelola wali kelas
        $kelasList = Kelas::where('wali_kelas_id', $staff->id)->get();
        if ($kelasList->isEmpty()) {
            return redirect()->route('absen.wali_kelas.index')->with('error', 'Anda tidak memiliki kelas yang dikelola.');
        }

        // Filter
        $kelasId = $request->query('kelas_id');
        $monthYear = $request->query('month_year'); // Format: YYYY-MM

        $data = [];
        $errorMessage = null;

        if ($monthYear) {
            $monthYearCarbon = Carbon::createFromFormat('Y-m', $monthYear);

            // Ambil kelas yang akan ditampilkan
            $filteredKelas = $kelasId && $kelasId !== 'all'
                ? $kelasList->where('id', $kelasId)->filter()
                : $kelasList;

            foreach ($filteredKelas as $kelas) {
                // Validasi tahun ajaran
                $selectedTahunAjaran = TahunAjaran::find($kelas->tahun_ajaran_id);
                if ($selectedTahunAjaran) {
                    $start = Carbon::parse($selectedTahunAjaran->tgl_mulai)->startOfMonth();
                    $end = Carbon::parse($selectedTahunAjaran->tgl_selesai)->endOfMonth();
                    if ($monthYearCarbon < $start || $monthYearCarbon > $end) {
                        $errorMessage = "Tahun ajaran untuk kelas {$kelas->master_kelas->nama_kelas} dimulai dari {$start->format('F Y')} sampai {$end->format('F Y')}";
                        continue;
                    }

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

        return view('absen.wali_kelas.index', compact('kelasList', 'data', 'errorMessage', 'kelasId', 'monthYear'));
    }

    public function formWaliKelas(Request $request, $kelasId = null)
    {
        // Ambil staff terkait pengguna login
        $staff = Staff::where('users_id', Auth::id())->first();
        if (!$staff) {
            return redirect()->route('absen.wali_kelas.index')->with('error', 'Anda tidak memiliki kelas yang dikelola.');
        }

        // Ambil kelas yang dikelola wali kelas
        $kelasList = Kelas::where('wali_kelas_id', $staff->id)->get();
        if ($kelasList->isEmpty()) {
            return redirect()->route('absen.wali_kelas.index')->with('error', 'Anda tidak memiliki kelas yang dikelola.');
        }

        // Filter
        $kelasId = $kelasId ?? $request->query('kelas_id');
        $tanggal = Carbon::today()->format('Y-m-d'); // Tanggal otomatis hari ini

        $data = [];
        $errorMessage = null;

        if ($kelasId) {
            // Validasi kelas milik wali kelas
            $kelas = $kelasList->where('id', $kelasId)->first();
            if (!$kelas) {
                return redirect()->route('absen.wali_kelas.index')->with('error', 'Kelas tidak ditemukan atau bukan kelas yang Anda kelola.');
            }

            // Validasi tahun ajaran
            $selectedTahunAjaran = TahunAjaran::find($kelas->tahun_ajaran_id);
            if ($selectedTahunAjaran) {
                $tanggalCarbon = Carbon::today();
                $start = Carbon::parse($selectedTahunAjaran->tgl_mulai);
                $end = Carbon::parse($selectedTahunAjaran->tgl_selesai);

                if ($tanggalCarbon->lt($start) || $tanggalCarbon->gt($end)) {
                    $errorMessage = "Tanggal hari ini ({$tanggalCarbon->format('d F Y')}) berada di luar tahun ajaran untuk kelas {$kelas->master_kelas->nama_kelas} ({$start->format('F Y')} sampai {$end->format('F Y')}).";
                } else {
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

        return view('absen.wali_kelas.form', compact('kelasList', 'data', 'errorMessage', 'kelasId', 'tanggal'));
    }

    public function storeWaliKelas(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'status' => 'array',
            'keterangan' => 'array',
        ]);

        // Validasi kelas milik wali kelas
        $staff = Staff::where('users_id', Auth::id())->first();
        if (!$staff) {
            return back()->with('error', 'Anda tidak memiliki kelas yang dikelola.');
        }

        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('wali_kelas_id', $staff->id)
            ->first();
        if (!$kelas) {
            return back()->with('error', 'Kelas tidak ditemukan atau bukan kelas yang Anda kelola.');
        }

        $selectedTahunAjaran = TahunAjaran::findOrFail($kelas->tahun_ajaran_id);
        $tanggal = Carbon::today();

        // Validasi tahun ajaran
        $start = Carbon::parse($selectedTahunAjaran->tgl_mulai);
        $end = Carbon::parse($selectedTahunAjaran->tgl_selesai);
        if ($tanggal->lt($start) || $tanggal->gt($end)) {
            return back()->with('error', "Tanggal hari ini ({$tanggal->format('d F Y')}) berada di luar tahun ajaran untuk kelas {$kelas->master_kelas->nama_kelas} ({$start->format('F Y')} sampai {$end->format('F Y')}).");
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
        $redirect = redirect()->route('absen.wali_kelas.form', [
            'kelas_id' => $request->kelas_id,
        ]);

        // Set pesan sukses atau info
        if ($changed) {
            return $redirect->with('success', 'Absen berhasil disimpan.');
        } else {
            return $redirect->with('info', 'Tidak ada perubahan pada data absen.');
        }
    }

    public function indexMurid(Request $request)
    {
        // Ambil murid terkait pengguna login
        $murid = Murid::where('users_id', Auth::id())->first();
        if (!$murid) {
            return redirect()->route('absen.murid.index')->with('error', 'Anda tidak terdaftar sebagai murid.');
        }
        $namaMurid = $murid->nama;

        // Ambil kelas yang diambil murid
        $kelasList = $murid->kelas()->get();
        if ($kelasList->isEmpty()) {
            return redirect()->route('absen.murid.index')->with('error', 'Anda tidak memiliki riwayat kelas.');
        }

        // Filter
        $kelasId = $request->query('kelas_id');

        $data = [];
        $errorMessage = null;

        // Ambil kelas yang akan ditampilkan
        $filteredKelas = $kelasId && $kelasId !== 'all'
            ? $kelasList->where('id', $kelasId)->filter()
            : $kelasList;

        foreach ($filteredKelas as $kelas) {
            // Ambil tahun ajaran
            $selectedTahunAjaran = TahunAjaran::find($kelas->tahun_ajaran_id);
            if ($selectedTahunAjaran) {
                // Hitung rentang bulan dalam tahun ajaran
                $start = Carbon::parse($selectedTahunAjaran->tgl_mulai)->startOfMonth();
                $end = Carbon::parse($selectedTahunAjaran->tgl_selesai)->endOfMonth();
                $months = [];
                $currentMonth = $start->copy();
                while ($currentMonth <= $end) {
                    $months[] = [
                        'year' => $currentMonth->year,
                        'month' => $currentMonth->month,
                        'label' => $currentMonth->format('F Y'),
                    ];
                    $currentMonth->addMonth();
                }

                // Ambil data absen untuk murid dan kelas
                $absen = Absen::where('kelas_id', $kelas->id)
                    ->where('murid_id', $murid->id)
                    ->whereBetween('tanggal', [$start, $end])
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->tanggal->format('Y-m-d');
                    });

                $data[$kelas->id] = [
                    'kelas' => $kelas,
                    'months' => $months,
                    'absen' => $absen,
                    'days' => range(1, 31),
                ];
            }
        }

        return view('absen.murid.index', compact('kelasList', 'data', 'errorMessage', 'kelasId','namaMurid'));
    }
}