<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Helpers\SiteSettingsHelper;
use App\Helpers\StatsHelper;
use App\Services\GoogleDriveService;
use App\Services\KhsManagementService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Google Drive Service as Singleton
        $this->app->singleton(GoogleDriveService::class, function ($app) {
            return new GoogleDriveService();
        });

        // Register KHS Management Service
        $this->app->bind(KhsManagementService::class, function ($app) {
            return new KhsManagementService(
                $app->make(GoogleDriveService::class)
            );
        });
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

        Route::bind('khsFile', function ($id) {
            if (Auth::guard('parent')->check()) {
                $parent = Auth::guard('parent')->user();
                return $parent->student->khsFiles()->where('id', $id)->ready()->firstOrFail();
            }

            return \App\Models\KhsFile::findOrFail($id);
        });
    }
}
