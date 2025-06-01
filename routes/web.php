<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\Admin\AdminPrestasiController;
use App\Http\Controllers\Admin\AdminLombaController;
use App\Http\Controllers\Admin\AdminMahasiswaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('lomba', AdminLombaController::class);

    Route::controller(LombaController::class)->group(function () {
        Route::get('/lomba', 'index')->name('lomba.index');
        Route::get('/lomba/{lomba}', 'show')->name('lomba.show');
        Route::get('/lomba/{lomba}/daftar', 'formDaftar')->name('lomba.daftar.form');
        Route::post('/lomba/{lomba}/daftar', 'daftar')->name('lomba.daftar');
    });


});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('prestasi', AdminPrestasiController::class);
    Route::resource('lomba', AdminLombaController::class);
    Route::resource('mahasiswa', AdminMahasiswaController::class);
    Route::get('/pendaftaran-lomba/{pendaftaran}', [AdminMahasiswaController::class, 'showPendaftaran'])->name('mahasiswa.pendaftaran.show');
    Route::post('/prestasi/{prestasi}/approve', [AdminPrestasiController::class, 'approve'])->name('prestasi.approve');
    Route::post('/prestasi/{prestasi}/reject', [AdminPrestasiController::class, 'reject'])->name('prestasi.reject');
    Route::get('/laporan', function() {
        return view('admin.laporan.index');
    })->name('laporan.index');
});