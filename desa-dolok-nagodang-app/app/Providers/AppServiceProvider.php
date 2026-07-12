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
use App\Models\VisitorLog;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.public', function ($view) {
            $today = now()->toDateString();
            $yesterday = now()->subDay()->toDateString();

            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $startOfLastWeek = now()->subWeek()->startOfWeek();
            $endOfLastWeek = now()->subWeek()->endOfWeek();

            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $startOfLastMonth = now()->subMonth()->startOfMonth();
            $endOfLastMonth = now()->subMonth()->endOfMonth();

            $view->with('visitorStats', [
                'today' => VisitorLog::whereDate('visited_date', $today)->count(),
                'yesterday' => VisitorLog::whereDate('visited_date', $yesterday)->count(),
                'this_week' => VisitorLog::whereBetween('visited_date', [$startOfWeek, $endOfWeek])->count(),
                'last_week' => VisitorLog::whereBetween('visited_date', [$startOfLastWeek, $endOfLastWeek])->count(),
                'this_month' => VisitorLog::whereBetween('visited_date', [$startOfMonth, $endOfMonth])->count(),
                'last_month' => VisitorLog::whereBetween('visited_date', [$startOfLastMonth, $endOfLastMonth])->count(),
                'total' => VisitorLog::count(),
            ]);
        });
    }
}
