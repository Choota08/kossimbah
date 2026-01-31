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
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| REGISTER (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/users', [UserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/kos', [KosController::class, 'index']);
Route::get('/kos/{kos}', [KosController::class, 'show']);

/*
|--------------------------------------------------------------------------
| USER & ADMIN (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // 🔹 PROFILE SENDIRI (USER & ADMIN)
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);

    // 🔐 GANTI PASSWORD
    Route::post('/change-password', [UserController::class, 'changePassword']);

    // REVIEW
    Route::post('/review', [ReviewController::class, 'store']);
    Route::put('/review/{id}', [ReviewController::class, 'update']);
    Route::delete('/review/{id}', [ReviewController::class, 'destroy']);

    // BOOKING
    Route::post('/book', [BookController::class, 'store']);
    Route::patch('/book/{id}', [BookController::class, 'updateStatus']);
    Route::delete('/book/{id}', [BookController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // 🔹 USER MANAGEMENT
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // KOS
    Route::post('/kos', [KosController::class, 'store']);
    Route::put('/kos/{kos}', [KosController::class, 'update']);
    Route::delete('/kos/{kos}', [KosController::class, 'destroy']);

    // KOS IMAGE
    Route::post('/kos-image', [KosImageController::class, 'store']);
    Route::delete('/kos-image/{id}', [KosImageController::class, 'destroy']);

    // KOS FACILITY
    Route::post('/kos-facility', [KosFacilityController::class, 'store']);
    Route::delete('/kos-facility/{id}', [KosFacilityController::class, 'destroy']);
});
