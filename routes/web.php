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

// Role Selection and Authentication Routes
Route::get('/', [AuthController::class, 'showRoleSelection'])->name('role.selection');
Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/{role}', [AuthController::class, 'login']);
Route::get('/register/{role}', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register/{role}', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mahasiswa Routes
Route::middleware(['auth:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    
    // Prestasi Routes
    Route::controller(PrestasiController::class)->group(function () {
        Route::get('/prestasi', 'index')->name('prestasi.index');
        Route::get('/prestasi/create', 'create')->name('prestasi.create');
        Route::post('/prestasi', 'store')->name('prestasi.store');
        Route::get('/prestasi/{prestasi}', 'show')->name('prestasi.show');
        Route::get('/prestasi/{prestasi}/edit', 'edit')->name('prestasi.edit');
        Route::put('/prestasi/{prestasi}', 'update')->name('prestasi.update');
        Route::delete('/prestasi/{prestasi}', 'destroy')->name('prestasi.destroy');
    });
    
    // Lomba Routes
    Route::controller(LombaController::class)->group(function () {
        Route::get('/lomba', 'index')->name('lomba.index');
        Route::get('/lomba/{lomba}', 'show')->name('lomba.show');
        Route::get('/lomba/{lomba}/daftar', 'formDaftar')->name('lomba.daftar.form');
        Route::post('/lomba/{lomba}/daftar', 'daftar')->name('lomba.daftar');
    });
});

// Admin Routes
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
