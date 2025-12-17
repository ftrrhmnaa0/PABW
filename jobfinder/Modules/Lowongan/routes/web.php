<?php

use Illuminate\Support\Facades\Route;
use Modules\Lowongan\Http\Controllers\LowonganController;

Route::middleware('auth')->group(function () {

    Route::get('/lowongan', [LowonganController::class, 'index']);
    Route::get('/lowongan/data', [LowonganController::class, 'data']);
    Route::post('/lowongan', [LowonganController::class, 'store']);
    Route::get('/lowongan/{id}/edit', [LowonganController::class, 'edit']);
    Route::delete('/lowongan/{id}', [LowonganController::class, 'destroy']);

});

