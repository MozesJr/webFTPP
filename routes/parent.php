<?php
// routes/parent.php
// Include this in routes/web.php with: require __DIR__.'/parent.php';

use App\Http\Controllers\Parent\AuthController;
use App\Http\Controllers\Parent\DashboardController;
use Illuminate\Support\Facades\Route;

// ========================================
// PARENT AUTHENTICATION ROUTES
// ========================================

Route::prefix('parent')->name('parent.')->group(function () {

    // Guest routes (unauthenticated)
    Route::middleware('guest:parent')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
        Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    });

    // Authenticated routes
    Route::middleware(['auth:parent', 'parent.active'])->group(function () {

        // ========================================
        // DASHBOARD & MAIN ROUTES
        // ========================================
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('home');

        // ========================================
        // KHS MANAGEMENT ROUTES
        // ========================================
        Route::prefix('khs')->name('khs.')->group(function () {
            Route::get('/', [DashboardController::class, 'khsList'])->name('index');
            Route::get('{khsFile}', [DashboardController::class, 'khsDetail'])->name('detail');
            Route::get('{khsFile}/download', [DashboardController::class, 'downloadKhs'])->name('download');
            Route::get('{khsFile}/preview', [DashboardController::class, 'previewKhs'])->name('preview');
            Route::get('search', [DashboardController::class, 'searchKhs'])->name('search');
        });

        // ========================================
        // QUICK ACTIONS
        // ========================================
        Route::get('download-latest', [DashboardController::class, 'quickDownloadLatest'])->name('download-latest');

        // ========================================
        // API ROUTES (for AJAX calls)
        // ========================================
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('khs/year/{year}', [DashboardController::class, 'getKhsByYear'])->name('khs.by-year');
            Route::get('access-stats', [DashboardController::class, 'getAccessStats'])->name('access-stats');
        });

        // ========================================
        // PROFILE & ACCOUNT MANAGEMENT
        // ========================================
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::get('access-history', [DashboardController::class, 'accessHistory'])->name('access-history');

        // Password management
        Route::get('change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
        Route::put('change-password', [AuthController::class, 'changePassword'])->name('password.update');

        // ========================================
        // LOGOUT
        // ========================================
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// ========================================
// MIDDLEWARE DEFINITIONS
// ========================================

// Add this to app/Http/Kernel.php in $routeMiddleware array:
/*
'parent.active' => \App\Http\Middleware\EnsureParentIsActive::class,
*/
