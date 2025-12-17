<?php

use Illuminate\Support\Facades\Route;
use Modules\Lowongan\Http\Controllers\LowonganController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('lowongans', LowonganController::class)->names('lowongan');
});
