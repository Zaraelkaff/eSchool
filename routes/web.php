<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\MasterJabatanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/murid', [MuridController::class, 'index'])->name('murid.index');
Route::get('/murid/detail/{id}', [MuridController::class, 'detail'])->name('murid.detail');
Route::patch('/murid/isActive/{id}', [MuridController::class, 'isActive'])->name('murid.isActive');
Route::get('/murid/addView', [MuridController::class, 'addView'])->name('murid.addView');
Route::post('/murid/add', [MuridController::class, 'add'])->name('murid.add');
Route::get('/murid/editView/{id}', [MuridController::class, 'editView'])->name('murid.editView');
Route::patch('/murid/edit/{id}', [MuridController::class, 'edit'])->name('murid.edit');
Route::delete('/murid/kelas/hapus/{id}', [MuridController::class, 'hapusKelas'])->name('murid.kelas.delete');
Route::post('/murid/kelas/add', [MuridController::class, 'tambahKelas'])->name('murid.kelas.add');

Route::get('/master/jabatan', [MasterJabatanController::class, 'index'])->name('master.jabatan.index');
Route::patch('/master/jabatan/isActive/{id}', [MasterJabatanController::class, 'isActive'])->name('master.jabatan.isActive');
Route::post('/master/jabatan/add', [MasterJabatanController::class, 'add'])->name('master.jabatan.add');
Route::patch('/master/jabatan/edit/{id}', [MasterJabatanController::class, 'edit'])->name('master.jabatan.edit');