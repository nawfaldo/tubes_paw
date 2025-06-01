<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login/{role}', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/lomba', [AuthController::class, 'a']);
    Route::get('/lomba', [AuthController::class, 'b']);

    Route::post('/lomba/{lomba}/daftar', [AuthController::class, 'c']);

    Route::post('/prestasi', [AuthController::class, 'd']);
});
