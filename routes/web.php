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
use Illuminate\Http\Request;

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
    
    // Prestasi Routes
    Route::controller(AdminPrestasiController::class)->group(function () {
        Route::get('/prestasi', 'index')->name('prestasi.index');
        Route::post('/prestasi/{id}/approve', 'approve')->name('prestasi.approve');
        Route::post('/prestasi/{id}/reject', 'reject')->name('prestasi.reject');
    });
    
    // Lomba Routes
    Route::controller(AdminLombaController::class)->group(function () {
        Route::get('/lomba', 'index')->name('lomba.index');
        Route::get('/lomba/create', 'create')->name('lomba.create');
        Route::post('/lomba', 'store')->name('lomba.store');
        Route::get('/lomba/{lomba}', 'show')->name('lomba.show');
        Route::get('/lomba/{lomba}/edit', 'edit')->name('lomba.edit');
        Route::put('/lomba/{lomba}', 'update')->name('lomba.update');
        Route::delete('/lomba/{lomba}', 'destroy')->name('lomba.destroy');
        Route::post('/lomba/{id}/toggle', 'toggleStatus')->name('lomba.toggle');
    });
    
    // Mahasiswa Routes
    Route::controller(AdminMahasiswaController::class)->group(function () {
        Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
        Route::get('/mahasiswa/create', 'create')->name('mahasiswa.create');
        Route::post('/mahasiswa', 'store')->name('mahasiswa.store');
        Route::get('/mahasiswa/{mahasiswa}/edit', 'edit')->name('mahasiswa.edit');
        Route::put('/mahasiswa/{mahasiswa}', 'update')->name('mahasiswa.update');
        Route::delete('/mahasiswa/{mahasiswa}', 'destroy')->name('mahasiswa.destroy');
        Route::get('/mahasiswa/pendaftaran/{id}', 'showPendaftaran')->name('mahasiswa.pendaftaran.show');
        Route::get('/mahasiswa/pendaftaran/{id}/edit', 'edit')->name('mahasiswa.pendaftaran.edit');
        Route::post('/mahasiswa/pendaftaran', 'storePendaftaran')->name('mahasiswa.pendaftaran.store');
        Route::put('/mahasiswa/pendaftaran/{id}', 'update')->name('mahasiswa.pendaftaran.update');
        Route::delete('/mahasiswa/pendaftaran/{id}', 'destroy')->name('mahasiswa.pendaftaran.destroy');
    });
});

// Test API Route
Route::prefix('api')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working']);
    });

    Route::post('/login/{role}', function (Request $request, $role) {
        return response()->json([
            'message' => 'Login endpoint hit',
            'role' => $role,
            'data' => $request->all()
        ]);
    });
});
