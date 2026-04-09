<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCitizenPageController;
use App\Http\Controllers\AdminNewsPageController;
use App\Http\Controllers\AdminAssetPageController;

//Citizen
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

//news
Route::get('/admin/news', [AdminNewsPageController::class, 'index'])->name('admin.news.index');
Route::get('/admin/news/create', [AdminNewsPageController::class, 'create'])->name('admin.news.create');
Route::post('/admin/news', [AdminNewsPageController::class, 'store'])->name('admin.news.store');
Route::get('/admin/news/{news}/edit', [AdminNewsPageController::class, 'edit'])->name('admin.news.edit');
Route::put('/admin/news/{news}', [AdminNewsPageController::class, 'update'])->name('admin.news.update');
Route::delete('/admin/news/{news}', [AdminNewsPageController::class, 'destroy'])->name('admin.news.destroy');

// Assets
Route::get('/admin/assets', [AdminAssetPageController::class, 'index'])->name('admin.assets.index');
Route::get('/admin/assets/create', [AdminAssetPageController::class, 'create'])->name('admin.assets.create');
Route::post('/admin/assets', [AdminAssetPageController::class, 'store'])->name('admin.assets.store');
Route::get('/admin/assets/{asset}/edit', [AdminAssetPageController::class, 'edit'])->name('admin.assets.edit');
Route::put('/admin/assets/{asset}', [AdminAssetPageController::class, 'update'])->name('admin.assets.update');
Route::delete('/admin/assets/{asset}', [AdminAssetPageController::class, 'destroy'])->name('admin.assets.destroy');