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

use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\EvaluationReportController;
use App\Http\Controllers\EvaluationFormController;
use App\Http\Controllers\Admin\DeanGreetingController;
use App\Http\Controllers\FacilityController;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TerminalController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\SuperAdmin\ParentController;
use App\Http\Controllers\SuperAdmin\GoogleDriveAuthController;
use App\Http\Controllers\SuperAdmin\KhsController;
use App\Http\Controllers\GPMController;

// GPM
use App\Http\Controllers\Admin\GPM\StrukturOrganisasiController;
use App\Http\Controllers\Admin\GPM\DokumenSPMIController;
use App\Http\Controllers\Admin\GPM\SurveyController;
use App\Http\Controllers\Admin\GPM\EDOMPeriodController;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\PublicKemahasiswaanController;
use App\Http\Controllers\PublicAlumniController;

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
// About Routes
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('index');
    Route::get('/profile', [AboutController::class, 'profile'])->name('profile');
    Route::get('/vision-mission', [AboutController::class, 'visionMission'])->name('vision-mission');
    Route::get('/history', [AboutController::class, 'history'])->name('history');
    Route::get('/program-studi', [AboutController::class, 'programStudi'])->name('program-studi');
    Route::get('/accreditation', [AboutController::class, 'accreditation'])->name('accreditation');
    Route::get('/leadership', [AboutController::class, 'leadership'])->name('leadership');
});

Route::get('/about-old', [AboutController::class, 'index'])->name('about-old');

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

Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/facilities/{slug}', [FacilityController::class, 'show'])->name('facilities.show');

// GPM Main Page (existing)
Route::get('/evaluation', [GPMController::class, 'index'])->name('gpm.index');


