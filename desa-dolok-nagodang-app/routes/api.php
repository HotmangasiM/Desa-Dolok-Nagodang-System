<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\AssetController;

Route::apiResource('citizens', CitizenController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('assets', AssetController::class);