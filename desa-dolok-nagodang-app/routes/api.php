<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\OfficialController;

Route::apiResource('citizens', CitizenController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('assets', AssetController::class);
Route::apiResource('officials', OfficialController::class);