<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
   Route::post('login', LoginController::class);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', LogoutController::class);
    Route::apiResource('accommodations', AccommodationController::class);
});
Route::get('search', SearchController::class);
