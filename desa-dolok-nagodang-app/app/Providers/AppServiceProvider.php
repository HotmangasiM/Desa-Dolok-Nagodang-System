<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CitizenRepositoryInterface;  
use App\Repositories\CitizenRepository;
use App\Interfaces\NewsRepositoryInterface;
use App\Repositories\NewsRepository;
use App\Interfaces\AssetRepositoryInterface;
use App\Repositories\AssetRepository;
use App\Interfaces\OfficialRepositoryInterface;
use App\Repositories\OfficialRepository;
use App\Interfaces\LetterRepositoryInterface;
use App\Repositories\LetterRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CitizenRepositoryInterface::class, CitizenRepository::class);
        $this->app->bind(\App\Interfaces\NewsRepositoryInterface::class, \App\Repositories\NewsRepository::class);
        $this->app->bind(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->bind(OfficialRepositoryInterface::class, OfficialRepository::class);
        $this->app->bind(LetterRepositoryInterface::class, LetterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
