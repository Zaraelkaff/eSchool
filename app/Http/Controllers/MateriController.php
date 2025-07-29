<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\SubMateri;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MateriController extends Controller
{
    public function index($kelas_mapel_id)
    {
        $kelasMapel = KelasMapel::findOrFail($kelas_mapel_id);
        $materi = Materi::where('mapel', $kelas_mapel_id)->with('sub_materi')->get();
        return view('materi.index', compact('materi', 'kelasMapel'));
    }

    public function storeMateri(Request $request, $kelas_mapel_id)
    {
        $request->validate([
            'pertemuan' => [
                'required',
                'integer',
                Rule::unique('materi', 'pertemuan')->where('mapel', $kelas_mapel_id),
            ],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Materi::create([
            'mapel' => $kelas_mapel_id,
            'pertemuan' => $request->pertemuan,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function storeSubMateri(Request $request, $materi_id)
    {
        $request->validate([
            'subjudul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file', // Menerima semua jenis file tanpa batas ukuran
        ]);

        $data = [
            'materi_id' => $materi_id,
            'subjudul' => $request->subjudul,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('sub_materi', 'public');
        }

        SubMateri::create($data);

        return redirect()->back()->with('success', 'Sub-materi berhasil ditambahkan.');
    }

    public function updateMateri(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'pertemuan' => [
                'sometimes',
                'integer',
                Rule::unique('materi', 'pertemuan')->where('mapel', $materi->mapel)->ignore($id),
            ],
        ]);

        $materi->update($request->only(['judul', 'deskripsi', 'pertemuan']));

        return response()->json(['message' => 'Materi berhasil diperbarui.']);
    }

    public function updateSubMateri(Request $request, $id)
    {
        $request->validate([
            'subjudul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
        ]);

        $subMateri = SubMateri::findOrFail($id);
        $subMateri->update($request->only(['subjudul', 'deskripsi']));

        return response()->json(['message' => 'Sub-materi berhasil diperbarui.']);
    }

    public function destroyMateri($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->sub_materi()->delete(); // Hapus sub-materi terkait
        $materi->delete();

        return redirect()->back()->with('success', 'Materi dan sub-materinya berhasil dihapus.');
    }

    public function destroySubMateri($id)
    {
        $subMateri = SubMateri::findOrFail($id);
        $subMateri->delete();

        return redirect()->back()->with('success', 'Sub-materi berhasil dihapus.');
    }
}