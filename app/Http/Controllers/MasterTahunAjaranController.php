<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Validator;

class MasterTahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataTahunAjaran = TahunAjaran::query()->withCount('kelas')->with('kelas.master_kelas');
        if ($filter === 'aktif') {
            $dataTahunAjaran->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataTahunAjaran->where('is_active', 0);
        }
        $dataTahunAjaran = $dataTahunAjaran->get();
        return view('master.tahunajaran.index', compact('dataTahunAjaran', 'filter'));
    }
    public function isActive($id)
    {
        $tahunajaran = TahunAjaran::findOrFail($id);
        $tahunajaran->is_active = !$tahunajaran->is_active;
        $tahunajaran->save();

        return back()->with('success', 'Status tahun ajaran berhasil diperbarui');
    }
    
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|string|unique:tahun_ajaran,tahun_ajaran|regex:/^\d+\/\d+$/',
            'tgl_mulai' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $tahunAjaran = explode('/', $request->tahun_ajaran);
                    if (count($tahunAjaran) !== 2 || !is_numeric($tahunAjaran[0])) {
                        $fail('Format tahun ajaran tidak valid.');
                        return;
                    }
                    $tahunMulai = (int) $tahunAjaran[0];
                    $tahunFromTglMulai = (int) date('Y', strtotime($value));
                    if ($tahunFromTglMulai !== $tahunMulai) {
                        $fail('Tahun pada tanggal mulai harus sama dengan tahun mulai pada tahun ajaran.');
                    }
                },
            ],
            'tgl_selesai' => [
                'required',
                'date',
                'after:tgl_mulai',
                function ($attribute, $value, $fail) use ($request) {
                    $tahunAjaran = explode('/', $request->tahun_ajaran);
                    if (count($tahunAjaran) !== 2 || !is_numeric($tahunAjaran[0])) {
                        $fail('Format tahun ajaran tidak valid.');
                        return;
                    }
                    $tahunSelesai = (int) $tahunAjaran[0] + 1;
                    $tahunFromTglSelesai = (int) date('Y', strtotime($value));
                    if ($tahunFromTglSelesai !== $tahunSelesai) {
                        $fail('Tahun pada tanggal selesai harus sama dengan tahun selesai pada tahun ajaran.');
                    }
                },
            ],
            'is_active' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('form_mode', 'tambah');
        }

        TahunAjaran::create($validator->validated());

        return redirect()->route('master.tahunajaran.index')->with('success', 'Data tahun ajaran berhasil disimpan!');
    }

    public function edit(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|string|unique:tahun_ajaran,tahun_ajaran,' . $tahunAjaran->id . '|regex:/^\d+\/\d+$/',
            'tgl_mulai' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $tahunAjaran = explode('/', $request->tahun_ajaran);
                    if (count($tahunAjaran) !== 2 || !is_numeric($tahunAjaran[0])) {
                        $fail('Format tahun ajaran tidak valid.');
                        return;
                    }
                    $tahunMulai = (int) $tahunAjaran[0];
                    $tahunFromTglMulai = (int) date('Y', strtotime($value));
                    if ($tahunFromTglMulai !== $tahunMulai) {
                        $fail('Tahun pada tanggal mulai harus sama dengan tahun mulai pada tahun ajaran.');
                    }
                },
            ],
            'tgl_selesai' => [
                'required',
                'date',
                'after:tgl_mulai',
                function ($attribute, $value, $fail) use ($request) {
                    $tahunAjaran = explode('/', $request->tahun_ajaran);
                    if (count($tahunAjaran) !== 2 || !is_numeric($tahunAjaran[0])) {
                        $fail('Format tahun ajaran tidak valid.');
                        return;
                    }
                    $tahunSelesai = (int) $tahunAjaran[0] + 1;
                    $tahunFromTglSelesai = (int) date('Y', strtotime($value));
                    if ($tahunFromTglSelesai !== $tahunSelesai) {
                        $fail('Tahun pada tanggal selesai harus sama dengan tahun selesai pada tahun ajaran.');
                    }
                },
            ],
            'is_active' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('form_mode', 'edit')->with('edit_id', $id);
        }

        $tahunAjaran->update($validator->validated());

        return redirect()->route('master.tahunajaran.index')->with('success', 'Data tahun ajaran berhasil diupdate!');
    }
}
