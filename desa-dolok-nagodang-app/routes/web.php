<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCitizenPageController;

Route::get('/admin/citizens', [AdminCitizenPageController::class, 'index'])
        ->name('admin.citizens.index');
Route::delete('/admin/citizens/{citizen}', [AdminCitizenPageController::class, 'destroy'])
        ->name('admin.citizens.destroy');