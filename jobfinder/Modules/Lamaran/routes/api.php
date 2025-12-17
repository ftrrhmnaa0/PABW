<?php

use Illuminate\Support\Facades\Route;
use Modules\Lamaran\Http\Controllers\LamaranController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('lamarans', LamaranController::class)->names('lamaran');
});

Route::get('/lamaran', [LamaranController::class, 'index']);
Route::post('/lamaran', [LamaranController::class, 'store']);
Route::get('/lamaran/{id}', [LamaranController::class, 'show']);
Route::put('/lamaran/{id}', [LamaranController::class, 'update']);
Route::delete('/lamaran/{id}', [LamaranController::class, 'destroy']);
