<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramStudiController as AdminProgramStudiController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TeamPositionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Program Studi Routes
Route::prefix('program-studi')->name('program-studi.')->group(function () {
    Route::get('/', [ProgramStudiController::class, 'index'])->name('index');
    Route::get('/{programStudi:code}', [ProgramStudiController::class, 'show'])->name('show');
});

// News Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{news:slug}', [NewsController::class, 'show'])->name('show');
});

// Events Routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
});

// Gallery Routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Contact Routes
Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

// Authentication Routes (from Breeze)
require __DIR__ . '/auth.php';

// Super Admin Routes
Route::middleware(['auth', 'verified', 'check.role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\SuperAdmin\UserController::class);
});


// Admin Routes (Protected)
Route::middleware(['auth', 'verified', 'check.role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //About
    Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
    Route::get('/about/create', [App\Http\Controllers\Admin\AboutController::class, 'create'])->name('about.create');
    Route::post('/about', [App\Http\Controllers\Admin\AboutController::class, 'store'])->name('about.store');
    Route::get('/about/edit', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/delete', [App\Http\Controllers\Admin\AboutController::class, 'destroy'])->name('about.destroy');
    Route::post('/about/toggle-status', [App\Http\Controllers\Admin\AboutController::class, 'toggleStatus'])->name('about.toggle-status');

    // Jika Anda ingin show route (optional)
    Route::get('/about/show', [App\Http\Controllers\Admin\AboutController::class, 'show'])->name('about.show');




    // Program Studi Management
    Route::resource('program-studi', AdminProgramStudiController::class)->parameters([
        'program-studi' => 'programStudi'
    ]);
    // Program Studi routes
    // Route::resource('program-studi', App\Http\Controllers\Admin\ProgramStudiController::class);


    // News Management
    Route::resource('news', AdminNewsController::class);

    // Contact Messages
    Route::resource('contact-messages', ContactMessageController::class)->parameters([
        'contact-messages' => 'contactMessage'
    ])->only(['index', 'show', 'update', 'destroy']);

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });

    // Academic Management
    Route::resource('kurikulum', App\Http\Controllers\Admin\KurikulumController::class);
    Route::resource('mata-kuliah', App\Http\Controllers\Admin\MataKuliahController::class);
    Route::resource('rps', App\Http\Controllers\Admin\RpsController::class);
    Route::resource('jadwal-kuliah', App\Http\Controllers\Admin\JadwalKuliahController::class);
    Route::resource('dosen-mata-kuliah', App\Http\Controllers\Admin\DosenMataKuliahController::class);

    // Penjaminan Mutu Routes
    Route::prefix('penjaminan-mutu')->name('penjaminan-mutu.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'store'])->name('store');
        Route::get('/{penjaminanMutu}', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'show'])->name('show');
        Route::get('/{penjaminanMutu}/edit', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'edit'])->name('edit');
        Route::put('/{penjaminanMutu}', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'update'])->name('update');
        Route::delete('/{penjaminanMutu}', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'destroy'])->name('destroy');
        Route::get('/{penjaminanMutu}/download', [App\Http\Controllers\Admin\PenjaminanMutuController::class, 'download'])->name('download');
    });

    Route::prefix('site-settings')->name('site-settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SiteSettingsController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SiteSettingsController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SiteSettingsController::class, 'store'])->name('store');
        Route::get('/{siteSetting}', [App\Http\Controllers\Admin\SiteSettingsController::class, 'show'])->name('show');
        Route::get('/{siteSetting}/edit', [App\Http\Controllers\Admin\SiteSettingsController::class, 'edit'])->name('edit');
        Route::put('/{siteSetting}', [App\Http\Controllers\Admin\SiteSettingsController::class, 'update'])->name('update');
        Route::delete('/{siteSetting}', [App\Http\Controllers\Admin\SiteSettingsController::class, 'destroy'])->name('destroy');

        // Bulk update route
        Route::post('/bulk-update', [App\Http\Controllers\Admin\SiteSettingsController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // Stats Routes
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\StatsController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\StatsController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\StatsController::class, 'store'])->name('store');
        Route::get('/{stat}', [App\Http\Controllers\Admin\StatsController::class, 'show'])->name('show');
        Route::get('/{stat}/edit', [App\Http\Controllers\Admin\StatsController::class, 'edit'])->name('edit');
        Route::put('/{stat}', [App\Http\Controllers\Admin\StatsController::class, 'update'])->name('update');
        Route::delete('/{stat}', [App\Http\Controllers\Admin\StatsController::class, 'destroy'])->name('destroy');

        // Special actions
        Route::patch('/{stat}/set-current', [App\Http\Controllers\Admin\StatsController::class, 'setCurrent'])->name('set-current');
    });

    // API routes for charts and public data
    Route::prefix('api/stats')->name('api.stats.')->group(function () {
        Route::get('/chart-data', [App\Http\Controllers\Admin\StatsController::class, 'getChartApi'])->name('chart-data');
        Route::get('/current', [App\Http\Controllers\Admin\StatsController::class, 'getCurrentStats'])->name('current');
    });

    // Team Position routes
    Route::resource('team-position', TeamPositionController::class)->parameters([
        'team-position' => 'teamPosition'
    ]);

    // Team routes
    Route::resource('team', TeamController::class);

    // Additional team routes
    Route::post('team/update-order', [TeamController::class, 'updateOrder'])
        ->name('team.update-order');
});

Route::middleware(['auth', 'verified', 'check.role:petugas_umum,admin,super_admin'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard'); // Atau Inertia jika pakai Vue
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', 'check.role:orang_tua,super_admin'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', function () {
        return view('parent.dashboard');
    })->name('dashboard');
});

// API Routes for AJAX requests
Route::prefix('api')->middleware('web')->group(function () {
    Route::get('/program-studi', function () {
        return \App\Models\ProgramStudi::active()->get();
    });

    Route::get('/news/latest', function () {
        return \App\Models\News::published()->latest()->take(5)->get();
    });

    Route::get('/events/upcoming', function () {
        return \App\Models\Event::upcoming()->take(5)->get();
    });

    Route::get('/chart-data', [App\Http\Controllers\Admin\StatsController::class, 'getChartApi'])->name('chart-data');
    Route::get('/current', [App\Http\Controllers\Admin\StatsController::class, 'getCurrentStats'])->name('current');
});
