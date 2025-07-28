<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jam;
use Illuminate\Validation\Rule;

class MasterJamController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataJam = Jam::query();
        if ($filter === 'aktif') {
            $dataJam->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataJam->where('is_active', 0);
        }
        $dataJam = $dataJam->get();
        return view('master.jam.index', compact('dataJam', 'filter'));
    }

    public function isActive($id)
    {
        $jam = Jam::findOrFail($id);
        $jam->is_active = !$jam->is_active;
        $jam->save();

        return back()->with('success', 'Status jam pelajaran berhasil diperbarui');
    }

    public function add(Request $request)
    {
        $request->validate([
            'jam_mulai' => [
                'required',
                'date_format:H:i',
                Rule::unique('jam')->where(function ($query) use ($request) {
                    return $query->where('jam_selesai', $request->jam_selesai);
                })
            ],
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_active' => 'required|in:0,1',
        ], [
            'jam_mulai.unique' => 'Kombinasi jam mulai dan jam selesai sudah ada.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        Jam::create([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('master.jam.index')->with('success', 'Data jam pelajaran berhasil disimpan!');
    }

    public function edit(Request $request, $id)
    {
        $jam = Jam::findOrFail($id);

        $request->validate([
            'jam_mulai' => [
                'required',
                'date_format:H:i',
                Rule::unique('jam')->where(function ($query) use ($request, $id) {
                    return $query->where('jam_selesai', $request->jam_selesai)
                                ->where('id', '!=', $id);
                })
            ],
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_active' => 'required|in:0,1',
        ], [
            'jam_mulai.unique' => 'Kombinasi jam mulai dan jam selesai sudah ada.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        $jam->update([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('master.jam.index')->with('success', 'Data jam pelajaran berhasil diupdate');
    }
}