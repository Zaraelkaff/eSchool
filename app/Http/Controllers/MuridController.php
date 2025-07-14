<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;

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
    public function isActive($id)
    {
        $murid = Murid::findOrFail($id);
        $murid->is_active = !$murid->is_active;
        $murid->save();

        return back()->with('success', 'Status murid berhasil diperbarui');
    }
}
