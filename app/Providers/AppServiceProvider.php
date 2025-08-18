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
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use App\Models\KhsFile;


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

            return KhsFile::findOrFail($id);
        });

        // Storage::extend('google', function ($app, $config) {
        //     $client = new \Google\Client();
        //     $client->setClientId($config['clientId']);
        //     $client->setClientSecret($config['clientSecret']);
        //     $client->setAccessType('offline');
        //     $client->setScopes([\Google\Service\Drive::DRIVE]);
        //     $client->refreshToken($config['refreshToken']);

        //     $service = new \Google\Service\Drive($client);
        //     $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null, $config['teamDriveId'] ?? null);

        //     return new Filesystem($adapter);
        // });
    }
}
