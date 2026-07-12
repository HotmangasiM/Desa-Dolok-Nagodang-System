<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\OfficialController;
use App\Http\Controllers\Api\LetterController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('citizens', CitizenController::class);
    Route::apiResource('news', NewsController::class);
    Route::apiResource('assets', AssetController::class);
    Route::apiResource('officials', OfficialController::class);
    Route::apiResource('letters', LetterController::class);
});