// GPM Sub-menu Routes
Route::prefix('gpm')->name('gpm.')->group(function () {
    Route::get('/struktur-organisasi', [GPMController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/dokumen-spmi', [GPMController::class, 'dokumenSPMI'])->name('dokumen-spmi');
    Route::get('/survey-kepuasan', [GPMController::class, 'surveyKepuasan'])->name('survey-kepuasan');
    Route::get('/survey-edom', [GPMController::class, 'surveyEDOM'])->name('survey-edom');
    Route::get('/survey/{slug}', [GPMController::class, 'surveyFill'])
        ->name('survey.fill');

    // Document detail & download
    Route::get('/dokumen-spmi/{slug}', [GPMController::class, 'viewDokumen'])->name('dokumen-spmi.view');
    Route::get('/dokumen-spmi/{slug}/download', [GPMController::class, 'downloadDokumen'])->name('dokumen-spmi.download');
});

Route::get('/kemahasiswaan', [PublicKemahasiswaanController::class, 'index'])->name('kemahasiswaan.index');
Route::get('/alumni', [PublicAlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{id}', [PublicAlumniController::class, 'show'])->name('alumni.show');


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

Route::prefix('evaluation')->name('evaluation.')->group(function () {
    Route::get('/', [EvaluationFormController::class, 'index'])->name('index');
    Route::get('/success', [EvaluationFormController::class, 'success'])->name('success');
    Route::post('/check-student', [EvaluationFormController::class, 'checkStudent'])->name('check-student');
    // Route dengan parameter harus di bawah
    Route::get('/{questionnaire}/create', [EvaluationFormController::class, 'create'])->name('create');
    Route::post('/{questionnaire}', [EvaluationFormController::class, 'store'])->name('store');
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



    Route::get('/google/drive/connect', [GoogleDriveAuthController::class, 'connect'])->name('gdrive.connect');
    Route::get('/google/drive/callback', [GoogleDriveAuthController::class, 'callback'])->name('gdrive.callback');

    // ── Web Terminal (hanya superadmin@faculty.ac.id) ──────────────────────
    Route::get('/terminal', [TerminalController::class, 'index'])->name('terminal.index');
    Route::get('/terminal/stream', [TerminalController::class, 'stream'])->name('terminal.stream');
    Route::get('/terminal/deploy', [TerminalController::class, 'deploy'])->name('terminal.deploy');
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

    // Dean Greeting Routes
    // Route::controller(DeanGreetingController::class)->prefix('dean-greeting')->name('dean-greeting.')->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/', 'store')->name('store');
    //     Route::get('/{deanGreeting}/edit', 'edit')->name('edit');
    //     Route::post('/{deanGreeting}', 'update')->name('update'); // atau bisa pakai PUT/PATCH
    //     Route::delete('/{deanGreeting}', 'destroy')->name('destroy');
    //     Route::post('/{deanGreeting}/toggle-status', 'toggleStatus')->name('toggle-status');
    // Route::post('dean-greeting/{dean_greeting}/toggle-status', [DeanGreetingController::class, 'toggleStatus'])
    //     ->name('dean-greeting.toggle-status');
// Dean Greeting Routes
    Route::controller(DeanGreetingController::class)->prefix('dean-greeting')->name('dean-greeting.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{deanGreeting}/edit', 'edit')->name('edit');
        Route::post('/{deanGreeting}', 'update')->name('update'); // atau bisa pakai PUT/PATCH
        Route::delete('/{deanGreeting}', 'destroy')->name('destroy');
        Route::post('/{deanGreeting}/toggle-status', 'toggleStatus')->name('toggle-status');
    });

    // Contact Messages

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

    // Facility Routes
    Route::controller(FacilityController::class)->prefix('facilities')->name('facilities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{facility}', 'show')->name('show');
        Route::get('/{facility}/edit', 'edit')->name('edit');
        Route::post('/{facility}', 'update')->name('update');
        Route::delete('/{facility}', 'destroy')->name('destroy');
        Route::post('/{facility}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::post('/{facility}/toggle-availability', 'toggleAvailability')->name('toggle-availability');
    });


    // EDOM Questionnaire Management
    Route::prefix('edom')->name('edom.')->group(function () {

        // Questionnaires
        Route::prefix('questionnaire')->name('questionnaire.')->group(function () {
            Route::get('/', [QuestionnaireController::class, 'index'])->name('index');
            Route::get('/create', [QuestionnaireController::class, 'create'])->name('create');
            Route::post('/', [QuestionnaireController::class, 'store'])->name('store');
            Route::get('/{questionnaire}', [QuestionnaireController::class, 'show'])->name('show');
            Route::get('/{questionnaire}/edit', [QuestionnaireController::class, 'edit'])->name('edit');
            Route::put('/{questionnaire}', [QuestionnaireController::class, 'update'])->name('update');
            Route::delete('/{questionnaire}', [QuestionnaireController::class, 'destroy'])->name('destroy');
            Route::patch('/{questionnaire}/toggle-active', [QuestionnaireController::class, 'toggleActive'])->name('toggle-active');
            Route::post('/{questionnaire}/duplicate', [QuestionnaireController::class, 'duplicate'])->name('duplicate');
        });

        // Evaluations
        Route::prefix('evaluation')->name('evaluation.')->group(function () {
            Route::get('/', [EvaluationController::class, 'index'])->name('index');
            Route::get('/export', [EvaluationController::class, 'export'])->name('export'); // Harus di atas {evaluation}
            Route::get('/{evaluation}', [EvaluationController::class, 'show'])->name('show');
            Route::delete('/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy');
        });

        // Reports - gunakan prefix berbeda
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [EvaluationReportController::class, 'index'])->name('index');
            Route::get('/lecturer', [EvaluationReportController::class, 'lecturerReport'])->name('lecturer');
            Route::get('/category', [EvaluationReportController::class, 'categoryReport'])->name('category');
        });
    });

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

    /**
     * ==============================================
     * PASTE THIS INSIDE ADMIN MIDDLEWARE GROUP
     * ==============================================
     */

    // GPM (Gugus Penjaminan Mutu) Management
    Route::prefix('gpm')->name('gpm.')->group(function () {

        // 1. STRUKTUR ORGANISASI GPM
        Route::prefix('struktur-organisasi')->name('struktur-organisasi.')->group(function () {
            Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('index');
            Route::get('/create', [StrukturOrganisasiController::class, 'create'])->name('create');
            Route::post('/', [StrukturOrganisasiController::class, 'store'])->name('store');
            Route::get('/{strukturOrganisasi}/edit', [StrukturOrganisasiController::class, 'edit'])->name('edit');
            Route::put('/{strukturOrganisasi}', [StrukturOrganisasiController::class, 'update'])->name('update');
            Route::delete('/{strukturOrganisasi}', [StrukturOrganisasiController::class, 'destroy'])->name('destroy');

            // Additional actions
            Route::post('/reorder', [StrukturOrganisasiController::class, 'reorder'])->name('reorder');
            Route::post('/{strukturOrganisasi}/toggle-active', [StrukturOrganisasiController::class, 'toggleActive'])->name('toggle-active');
        });

        // 2. DOKUMEN SPMI
        Route::prefix('dokumen-spmi')->name('dokumen-spmi.')->group(function () {
            Route::get('/', [DokumenSPMIController::class, 'index'])->name('index');
            Route::get('/create', [DokumenSPMIController::class, 'create'])->name('create');
            Route::post('/', [DokumenSPMIController::class, 'store'])->name('store');
            Route::get('/{dokumenSpmi}', [DokumenSPMIController::class, 'show'])->name('show');
            Route::get('/{dokumenSpmi}/edit', [DokumenSPMIController::class, 'edit'])->name('edit');
            Route::put('/{dokumenSpmi}', [DokumenSPMIController::class, 'update'])->name('update');
            Route::delete('/{dokumenSpmi}', [DokumenSPMIController::class, 'destroy'])->name('destroy');

            // Additional actions
            Route::get('/{dokumenSpmi}/download', [DokumenSPMIController::class, 'download'])->name('download');
            Route::post('/{dokumenSpmi}/toggle-publish', [DokumenSPMIController::class, 'togglePublish'])->name('toggle-publish');
        });

        // 3. SURVEY KEPUASAN
        Route::prefix('survey')->name('survey.')->group(function () {
            Route::get('/', [SurveyController::class, 'index'])->name('index');
            Route::get('/create', [SurveyController::class, 'create'])->name('create');
            Route::post('/', [SurveyController::class, 'store'])->name('store');
            Route::get('/{survey}', [SurveyController::class, 'show'])->name('show');
            Route::get('/{survey}/edit', [SurveyController::class, 'edit'])->name('edit');
            Route::put('/{survey}', [SurveyController::class, 'update'])->name('update');
            Route::delete('/{survey}', [SurveyController::class, 'destroy'])->name('destroy');

            // Additional actions
            Route::post('/{survey}/toggle-active', [SurveyController::class, 'toggleActive'])->name('toggle-active');
            Route::get('/{survey}/results', [SurveyController::class, 'results'])->name('results');
            Route::get('/{survey}/export', [SurveyController::class, 'export'])->name('export');
        });

        // 4. EDOM PERIOD
        Route::prefix('edom-period')->name('edom-period.')->group(function () {
            Route::get('/', [EDOMPeriodController::class, 'index'])->name('index');
            Route::get('/create', [EDOMPeriodController::class, 'create'])->name('create');
            Route::post('/', [EDOMPeriodController::class, 'store'])->name('store');
            Route::get('/{edomPeriod}', [EDOMPeriodController::class, 'show'])->name('show');
            Route::get('/{edomPeriod}/edit', [EDOMPeriodController::class, 'edit'])->name('edit');
            Route::put('/{edomPeriod}', [EDOMPeriodController::class, 'update'])->name('update');
            Route::delete('/{edomPeriod}', [EDOMPeriodController::class, 'destroy'])->name('destroy');

            // Additional actions
            Route::post('/{edomPeriod}/toggle-active', [EDOMPeriodController::class, 'toggleActive'])->name('toggle-active');
            Route::post('/{edomPeriod}/toggle-publish', [EDOMPeriodController::class, 'togglePublish'])->name('toggle-publish');
            Route::post('/{edomPeriod}/update-statistics', [EDOMPeriodController::class, 'updateStatistics'])->name('update-statistics');

            // Reports & Analytics
            Route::get('/{edomPeriod}/lecturer-statistics', [EDOMPeriodController::class, 'lecturerStatistics'])->name('lecturer-statistics');
            Route::get('/{edomPeriod}/lecturer-submissions', [EDOMPeriodController::class, 'lecturerSubmissions'])->name('lecturer-submissions');
            Route::get('/{edomPeriod}/export', [EDOMPeriodController::class, 'export'])->name('export');
        });
    });
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
