<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Jabatan;
use App\Models\JabatanStaff;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $filter_active = $request->query('filter_active');
        $dataStaff = Staff::query();
        if ($filter_active === 'aktif') {
            $dataStaff->where('is_active', 1);
        } elseif ($filter_active === 'nonaktif') {
            $dataStaff->where('is_active', 0);
        }
        $dataStaff = $dataStaff->orderBy('nama', 'asc')->get();

        return view('staff.index', compact('dataStaff', 'filter_active'));
    }

    public function detail($id)
    {
        $staff = Staff::with(['jabatan_staff.jabatan', 'kelas'])->findOrFail($id);
        $jabatan = Jabatan::where('is_active', true)->get();
        return view('staff.detail', compact('staff', 'jabatan'));
    }

    public function addView()
    {
        $jabatan = Jabatan::where('is_active', true)->get();
        return view('staff.add', compact('jabatan'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'NIK' => 'required|string|max:16|unique:staff,NIK',
            'nama' => 'required|string',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'alamat' => 'required|string',
            'notelp' => 'required|string|regex:/^[0-9]+$/',
            'lulusan' => 'nullable|string',
            'tgl_masuk' => 'required|date',
            'tgl_keluar' => 'nullable|date',
            'jabatan_id' => 'required|exists:jabatan,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after:tgl_mulai',
        ], [
            'NIK.unique' => 'NIK sudah ada di database!',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini!',
            'tgl_selesai.after' => 'Tanggal selesai harus lebih besar dari tanggal mulai!',
        ]);

        $staff = Staff::create($validated);

        if ($request->filled('jabatan_id')) {
            JabatanStaff::create([
                'staff_id' => $staff->id,
                'jabatan_id' => $request->jabatan_id,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai
            ]);
        }

        return redirect()->route('staff.index')->with('success', 'Staff berhasil ditambahkan');
    }

    public function editView($id)
    {
        $jabatan = Jabatan::where('is_active', true)->get();
        $staff = Staff::with('jabatan_staff.jabatan')->findOrFail($id);
        return view('staff.edit', compact('jabatan', 'staff'));
    }

    public function edit(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'NIK' => 'required|string|max:16|unique:staff,NIK,'.$id,
            'nama' => 'required|string',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'alamat' => 'required|string',
            'notelp' => 'required|string|regex:/^[0-9]+$/',
            'lulusan' => 'nullable|string',
            'tgl_masuk' => 'required|date',
            'tgl_keluar' => 'nullable|date',
        ], [
            'NIK.unique' => 'NIK sudah ada di database!',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini!',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')->with('success', 'Staff berhasil diperbarui');
    }

    public function addJabatan(Request $request, $staffId)
    {
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after:tgl_mulai',
            'is_active' => 'nullable|boolean',
        ], [
            'jabatan_id.required' => 'Jabatan harus dipilih!',
            'jabatan_id.exists' => 'Jabatan tidak valid!',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi!',
            'tgl_mulai.date' => 'Tanggal mulai harus berupa tanggal yang valid!',
            'tgl_selesai.date' => 'Tanggal selesai harus berupa tanggal yang valid!',
            'tgl_selesai.after' => 'Tanggal selesai harus lebih besar dari tanggal mulai!',
        ]);
        JabatanStaff::create([
            'staff_id' => $staffId,
            'jabatan_id' => $request->jabatan_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'is_active' => $request->is_active ?? 0,
        ]);
        return redirect()->route('staff.editView', $staffId)->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function updateJabatan(Request $request, $staffId, $jabatanStaffId)
    {
        try {
            $validated = $request->validate([
                'jabatan_id' => 'required|exists:jabatan,id',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'nullable|date|after:tgl_mulai',
                'is_active' => 'nullable',
            ], [
                'jabatan_id.required' => 'Jabatan harus dipilih!',
                'jabatan_id.exists' => 'Jabatan tidak valid!',
                'tgl_mulai.required' => 'Tanggal mulai wajib diisi!',
                'tgl_mulai.date' => 'Tanggal mulai harus berupa tanggal yang valid!',
                'tgl_selesai.date' => 'Tanggal selesai harus berupa tanggal yang valid!',
                'tgl_selesai.after' => 'Tanggal selesai harus lebih besar dari tanggal mulai!',
            ]);

            $jabatanStaff = JabatanStaff::findOrFail($jabatanStaffId);
            $jabatanStaff->update([
                'jabatan_id' => $request->jabatan_id,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'is_active' => $request->filled('is_active') ? 1 : 0,
            ]);

            return response()->json(['success' => true]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            Log::error('Validation error in updateJabatan:', ['errors' => $errors]);
            $errorMessage = array_shift($errors)[0]; // Take the first error message
            return response()->json(['success' => false, 'message' => $errorMessage], 422);
        } catch (\Exception $e) {
            Log::error('Error in updateJabatan:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function deleteJabatan(Request $request, $staffId, $jabatanStaffId)
    {
        try {
            $jabatanStaff = JabatanStaff::findOrFail($jabatanStaffId);
            $jabatanStaff->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in deleteJabatan:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}