<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterTahunAjaranController;
use App\Http\Controllers\MasterMapelController;

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

Route::get('/master/tahunajaran', [MasterTahunAjaranController::class, 'index'])->name('master.tahunajaran.index');
Route::patch('/master/tahunajaran/isActive/{id}', [MasterTahunAjaranController::class, 'isActive'])->name('master.tahunajaran.isActive');
Route::post('/master/tahunajaran/add', [MasterTahunAjaranController::class, 'add'])->name('master.tahunajaran.add');
Route::patch('/master/tahunajaran/edit/{id}', [MasterTahunAjaranController::class, 'edit'])->name('master.tahunajaran.edit');

Route::get('/master/mapel', [MasterMapelController::class, 'index'])->name('master.mapel.index');
Route::patch('/master/mapel/isActive/{id}', [MasterMapelController::class, 'isActive'])->name('master.mapel.isActive');
Route::post('/master/mapel/add', [MasterMapelController::class, 'add'])->name('master.mapel.add');
Route::patch('/master/mapel/edit/{id}', [MasterMapelController::class, 'edit'])->name('master.mapel.edit');