<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\NewsController;

Route::apiResource('citizens', CitizenController::class);
Route::apiResource('news', NewsController::class);