<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitizenController;

Route::apiResource('citizens', CitizenController::class);