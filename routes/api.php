<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

Route::middleware('Jwt.Auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    // Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
});


Route::apiResource('agendas', AgendaController::class);

Route::prefix('meetings')->middleware('Jwt.Auth')->group(function () {
    Route::post('/', [MeetingController::class, 'book']);
    Route::get('/', [MeetingController::class, 'index']);

    Route::get('/{id}', [MeetingController::class, 'show']);
});

// Route::post('/meetings/bookings/{id}/cancel', [MeetingController::class, 'cancel'])
//     ->middleware('Jwt.Auth');

Route::prefix('announcements')->middleware('Jwt.Auth')->group(function () {
    Route::get('', [AnnouncementController::class, 'index']);
    Route::post('', [AnnouncementController::class, 'store']);
    Route::put('/{announcement}', [AnnouncementController::class, 'update']);
    Route::delete('/{announcement}', [AnnouncementController::class, 'destroy']);
});
