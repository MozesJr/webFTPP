<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\GPM\StrukturOrganisasi;
use App\Models\GPM\DokumenSPMI;
use App\Models\GPM\Survey;
use App\Models\GPM\EDOMPeriod;
use Illuminate\Http\Request;

/**
 * GPM Controller
 * ==============
 * Handles all GPM (Gugus Penjaminan Mutu) related pages
 *
 * Path: app/Http/Controllers/GPMController.php
 *
 * ARCHITECTURE NOTES:
 * - Thin controller: hanya routing dan passing data minimal
 * - Query optimization dengan eager loading
 * - Hanya data published/active yang di-expose ke public
 * - Menggunakan Resource classes untuk data formatting
 */
class GPMController extends Controller
{
    /**
     * Display GPM main/index page
     * Route: /evaluation
     */
    public function index(): Response
    {
        // Get quick stats untuk dashboard
        $stats = [
            'total_dokumen' => DokumenSPMI::published()->count(),
            'total_struktur' => StrukturOrganisasi::active()->count(),
            'active_surveys' => Survey::currentlyRunning()->count(),
            'active_edom' => EDOMPeriod::currentlyRunning()->exists(),
        ];

        return Inertia::render('GPM/Index', [
            'pageTitle' => 'Gugus Penjaminan Mutu',
            'pageDescription' => 'Sistem Penjaminan Mutu Internal Fakultas Teknologi Pertambangan dan Perminyakan',
            'stats' => $stats,
        ]);
    }

    /**
     * Display Struktur Organisasi GPM
     * Route: /gpm/struktur-organisasi
     *
     * QUERY OPTIMIZATION:
     * - No N+1 query problem
     * - Only fetch active members
     * - Ordered by display order
     */

