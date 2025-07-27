<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterTahunAjaranController;
use App\Http\Controllers\MasterMapelController;
use App\Http\Controllers\MasterKelasController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PengumumanController;

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

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/detail/{id}', [StaffController::class, 'detail'])->name('staff.detail');
Route::get('/staff/addView', [StaffController::class, 'addView'])->name('staff.addView');
Route::post('/staff/add', [StaffController::class, 'add'])->name('staff.add');
Route::get('/staff/editView/{id}', [StaffController::class, 'editView'])->name('staff.editView');
Route::patch('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
Route::post('/staff/{staff}/jabatan', [StaffController::class, 'addJabatan'])->name('staff.jabatan.add');
Route::patch('/staff/{staff}/jabatan/{jabatanStaff}', [StaffController::class, 'updateJabatan'])->name('staff.jabatan.update');
Route::delete('/staff/{staff}/jabatan/{jabatanStaff}', [StaffController::class, 'deleteJabatan'])->name('staff.jabatan.delete');
Route::get('/staff/{staff}/jadwal', [JadwalController::class, 'jadwalGuru'])->name('staff.jadwal');

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

Route::get('/master/kelas', [MasterKelasController::class, 'index'])->name('master.kelas.index');
Route::patch('/master/kelas/isActive/{id}', [MasterKelasController::class, 'isActive'])->name('master.kelas.isActive');
Route::post('/master/kelas/add', [MasterKelasController::class, 'add'])->name('master.kelas.add');
Route::patch('/master/kelas/edit/{id}', [MasterKelasController::class, 'edit'])->name('master.kelas.edit');

Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::post('/kelas/add', [KelasController::class, 'add'])->name('kelas.add');
Route::get('/kelas/editView/{id}', [KelasController::class, 'editView'])->name('kelas.editView');
Route::patch('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
Route::delete('/kelas/{kelas_id}/murid/{murid_id}', [KelasController::class, 'hapusMurid'])->name('kelas.murid.hapus');
Route::get('/kelas/{id}', [KelasController::class, 'detail'])->name('kelas.detail');
Route::post('/kelas/{kelas_id}/murid/tambah', [KelasController::class, 'tambahMurid'])->name('kelas.murid.tambah');
Route::post('/kelas/{kelas_id}/mapel/tambah', [KelasController::class, 'tambahMapel'])->name('kelas.mapel.tambah');
Route::delete('/kelas/{kelas_id}/mapel/{mapel_id}', [KelasController::class, 'hapusMapel'])->name('kelas.mapel.hapus');
Route::get('kelas/{kelas_id}/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::post('jadwal/tambah', [JadwalController::class, 'add'])->name('jadwal.add');
Route::delete('jadwal/{id}', [JadwalController::class, 'delete'])->name('jadwal.delete');

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/dashboard', [PengumumanController::class, 'dashboard'])->name('dashboard');
Route::get('/pengumuman/add', [PengumumanController::class, 'addView'])->name('pengumuman.addView');
Route::post('/pengumuman/add',[PengumumanController::class, 'add'])->name('pengumuman.add');
Route::get('/pengumuman/edit/{id}', [PengumumanController::class, 'editView'])->name('pengumuman.editView');
Route::patch('/pengumuman/edit/{id}', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
Route::patch('/pengumuman/isActive/{id}', [PengumumanController::class, 'isActive'])->name('pengumuman.isActive');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'detail'])->name('pengumuman.detail');