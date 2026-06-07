<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminCitizenPageController;
use App\Http\Controllers\AdminNewsPageController;
use App\Http\Controllers\AdminAssetPageController;
use App\Http\Controllers\AdminOfficialPageController;
use App\Http\Controllers\AdminLetterPageController;
use App\Http\Controllers\AdminLetterPdfController;

//tambahan untuk infrastruktur
use App\Http\Controllers\Admin\InfrastructureController;


use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\PublicOfficialController;
use App\Http\Controllers\PublicVillageProfileController;
use App\Http\Controllers\PublicLetterServiceController;
use App\Http\Controllers\PublicComplaintController;
use App\Http\Controllers\PublicInfrastructureController;


Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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


Route::middleware('track.visitor')->group(function () {
    Route::get('/', [PublicHomeController::class, 'index'])->name('public.home');

    Route::get('/berita', [PublicNewsController::class, 'index'])->name('public.news.index');
    Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('public.news.show');

    Route::get('/profil-desa', [PublicVillageProfileController::class, 'index'])->name('public.profile');
    Route::get('/aparat-desa', [PublicOfficialController::class, 'index'])->name('public.officials');
    Route::get('/layanan-surat', [PublicLetterServiceController::class, 'index'])
        ->name('public.letters');

    Route::get('/layanan-surat/{code}', [PublicLetterServiceController::class, 'show'])
        ->name('public.letters.show');
        
    Route::get('/layanan-surat/{code}/ajukan', [PublicLetterServiceController::class, 'apply'])
        ->name('public.letters.apply');
        
    Route::post('/layanan-surat/{code}/ajukan', [PublicLetterServiceController::class, 'storeApplication'])
        ->name('public.letters.storeApplication');

    Route::post('/pengaduan', [PublicComplaintController::class, 'store'])
    ->name('public.complaints.store');
    
});

//route baru untuk infrastruktur
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('infrastructure', InfrastructureController::class);
// });
Route::middleware('auth')->prefix('admin/infrastructure')->name('admin.infrastructure.')->group(function () {
    Route::get('/', [PublicInfrastructureController::class, 'adminIndex'])->name('index');
    Route::get('/create', [PublicInfrastructureController::class, 'create'])->name('create');
    Route::post('/', [PublicInfrastructureController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PublicInfrastructureController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PublicInfrastructureController::class, 'update'])->name('update');
    Route::delete('/{id}', [PublicInfrastructureController::class, 'destroy'])->name('destroy');
});


Route::prefix('infrastruktur')->name('public.infrastruktur.')->group(function () {

    Route::get('/', [PublicInfrastructureController::class, 'index'])
        ->name('index');

    Route::get('/{slug}', [PublicInfrastructureController::class, 'show'])
        ->name('show');

});

require __DIR__.'/auth.php';
