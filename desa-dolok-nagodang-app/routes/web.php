<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminCitizenPageController;
use App\Http\Controllers\AdminNewsPageController;
use App\Http\Controllers\AdminAssetPageController;
use App\Http\Controllers\AdminOfficialPageController;
use App\Http\Controllers\AdminLetterPageController;
use App\Http\Controllers\AdminLetterPdfController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/citizens', [AdminCitizenPageController::class, 'index'])->name('admin.citizens.index');
    Route::get('/citizens/create', [AdminCitizenPageController::class, 'create'])->name('admin.citizens.create');
    Route::post('/citizens', [AdminCitizenPageController::class, 'store'])->name('admin.citizens.store');
    Route::get('/citizens/{citizen}/edit', [AdminCitizenPageController::class, 'edit'])->name('admin.citizens.edit');
    Route::put('/citizens/{citizen}', [AdminCitizenPageController::class, 'update'])->name('admin.citizens.update');
    Route::delete('/citizens/{citizen}', [AdminCitizenPageController::class, 'destroy'])->name('admin.citizens.destroy');

    Route::get('/news', [AdminNewsPageController::class, 'index'])->name('admin.news.index');
    Route::get('/news/create', [AdminNewsPageController::class, 'create'])->name('admin.news.create');
    Route::post('/news', [AdminNewsPageController::class, 'store'])->name('admin.news.store');
    Route::get('/news/{news}/edit', [AdminNewsPageController::class, 'edit'])->name('admin.news.edit');
    Route::put('/news/{news}', [AdminNewsPageController::class, 'update'])->name('admin.news.update');
    Route::delete('/news/{news}', [AdminNewsPageController::class, 'destroy'])->name('admin.news.destroy');

    Route::get('/assets', [AdminAssetPageController::class, 'index'])->name('admin.assets.index');
    Route::get('/assets/create', [AdminAssetPageController::class, 'create'])->name('admin.assets.create');
    Route::post('/assets', [AdminAssetPageController::class, 'store'])->name('admin.assets.store');
    Route::get('/assets/{asset}/edit', [AdminAssetPageController::class, 'edit'])->name('admin.assets.edit');
    Route::put('/assets/{asset}', [AdminAssetPageController::class, 'update'])->name('admin.assets.update');
    Route::delete('/assets/{asset}', [AdminAssetPageController::class, 'destroy'])->name('admin.assets.destroy');

    Route::get('/officials', [AdminOfficialPageController::class, 'index'])->name('admin.officials.index');
    Route::get('/officials/create', [AdminOfficialPageController::class, 'create'])->name('admin.officials.create');
    Route::post('/officials', [AdminOfficialPageController::class, 'store'])->name('admin.officials.store');
    Route::get('/officials/{official}/edit', [AdminOfficialPageController::class, 'edit'])->name('admin.officials.edit');
    Route::put('/officials/{official}', [AdminOfficialPageController::class, 'update'])->name('admin.officials.update');
    Route::delete('/officials/{official}', [AdminOfficialPageController::class, 'destroy'])->name('admin.officials.destroy');

    Route::get('/letters', [AdminLetterPageController::class, 'index'])->name('admin.letters.index');
    Route::get('/letters/create', [AdminLetterPageController::class, 'create'])->name('admin.letters.create');
    Route::post('/letters', [AdminLetterPageController::class, 'store'])->name('admin.letters.store');
    Route::get('/letters/{letter}/edit', [AdminLetterPageController::class, 'edit'])->name('admin.letters.edit');
    Route::put('/letters/{letter}', [AdminLetterPageController::class, 'update'])->name('admin.letters.update');
    Route::delete('/letters/{letter}', [AdminLetterPageController::class, 'destroy'])->name('admin.letters.destroy');

    Route::get('/letters/{letter}/preview-pdf', [AdminLetterPdfController::class, 'preview'])->name('admin.letters.preview-pdf');
    Route::get('/letters/{letter}/download-pdf', [AdminLetterPdfController::class, 'download'])->name('admin.letters.download-pdf');
});