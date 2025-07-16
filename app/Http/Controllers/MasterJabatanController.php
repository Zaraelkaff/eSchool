<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class MasterJabatanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataJabatan = Jabatan::query()->withCount('jabatan_staff')->with('jabatan_staff.staff');
        if ($filter === 'aktif') {
            $dataJabatan->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataJabatan->where('is_active', 0);
        }
        $dataJabatan = $dataJabatan->get();
        return view('master.jabatan.index', compact('dataJabatan', 'filter'));
    }
    public function isActive($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->is_active = !$jabatan->is_active;
        $jabatan->save();

        return back()->with('success', 'Status jabatan berhasil diperbarui');
    }
    public function add(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|unique:jabatan,nama_jabatan',
            'is_active' => 'required|in:0,1',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('master.jabatan.index')->with('success', 'Data jabatan berhasil disimpan!');
    }
    public function edit(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $validated = $request->validate([
            'nama_jabatan' => 'required|string|unique:jabatan,nama_jabatan,'.$jabatan->id,
            'is_active' => 'required|in:0,1',
        ]);
        $jabatan->update($validated);

        return redirect()->route('master.jabatan.index')->with('success', 'Data jabatan berhasil diupdate');
    }
}
