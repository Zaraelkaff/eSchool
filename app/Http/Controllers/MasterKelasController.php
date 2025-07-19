<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKelas;

class MasterKelasController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter','aktif');
        $dataKelas = MasterKelas::query();
        if($filter === 'aktif'){
            $dataKelas->where('is_active',1);
        }elseif($filter === 'nonaktif'){
            $dataKelas->where('is_active',0);
        }
        $dataKelas = $dataKelas->orderBy('level','asc')->get();
        return view('master.kelas.index', compact ('dataKelas', 'filter'));
    }
    public function isActive($id)
    {
        $kelas = MasterKelas::findOrFail($id);
        $kelas->is_active = !$kelas->is_active;
        $kelas->save();

        return back()->with('success', 'Status master kelas berhasil diperbarui');
    }
    public function add(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|unique:master_kelas,nama_kelas',
            'level' => 'required|int|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        MasterKelas::create([
            'nama_kelas' => $request->nama_kelas,
            'level' => $request->level,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('master.kelas.index')->with('success', 'Data master kelas berhasil disimpan!');
    }
    public function edit(Request $request, $id)
    {
        $kelas = MasterKelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required|string|unique:master_kelas,nama_kelas,'.$kelas->id,
            'level'=>'required|int|min:1',
            'is_active' => 'required|in:0,1',
        ]);
        $kelas->update($validated);

        return redirect()->route('master.kelas.index')->with('success', 'Data master kelas berhasil diupdate');
    }
}
