<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\KosImageController;
use App\Http\Controllers\KosFacilityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookController;

/*
AUTH
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

/*
REGISTER (PUBLIC)
*/
Route::post('/users', [UserController::class, 'store']);

/*
PUBLIC
*/
Route::get('/kos', [KosController::class, 'index']);
Route::get('/kos/{kos}', [KosController::class, 'show']);

/*
USER (LOGIN REQUIRED)
*/
Route::middleware('auth:sanctum')->group(function () {

    // PROFILE
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);

    // REVIEW
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // BOOKING (USER)
    Route::post('/bookings', [BookController::class, 'store']);
    Route::patch('/bookings/{id}/cancel', [BookController::class, 'cancel']);

    // RIWAYAT BOOKING USER
    Route::get('/bookings/me', [BookController::class, 'myBookings']);

    // DOWNLOAD STRUK (PDF)
    Route::get('/bookings/{id}/invoice', [BookController::class, 'downloadInvoice']);
});

/*
ADMIN ONLY
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // USER MANAGEMENT
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // KOS
    Route::post('/kos', [KosController::class, 'store']);
    Route::put('/kos/{kos}', [KosController::class, 'update']);
    Route::delete('/kos/{kos}', [KosController::class, 'destroy']);

    // KOS IMAGE
    Route::post('/kos-images', [KosImageController::class, 'store']);
    Route::delete('/kos-images/{id}', [KosImageController::class, 'destroy']);

    // KOS FACILITY
    Route::post('/kos-facilities', [KosFacilityController::class, 'store']);
    Route::delete('/kos-facilities/{id}', [KosFacilityController::class, 'destroy']);
    Route::delete('/kos/{kos}/facilities', [KosFacilityController::class, 'destroyByKos']);

    // BOOKING (ADMIN)

    Route::get('/admin/bookings', [BookController::class, 'index']);
    Route::patch('/admin/bookings/{id}/approve', [BookController::class, 'approve']);
    Route::patch('/admin/bookings/{id}/reject', [BookController::class, 'reject']);
    Route::patch('/admin/bookings/{id}/complete', [BookController::class, 'complete']);
    Route::delete('/admin/bookings/{id}', [BookController::class, 'destroy']);
});
