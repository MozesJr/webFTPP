<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Helpers\SiteSettingsHelper;
use App\Helpers\StatsHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SiteSettingsHelper::shareWithViews();
        Vite::prefetch(concurrency: 3);

        // Auto-clear cache when stats are updated
        // StatsHelper::saved(function ($stat) {
        //     \App\Helpers\StatsHelper::clearCache();
        // });

        // StatsHelper::deleted(function ($stat) {
        //     \App\Helpers\StatsHelper::clearCache();
        // });
    }
}
