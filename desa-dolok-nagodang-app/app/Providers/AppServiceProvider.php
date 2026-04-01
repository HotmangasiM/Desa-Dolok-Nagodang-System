<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CitizenRepositoryInterface;  
use App\Repositories\CitizenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CitizenRepositoryInterface::class, CitizenRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
