<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'aktif');

        $pengumuman = Pengumuman::query();
        if ($filter === 'aktif') {
            $pengumuman->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $pengumuman->where('is_active', 0);
        }
        $pengumuman = $pengumuman->get();

        return view('pengumuman.index', compact('pengumuman', 'filter'));
    }
    public function dashboard()
    {
        $pengumuman = Pengumuman::where('tgl_publish','<=',now())->get();

        return view('dashboard', compact('pengumuman'));
    }
    public function addView()
    {
        return view('pengumuman.add'); 
    }
    public function add(Request $request)
    {
        $pengumuman = new Pengumuman();
        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required',
            'flyer' => 'image',
            'tgl_publish'=>'required|date',
            'is_active' => 'required|in:1,0'
        ]);

        if($request->flyer)
        {
            $file = $request->file('flyer');
            $nama_file = 'pengumuman-'.time().'.'.$file->extension();
            $file->storeAs('flyer', $nama_file, 'public');
            $pengumuman->flyer = $nama_file;
        }
        $pengumuman->judul = $request->judul;
        $pengumuman->isi = $request->isi;
        $pengumuman->tgl_publish = $request->tgl_publish;
        $pengumuman->is_active = $request->is_active;
        $pengumuman->save();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }
    public function detail(Request $request, $id)
    {
        $pengumuman = Pengumuman::find($id);
        return view("pengumuman.detail",compact('pengumuman'));
    }
    public function editView($id)
    {
        $pengumuman = Pengumuman::find($id);
        return view("pengumuman.edit",compact('pengumuman'));
    }
    public function edit(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
    
        $validated = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required',
            'tgl_publish' => 'required|date',
            'flyer' => 'image',
            'is_active' => 'required|in:1,0'
        ]);

        if ($request->hasFile('flyer')) {
            // Hapus flyer lama jika ada
            $oldFilePath = storage_path('app/public/flyer/' . $pengumuman->flyer);
            if ($pengumuman->flyer && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Simpan flyer baru
            $file = $request->file('flyer');
            $nama_file = 'pengumuman-' . time() . '.' . $file->extension();
            $file->storeAs('flyer', $nama_file, 'public');
            $pengumuman->flyer = $nama_file;
        }

        $pengumuman->judul = $request->judul;
        $pengumuman->isi = $request->isi;
        $pengumuman->tgl_publish = $request->tgl_publish;
        $pengumuman->is_active = $request->is_active;
        $pengumuman->save();

        return redirect()->route('pengumuman.index')->with('success', 'Data Pengumuman berhasil diupdate');
    }
    public function isActive($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->is_active = !$pengumuman->is_active; 
        $pengumuman->save();

        return back()->with('success', 'Status pengumuman diperbarui.');
    }
}
