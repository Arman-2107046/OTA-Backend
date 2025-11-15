<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OneWayFlightController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// use Illuminate\Support\Facades\Route;

// Customer auth
Route::post('/customer/register', [AuthController::class, 'register']);
Route::post('/customer/login',    [AuthController::class, 'login']);

// Protected routes (need customer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer/me', [AuthController::class, 'me']);

    Route::post('/flight/one-way', [OneWayFlightController::class, 'store']);
});