<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuridController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/murid', [MuridController::class, 'index'])->name('murid.index');
Route::patch('/murid/isActive/{id}', [MuridController::class, 'isActive'])->name('murid.isActive');