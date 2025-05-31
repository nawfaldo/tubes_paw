<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PrestasiController;
use App\Http\Controllers\Api\LombaController;
use App\Http\Controllers\Api\PendaftaranLombaController;

// Public Routes
Route::post('/login/{role}', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Prestasi Routes
    Route::apiResource('prestasi', PrestasiController::class);
    
    // Lomba Routes
    Route::apiResource('lomba', LombaController::class);
    Route::post('/lomba/{lomba}/daftar', [PendaftaranLombaController::class, 'store']);
    
    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/mahasiswa', [AuthController::class, 'getMahasiswa']);
        Route::put('/prestasi/{prestasi}/status', [PrestasiController::class, 'updateStatus']);
        Route::put('/pendaftaran/{pendaftaran}/status', [PendaftaranLombaController::class, 'updateStatus']);
    });
}); 