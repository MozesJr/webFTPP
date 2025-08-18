<?php
// routes/web.php - Complete fixed version

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


// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\SuperAdmin\ParentController;
use App\Http\Controllers\SuperAdmin\GoogleDriveAuthController;
use App\Http\Controllers\SuperAdmin\KhsController;


use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Student;
use App\Models\AcademicPeriod;
use App\Services\KhsManagementService;

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

// Unauthorized route
Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
})->name('unauthorized');

Route::get('/test-google', function () {
    try {
        // test tulis dan list
        $ok = Storage::disk('google')->put('hello.txt', 'OK from Laravel');
        $files = Storage::disk('google')->files(); // harusnya array, tanpa error Masbug
        return response()->json(['put' => $ok, 'files' => $files]);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/debug-google-api', function () {
    try {
        $client = new \Google\Client();
        $client->setClientId(config('filesystems.disks.google.clientId'));
        $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $client->setAccessType('offline');
        // pakai scope penuh Drive biar bisa tulis
        $client->setScopes([\Google\Service\Drive::DRIVE]);

        // set token awal (boleh kosong), lalu refresh pakai refresh_token
        $client->setAccessToken(['access_token' => config('filesystems.disks.google.accessToken')]);
        $client->refreshToken(config('filesystems.disks.google.refreshToken'));

        $service = new \Google\Service\Drive($client);

        // list 5 file teratas
        $resp = $service->files->listFiles([
            'pageSize' => 5,
            'fields'   => 'files(id, name)',
        ]);

        // coba upload kecil (text/plain)
        $file = new \Google\Service\Drive\DriveFile([
            'name' => 'ping_via_api_' . date('Ymd_His') . '.txt',
            // kalau kamu ingin ke folder tertentu, set parents => [folderId]
            // 'parents' => [env('GOOGLE_DRIVE_FOLDER')],
        ]);
        $created = $service->files->create($file, [
            'data' => 'hello from direct api',
            'mimeType' => 'text/plain',
            'uploadType' => 'multipart',
            'fields' => 'id, name',
        ]);

        return response()->json([
            'list'    => $resp->getFiles(),
            'created' => $created,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
});


Route::get('/test-khs-upload', function (KhsManagementService $svc) {
    $student = Student::firstOrFail();
    $period  = AcademicPeriod::firstOrFail();

    // siapkan dummy.pdf
    $path = storage_path('app/dummy.pdf');
    if (!file_exists($path)) {
        file_put_contents($path, '%PDF-1.4
% Dummy PDF
1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj
2 0 obj<</Type/Pages/Count 0/Kids[]>>endobj
trailer<</Root 1 0 R>>
%%EOF');
    }

    $uploaded = $svc->uploadKhsForStudent(
        new \Illuminate\Http\UploadedFile($path, 'dummy.pdf', 'application/pdf', null, true),
        $student,
        $period,
        auth()->id() ?? 1
    );

    return response()->json($uploaded);
});

// Authentication Routes (from Breeze)
require __DIR__ . '/auth.php';
// require __DIR__ . '/parent.php';

// ==============================================
// SUPER ADMIN Routes - Full Access
// ==============================================
Route::middleware(['auth', 'verified', 'check.role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Role Management Routes
    Route::resource('roles', RoleController::class);

    // Permission Management Routes
    Route::resource('permissions', PermissionController::class);

    // System Settings (future)
    Route::get('/system-settings', function () {
        return Inertia::render('SuperAdmin/SystemSettings', [
            'message' => 'System settings will be implemented here'
        ]);
    })->name('system-settings');

    Route::get('/debug-auth', function () {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'is_super_admin' => $user->hasRole('super_admin'),
            'middleware_data' => [
                'roles' => $user->getRoleNames()->toArray(),
                'is_super_admin' => $user->hasRole('super_admin'),
                'is_admin' => $user->hasRole('admin'),
            ]
        ]);
    })->middleware('auth');

    Route::get('/debug-inertia', function () {
        return \Inertia\Inertia::render('DebugPage', [
            'testMessage' => 'Debug Inertia Props',
        ]);
    })->middleware('auth');

    // Parent Import Routes (HARUS DI ATAS resource routes)
    Route::get('parents/import', [ParentController::class, 'showImport'])->name('parents.import');
    Route::post('parents/import', [ParentController::class, 'import'])->name('parents.import.store');
    Route::get('parents/download-template', [ParentController::class, 'downloadTemplate'])->name('parents.download-template');

    // Parent Management Routes
    Route::resource('parents', ParentController::class);

    // Additional Parent Routes
    Route::post('parents/{parent}/reset-password', [ParentController::class, 'resetPassword'])->name('parents.reset-password');
    Route::post('parents/{parent}/toggle-status', [ParentController::class, 'toggleStatus'])->name('parents.toggle-status');

    // User additional routes (if needed)
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::prefix('khs')->name('khs.')->group(function () {

        // Main KHS management
        Route::get('/', [KhsController::class, 'index'])->name('index');
        Route::get('/{khsFile}', [KhsController::class, 'show'])->name('show');
        Route::delete('/{khsFile}', [KhsController::class, 'destroy'])->name('destroy');
        Route::post('/{khsFile}/retry', [KhsController::class, 'retry'])->name('retry');

        // Academic Period Management
        Route::get('/periods/manage', [KhsController::class, 'periods'])->name('periods');
        Route::get('/periods/create', [KhsController::class, 'createPeriod'])->name('periods.create');
        Route::post('/periods', [KhsController::class, 'storePeriod'])->name('periods.store');
        Route::post('/periods/{period}/activate', [KhsController::class, 'activatePeriod'])->name('periods.activate');

        // Single Upload
        Route::get('/upload/single', [KhsController::class, 'upload'])->name('upload');
        Route::post('/upload/single', [KhsController::class, 'storeUpload'])->name('store-upload');

        // Bulk Upload
        Route::get('/upload/bulk', [KhsController::class, 'bulkUpload'])->name('bulk-upload');
        Route::post('/upload/bulk', [KhsController::class, 'storeBulkUpload'])->name('store-bulk-upload');

        // Utilities
        Route::get('/template/download', [KhsController::class, 'downloadTemplate'])->name('download-template');
        Route::get('/report/{period}', [KhsController::class, 'generateReport'])->name('report');

        // API Endpoints for Frontend
        Route::get('/api/students-by-period', [KhsController::class, 'getStudentsByPeriod'])->name('api.students-by-period');
        Route::get('/api/period-stats/{period}', [KhsController::class, 'getPeriodStats'])->name('api.period-stats');
        Route::get('/api/search-students', [KhsController::class, 'searchStudents'])->name('api.search-students');

        // Academic Period Management - Tambahan routes
        Route::get('/periods/{period}/edit', [KhsController::class, 'editPeriod'])->name('periods.edit');
        Route::put('/periods/{period}', [KhsController::class, 'updatePeriod'])->name('periods.update');
        Route::delete('/periods/{period}', [KhsController::class, 'destroyPeriod'])->name('periods.destroy');
    });



    Route::get('/google/drive/connect', [GoogleDriveAuthController::class, 'connect'])->name('gdrive.connect');
    Route::get('/google/drive/callback', [GoogleDriveAuthController::class, 'callback'])->name('gdrive.callback');
});

// ==============================================
// ADMIN Routes - Faculty Management (Admin + Super Admin)
// ==============================================
Route::middleware(['auth', 'verified', 'check.role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // About Management
    Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
    Route::get('/about/create', [App\Http\Controllers\Admin\AboutController::class, 'create'])->name('about.create');
    Route::post('/about', [App\Http\Controllers\Admin\AboutController::class, 'store'])->name('about.store');
    Route::get('/about/edit', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/delete', [App\Http\Controllers\Admin\AboutController::class, 'destroy'])->name('about.destroy');
    Route::post('/about/toggle-status', [App\Http\Controllers\Admin\AboutController::class, 'toggleStatus'])->name('about.toggle-status');
    Route::get('/about/show', [App\Http\Controllers\Admin\AboutController::class, 'show'])->name('about.show');

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
    Route::post('team/update-order', [TeamController::class, 'updateOrder'])->name('team.update-order');
});

// ==============================================
// PETUGAS UMUM Routes - Support Staff (Petugas + Admin + Super Admin)
// ==============================================
Route::middleware(['auth', 'verified', 'check.role:petugas_umum,admin,super_admin'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Petugas/Dashboard', [
            'role' => auth()->user()->getRoleNames()->first(),
            'user' => auth()->user(),
            'message' => 'Selamat datang di panel Petugas Umum',
            'capabilities' => [
                'Kelola berita dan pengumuman',
                'Balas pesan dari masyarakat',
                'Update jadwal kuliah',
                'Akses data fakultas (read-only)'
            ]
        ]);
    })->name('dashboard');

    // News management (create, edit allowed)
    Route::resource('news', AdminNewsController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

    // Contact messages (can reply)
    Route::resource('contact-messages', ContactMessageController::class)
        ->parameters(['contact-messages' => 'contactMessage'])
        ->only(['index', 'show', 'update']);

    // Jadwal kuliah (can edit for operational changes)
    Route::get('/jadwal-kuliah', [App\Http\Controllers\Admin\JadwalKuliahController::class, 'index'])->name('jadwal-kuliah.index');
    Route::get('/jadwal-kuliah/{jadwalKuliah}', [App\Http\Controllers\Admin\JadwalKuliahController::class, 'show'])->name('jadwal-kuliah.show');
    Route::get('/jadwal-kuliah/{jadwalKuliah}/edit', [App\Http\Controllers\Admin\JadwalKuliahController::class, 'edit'])->name('jadwal-kuliah.edit');
    Route::put('/jadwal-kuliah/{jadwalKuliah}', [App\Http\Controllers\Admin\JadwalKuliahController::class, 'update'])->name('jadwal-kuliah.update');
});

// ==============================================
// PARENT Routes - Parent Portal (Parent + Super Admin)
// ==============================================
Route::middleware(['auth', 'verified', 'check.role:orang_tua,super_admin'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Parent/Dashboard', [
            'user' => auth()->user(),
            'message' => 'Portal Orang Tua sedang dalam pengembangan',
            'status' => 'under_development',
            'planned_features' => [
                [
                    'title' => 'Lihat KHS Anak',
                    'description' => 'Akses kartu hasil studi per semester',
                    'status' => 'planned'
                ],
                [
                    'title' => 'Monitoring Nilai',
                    'description' => 'Pantau perkembangan akademik anak',
                    'status' => 'planned'
                ],
                [
                    'title' => 'Pengumuman Khusus',
                    'description' => 'Terima pengumuman penting dari fakultas',
                    'status' => 'planned'
                ],
                [
                    'title' => 'Jadwal Kuliah Anak',
                    'description' => 'Lihat jadwal kuliah anak real-time',
                    'status' => 'planned'
                ]
            ]
        ]);
    })->name('dashboard');

    // Future KHS routes (placeholder)
    /*
    Route::get('/khs', [ParentController::class, 'viewKHS'])->name('khs');
    Route::get('/child/info', [ParentController::class, 'childInfo'])->name('child.info');
    Route::get('/child/grades', [ParentController::class, 'childGrades'])->name('child.grades');
    Route::get('/announcements', [ParentController::class, 'announcements'])->name('announcements');
    */
});

// ==============================================
// Shared Routes (All authenticated users)
// ==============================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes for all users
    Route::get('/profile', function () {
        return Inertia::render('Profile/Edit', [
            'user' => auth()->user(),
            'role' => auth()->user()->getRoleNames()->first()
        ]);
    })->name('profile.edit');

    // User can update their own profile
    Route::patch('/profile', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return redirect()->route('profile.edit')->with('flash', [
            'type' => 'success',
            'message' => 'Profile updated successfully.'
        ]);
    })->name('profile.update');
});

// ==============================================
// API Routes for AJAX requests
// ==============================================
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

    // User role check API (for dynamic UI)
    Route::middleware('auth')->get('/user/role', function () {
        return response()->json([
            'user' => auth()->user(),
            'roles' => auth()->user()->getRoleNames(),
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
            'is_super_admin' => auth()->user()->hasRole('super_admin'),
            'is_admin' => auth()->user()->hasRole('admin'),
            'is_petugas' => auth()->user()->hasRole('petugas_umum'),
            'is_parent' => auth()->user()->hasRole('orang_tua'),
        ]);
    });
});