    public function strukturOrganisasi(): Response
    {
        // Fetch struktur organisasi yang aktif, ordered by position
        $strukturs = StrukturOrganisasi::active()
            ->ordered()
            ->get()
            ->map(function ($struktur) {
                return [
                    'id' => $struktur->id,
                    'nama' => $struktur->nama,
                    'nip' => $struktur->nip ?? '-',
                    'jabatan' => $struktur->jabatan,
                    'email' => $struktur->email ?? '-',
                    'phone' => $struktur->phone ?? '-',
                    'photo_url' => $struktur->photo_url ?? asset('images/default-avatar.png'),
                    'tugas_fungsi' => $struktur->tugas_fungsi,
                    'bio' => $struktur->bio,
                    'is_featured' => $struktur->is_featured,
                    'order' => $struktur->order,
                ];
            });

        // Group by featured status
        $featured = $strukturs->where('is_featured', true)->values()->all();
        $regular = $strukturs->where('is_featured', false)->values()->all();

        // Check if there's data
        $hasData = $strukturs->isNotEmpty();

        return Inertia::render('GPM/StrukturOrganisasi', [
            'pageTitle' => 'Struktur Organisasi GPM',
            'pageDescription' => 'Struktur Organisasi Gugus Penjaminan Mutu FTPP',
            'strukturs' => $strukturs->all(),
            'featured' => $featured,
            'regular' => $regular,
            'hasData' => $hasData,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Struktur Organisasi', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Dokumen SPMI
     * Route: /gpm/dokumen-spmi
     *
     * SPMI: Sistem Penjaminan Mutu Internal
     *
     * FEATURES:
     * - Search & filter support
     * - Category grouping
     * - Pagination
     * - Download tracking
     */
    public function dokumenSPMI(Request $request): Response
    {
        // Build query dengan filters
        $query = DokumenSPMI::published()
            ->with('uploader:id,name') // Eager load uploader
            ->latest('published_date');

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Paginate results
        $dokumens = $query->paginate(12)->withQueryString();

        // Get document count by category
        $categoryCounts = DokumenSPMI::published()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Categories definition
        $categories = [
            'standar' => [
                'label' => 'Standar SPMI',
                'count' => $categoryCounts['standar'] ?? 0,
                'color' => 'blue',
            ],
            'manual' => [
                'label' => 'Manual SPMI',
                'count' => $categoryCounts['manual'] ?? 0,
                'color' => 'green',
            ],
            'formulir' => [
                'label' => 'Formulir',
                'count' => $categoryCounts['formulir'] ?? 0,
                'color' => 'purple',
            ],
            'sop' => [
                'label' => 'SOP',
                'count' => $categoryCounts['sop'] ?? 0,
                'color' => 'yellow',
            ],
        ];

        return Inertia::render('GPM/DokumenSPMI', [
            'pageTitle' => 'Dokumen SPMI',
            'pageDescription' => 'Dokumen Sistem Penjaminan Mutu Internal FTPP',
            'dokumens' => $dokumens,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Dokumen SPMI', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Survey Kepuasan
     * Route: /gpm/survey-kepuasan
     *
     * FEATURES:
     * - Only show active/running surveys
     * - Filter by target respondent
     * - Show completion stats
     */

    public function surveyKepuasan(Request $request): Response
    {
        // Get currently running surveys
        $query = Survey::currentlyRunning()
            ->with('creator:id,name')
            ->latest('start_date');

        // Filter by target if provided
        if ($request->filled('target')) {
            $query->forTarget($request->target);
        }

        $surveys = $query->get()->map(function ($survey) {
            return [
                'id' => $survey->id,
                'title' => $survey->title,
                'slug' => $survey->slug,
                'description' => $survey->description,
                'introduction' => $survey->introduction,
                'target_respondent' => $survey->target_respondent,
                'target_respondent_label' => $survey->target_respondent_label,
                'start_date' => $survey->start_date->format('d M Y'),
                'end_date' => $survey->end_date->format('d M Y'),
                'days_remaining' => now()->diffInDays($survey->end_date, false),
                'total_questions' => $survey->total_questions,
                'total_responses' => $survey->total_responses,
                'target_responses' => $survey->target_responses,
                'completion_percentage' => round($survey->completion_percentage, 1),
                'is_anonymous' => $survey->is_anonymous,
                'require_login' => $survey->require_login,
                'status' => $survey->status,
                'status_label' => $survey->status_label,
                'can_be_filled' => $survey->canBeFilled(),
                'survey_url' => route('gpm.survey.fill', $survey->slug),
            ];
        });

        // Get target respondent options with counts
        $targetCounts = Survey::currentlyRunning()
            ->selectRaw('target_respondent, COUNT(*) as count')
            ->groupBy('target_respondent')
            ->pluck('count', 'target_respondent')
            ->toArray();

        $targets = [
            'mahasiswa' => [
                'label' => 'Mahasiswa',
                'count' => $targetCounts['mahasiswa'] ?? 0,
                'icon' => 'academic-cap',
                'color' => 'blue',
            ],
            'dosen' => [
                'label' => 'Dosen',
                'count' => $targetCounts['dosen'] ?? 0,
                'icon' => 'users',
                'color' => 'green',
            ],
            'alumni' => [
                'label' => 'Alumni',
                'count' => $targetCounts['alumni'] ?? 0,
                'icon' => 'user-group',
                'color' => 'purple',
            ],
            'stakeholder' => [
                'label' => 'Stakeholder',
                'count' => $targetCounts['stakeholder'] ?? 0,
                'icon' => 'briefcase',
                'color' => 'orange',
            ],
        ];

        $hasActiveSurveys = $surveys->isNotEmpty();

        return Inertia::render('GPM/SurveyKepuasan', [
            'pageTitle' => 'Survey Kepuasan',
            'pageDescription' => 'Survey Kepuasan Mahasiswa, Dosen, dan Stakeholder',
            'surveys' => $surveys->all(),
            'targets' => $targets,
            'hasActiveSurveys' => $hasActiveSurveys,
            'filters' => $request->only(['target']),
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Survey Kepuasan', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Survey EDOM
     * Route: /gpm/survey-edom
     *
     * EDOM: Evaluasi Dosen Oleh Mahasiswa
     *
     * FEATURES:
     * - Show active EDOM period
     * - Authentication required
     * - Show completion stats
     */
    public function surveyEDOM(): Response
    {
        // Get active EDOM period
        $activePeriod = EDOMPeriod::getActivePeriod();

        $edomData = null;

        if ($activePeriod) {
            $edomData = [
                'id' => $activePeriod->id,
                'name' => $activePeriod->name,
                'semester' => $activePeriod->semester,
                'semester_label' => $activePeriod->semester_label,
                'academic_year' => $activePeriod->academic_year,
                'full_period_name' => $activePeriod->full_period_name,
                'start_date' => $activePeriod->start_date->format('d M Y'),
                'end_date' => $activePeriod->end_date->format('d M Y'),
                'description' => $activePeriod->description,
                'instructions' => $activePeriod->instructions,
                'total_students' => $activePeriod->total_students,
                'total_lecturers' => $activePeriod->total_lecturers,
                'total_courses' => $activePeriod->total_courses,
                'total_submissions' => $activePeriod->total_submissions,
                'completion_percentage' => round($activePeriod->completion_percentage ?? 0, 1),
                'status' => $activePeriod->status,
                'status_label' => $activePeriod->status_label,
                'can_submit' => $activePeriod->canSubmit(),
                'require_all_courses' => $activePeriod->require_all_courses,
                'show_results_to_students' => $activePeriod->show_results_to_students,
            ];
        }

        // Get upcoming periods
        $upcomingPeriods = EDOMPeriod::active()
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get()
            ->map(function ($period) {
                return [
                    'id' => $period->id,
                    'name' => $period->name,
                    'full_period_name' => $period->full_period_name,
                    'start_date' => $period->start_date->format('d M Y'),
                    'end_date' => $period->end_date->format('d M Y'),
                ];
            });

        return Inertia::render('GPM/SurveyEDOM', [
            'pageTitle' => 'Survey EDOM',
            'pageDescription' => 'Evaluasi Dosen Oleh Mahasiswa',
            'activePeriod' => $edomData,
            'upcomingPeriods' => $upcomingPeriods,
            'isAuthenticated' => auth()->check(),
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Survey EDOM', 'url' => null],
            ],
        ]);
    }

    /**
     * Download dokumen SPMI
     * Route: /gpm/dokumen-spmi/{slug}/download
     *
     * SECURITY:
     * - Only published documents can be downloaded
     * - Track download count
     */
    public function downloadDokumen(string $slug)
    {
        $dokumen = DokumenSPMI::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment download count
        $dokumen->incrementDownloads();

        // Get storage path
        $storagePath = str_replace('storage/', '', $dokumen->file_path);

        // Download file
        return \Storage::disk('public')->download($storagePath, $dokumen->file_name);
    }

    /**
     * View dokumen SPMI detail (optional - for preview)
     * Route: /gpm/dokumen-spmi/{slug}
     */
    public function viewDokumen(string $slug): Response
    {
        $dokumen = DokumenSPMI::published()
            ->with('uploader:id,name')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $dokumen->incrementViews();

        return Inertia::render('GPM/DokumenSPMIDetail', [
            'pageTitle' => $dokumen->title,
            'pageDescription' => $dokumen->description,
            'dokumen' => [
                'id' => $dokumen->id,
                'title' => $dokumen->title,
                'slug' => $dokumen->slug,
                'description' => $dokumen->description,
                'category' => $dokumen->category,
                'category_label' => $dokumen->category_label,
                'category_color' => $dokumen->category_color,
                'document_code' => $dokumen->document_code,
                'version' => $dokumen->version,
                'published_date' => $dokumen->published_date?->format('d M Y'),
                'effective_date' => $dokumen->effective_date?->format('d M Y'),
                'review_date' => $dokumen->review_date?->format('d M Y'),
                'file_name' => $dokumen->file_name,
                'file_size_human' => $dokumen->file_size_human,
                'file_type' => $dokumen->file_type,
                'file_url' => $dokumen->file_url,
                'download_count' => $dokumen->download_count,
                'view_count' => $dokumen->view_count,
                'uploader' => $dokumen->uploader ? [
                    'name' => $dokumen->uploader->name,
                ] : null,
            ],
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Dokumen SPMI', 'url' => route('gpm.dokumen-spmi')],
                ['label' => $dokumen->title, 'url' => null],
            ],
        ]);
    }
}
