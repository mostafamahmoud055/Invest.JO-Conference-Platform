<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

Route::middleware('Jwt.Auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    // Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
});


Route::apiResource('agendas', AgendaController::class);
