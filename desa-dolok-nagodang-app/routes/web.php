<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCitizenPageController;

Route::get('/admin/citizens', [AdminCitizenPageController::class, 'index'])
        ->name('admin.citizens.index');

Route::get('/admin/citizens/create', [AdminCitizenPageController::class, 'create'])
        ->name('admin.citizens.create');

Route::post('/admin/citizens/store', [AdminCitizenPageController::class, 'store'])
        ->name('admin.citizens.store');

Route::get('/admin/citizens/{citizen}/edit', [AdminCitizenPageController::class, 'edit'])
        ->name('admin.citizens.edit');

Route::put('/admin/citizens/{citizen}', [AdminCitizenPageController::class, 'update'])
        ->name('admin.citizens.update');
        
Route::delete('/admin/citizens/{citizen}', [AdminCitizenPageController::class, 'destroy'])
        ->name('admin.citizens.destroy');