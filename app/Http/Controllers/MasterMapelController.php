<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class MasterMapelController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter','aktif');
        $dataMapel = Mapel::query()->where('id', '!=', 1);
        if($filter === 'aktif'){
            $dataMapel->where('is_active',1);
        }elseif($filter === 'nonaktif'){
            $dataMapel->where('is_active',0);
        }
        $dataMapel = $dataMapel->get();
        return view('master.mapel.index', compact ('dataMapel', 'filter'));
    }
    public function isActive($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->is_active = !$mapel->is_active;
        $mapel->save();

        return back()->with('success', 'Status mapel berhasil diperbarui');
    }
    public function add(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|unique:mapel,nama_mapel',
            'is_active' => 'required|in:0,1',
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('master.mapel.index')->with('success', 'Data mata pelajaran berhasil disimpan!');
    }
    public function edit(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $validated = $request->validate([
            'nama_mapel' => 'required|string|unique:mapel,nama_mapel,'.$mapel->id,
            'is_active' => 'required|in:0,1',
        ]);
        $mapel->update($validated);

        return redirect()->route('master.mapel.index')->with('success', 'Data mata pelajaran berhasil diupdate');
    }
}
