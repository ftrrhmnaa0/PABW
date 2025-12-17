<?php

use Illuminate\Support\Facades\Route;
use Modules\Lamaran\Http\Controllers\LamaranController;

Route::middleware(['auth'])->group(function () {
    Route::get('/lamaran', [LamaranController::class,'index']);
    Route::post('/lamaran', [LamaranController::class,'store']);
    Route::delete('/lamaran/{id}', [LamaranController::class,'destroy']);
});
