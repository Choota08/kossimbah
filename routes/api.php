<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\KosImageController;
use App\Http\Controllers\KosFacilityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookController;




Route::get('/', function () {
    return view('welcome');
});


Route::apiResource('users', UserController::class);
Route::apiResource('kos', KosController::class);
Route::apiResource('kos-images', KosImageController::class)->only(['store','destroy']);
Route::apiResource('kos-facilities', KosFacilityController::class)->only(['store','destroy']);
Route::apiResource('reviews', ReviewController::class)->only(['store','destroy']);
Route::apiResource('books', BookController::class);
Route::get('test-api', function () {
    return 'API Loaded';
});
