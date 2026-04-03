<?php

use Illuminate\Support\Facades\Route;

// Route::apiResource('citizens', 'App\Http\Controllers\Api\CitizenController');
Route::get('/test', function () {
    return 'Laravel is working!';
});