<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class MuridController extends Controller
{
    public function index(Request $request){
        $filter = $request->query('filter', 'aktif');
        $dataMurid = Murid::query();
        if ($filter === 'aktif') {
            $dataMurid->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataMurid->where('is_active', 0);
        }
        $dataMurid = $dataMurid->get();
        return view('murid.index', compact('dataMurid', 'filter'));
    }
    public function detail(Request $request, $id)
    {
        $murid = Murid::with('kelas.master_kelas', 'kelas.tahun_ajaran')->findOrFail($id);
        return view('murid.detail',compact('murid'));
    }
    public function addView(){
        $kelas = Kelas::with(['master_kelas','tahun_ajaran'])->where('is_active', true)->get();
        return view('murid.add', compact('kelas'));
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'NIK' => 'required|string|max:16|unique:murid,NIK',
            'NIS' => 'required|string|unique:murid,NIS',
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'notelp' => 'required|string|regex:/^[0-9]+$/',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'tgl_masuk' => 'required|date',
            'tgl_keluar' => 'nullable|date',
            'kelas_id' => 'nullable|exists:kelas,id',
            'is_active' => 'required|in:1,0'
        ],[
            'NIK.unique' => 'NIK sudah ada di database!',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini!',
        ]);

        $murid = Murid::create($validated);

        // Kalau ada kelas_id, simpan ke tabel pivot kelas_murid
        if ($request->filled('kelas_id')) {
            DB::table('kelas_murid')->insert([
                'murid_id' => $murid->id,
                'kelas_id' => $request->kelas_id,
            ]);
        }

        return redirect()->route('murid.index')->with('success', 'Murid berhasil ditambahkan');
    }
    public function editView($id)
    {
        $kelas = Kelas::with(['master_kelas', 'tahun_ajaran'])->get();
        $murid = Murid::with('kelasMurid.kelas.master_kelas', 'kelasMurid.kelas.tahun_ajaran')->findOrFail($id);
        return view('murid.edit',compact('murid','kelas'));
    }
    public function edit(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);
        $validated = $request->validate([
            'NIK' => 'required|string|max:16|unique:murid,NIK,' . $murid->id,
            'NIS' => 'required|string|unique:murid,NIS,' . $murid->id,
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'notelp' => 'required|string|regex:/^[0-9]+$/',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'tgl_masuk' => 'required|date',
            'tgl_keluar' => 'nullable|date',
            'is_active' => 'required|in:1,0',
        ], [
            'NIK.unique' => 'NIK sudah ada di database!',
            'NIS.unique' => 'NIS sudah ada di database!',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini!',
            'notelp.regex' => 'Nomor telepon hanya boleh berisi angka!',
        ]);
        $murid->update($validated);

        return redirect()->route('murid.index')->with('success', 'Data murid berhasil diupdate');
    }
    public function hapusKelas($id)
    {
        DB::table('kelas_murid')->where('id', $id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus');
    }
    public function tambahKelas(Request $request)
    {
        $request->validate([
            'murid_id' => 'required|exists:murid,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        // Cek apakah kelas sudah pernah diambil murid ini
        $sudahAda = DB::table('kelas_murid')
            ->where('murid_id', $request->murid_id)
            ->where('kelas_id', $request->kelas_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Kelas sudah pernah diambil oleh murid ini.');
        }

        DB::table('kelas_murid')->insert([
            'murid_id' => $request->murid_id,
            'kelas_id' => $request->kelas_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan');
    }
    public function isActive($id)
    {
        $murid = Murid::findOrFail($id);
        $murid->is_active = !$murid->is_active;
        $murid->save();

        return back()->with('success', 'Status murid berhasil diperbarui');
    }
}
