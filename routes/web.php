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

// Admin Routes (Protected)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



    // Program Studi Management
    Route::resource('program-studi', AdminProgramStudiController::class)->parameters([
        'program-studi' => 'programStudi'
    ]);

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

    // Additional admin resources (add as needed)
    // Route::resource('teams', TeamController::class);
    // Route::resource('testimonials', TestimonialController::class);
    // Route::resource('clients', ClientController::class);
    // Route::resource('galleries', GalleryController::class);
    // Route::resource('events', EventController::class);
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
});
