<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthCMController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthCMController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthCMController::class, 'logout']);
});

use App\Http\Controllers\Api\CategoryCMController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('categories', CategoryCMController::class);
});

use App\Http\Controllers\Api\EventCMController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('events', EventCMController::class);
    Route::patch('events/{event}/archive', [EventCMController::class, 'archive']);
});


