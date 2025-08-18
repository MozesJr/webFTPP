<?php
// app/Http/Controllers/Parent/DashboardController.php (Updated untuk Breeze)

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use App\Models\KhsFile;
use App\Services\KhsManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private $khsService;

    public function __construct(KhsManagementService $khsService)
    {
        $this->khsService = $khsService;
    }

    // ========================================
    // DASHBOARD HOME
    // ========================================

    public function index()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        // Get available KHS files
        $khsFiles = $this->khsService->getParentAccessibleKhs($parent->id);

        // Get academic periods with KHS
        $periodsWithKhs = AcademicPeriod::whereHas('khsFiles', function ($query) use ($student) {
            $query->where('student_id', $student->id)
                ->where('upload_status', 'ready');
        })
            ->orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Get recent access statistics
        $accessStats = $parent->getKhsAccessStatistics(30);

        // Latest KHS
        $latestKhs = $student->getLatestKhsFile();

        return Inertia::render('Parent/Dashboard', [
            'khsFiles' => $khsFiles->take(5), // Latest 5 for dashboard
            'periodsWithKhs' => $periodsWithKhs,
            'accessStats' => $accessStats,
            'latestKhs' => $latestKhs,
            'totalKhsFiles' => $khsFiles->count()
        ]);
    }

    // ========================================
    // KHS LIST VIEW
    // ========================================

    public function khsList(Request $request)
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        // Get all accessible KHS files
        $query = $parent->getStudentKhsFiles();

        // Filter by period if requested
        if ($request->period_id) {
            $query->where('academic_period_id', $request->period_id);
        }

        // Filter by year if requested
        if ($request->year) {
            $query->whereHas('academicPeriod', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }

        $khsFiles = $query->paginate(10);

        // Get available periods for filter
        $availablePeriods = AcademicPeriod::whereHas('khsFiles', function ($query) use ($student) {
            $query->where('student_id', $student->id)
                ->where('upload_status', 'ready');
        })
            ->orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Get available years
        $availableYears = $availablePeriods->pluck('year')->unique()->sort()->reverse();

        return Inertia::render('Parent/Khs/Index', [
            'khsFiles' => $khsFiles,
            'availablePeriods' => $availablePeriods,
            'availableYears' => $availableYears->values(),
            'filters' => $request->only(['period_id', 'year'])
        ]);
    }

    // ========================================
    // KHS DETAIL VIEW
    // ========================================

    public function khsDetail(KhsFile $khsFile)
    {
        $parent = Auth::guard('parent')->user();

        // Check if parent can access this KHS
        if (!$this->khsService->canParentAccessKhs($parent, $khsFile)) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Load relationships
        $khsFile->load(['academicPeriod', 'student']);

        // Log access
        $this->khsService->logParentAccess($parent, $khsFile, 'view');

        return Inertia::render('Parent/Khs/Detail', [
            'khsFile' => $khsFile
        ]);
    }

    // ========================================
    // KHS DOWNLOAD
    // ========================================

    public function downloadKhs(KhsFile $khsFile)
    {
        $parent = Auth::guard('parent')->user();

        // Check if parent can access this KHS
        if (!$this->khsService->canParentAccessKhs($parent, $khsFile)) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Log download access
        $this->khsService->logParentAccess($parent, $khsFile, 'download');

        // Redirect to Google Drive download URL
        return redirect($khsFile->gdrive_download_url);
    }

    // ========================================
    // KHS PREVIEW/VIEW
    // ========================================

    public function previewKhs(KhsFile $khsFile)
    {
        $parent = Auth::guard('parent')->user();

        // Check if parent can access this KHS
        if (!$this->khsService->canParentAccessKhs($parent, $khsFile)) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Log view access
        $this->khsService->logParentAccess($parent, $khsFile, 'view');

        // Redirect to Google Drive view URL
        return redirect($khsFile->gdrive_url);
    }

    // ========================================
    // STUDENT PROFILE
    // ========================================

    public function profile()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        // Get KHS summary
        $khsSummary = [
            'total_files' => $student->khsFiles()->ready()->count(),
            'latest_period' => $student->khsFiles()->ready()
                ->with('academicPeriod')
                ->latest('upload_date')
                ->first()?->academicPeriod,
            'first_period' => $student->khsFiles()->ready()
                ->with('academicPeriod')
                ->oldest('upload_date')
                ->first()?->academicPeriod,
        ];

        // Get access history
        $recentAccess = $parent->getAccessLogs(10);

        return Inertia::render('Parent/Profile', [
            'khsSummary' => $khsSummary,
            'recentAccess' => $recentAccess
        ]);
    }

    // ========================================
    // ACCESS HISTORY
    // ========================================

    public function accessHistory(Request $request)
    {
        $parent = Auth::guard('parent')->user();

        // Get access logs with pagination
        $accessLogs = $parent->getAccessLogs(50);

        // Group by date for better display
        $groupedLogs = $accessLogs->groupBy(function ($log) {
            return $log->accessed_at->format('Y-m-d');
        });

        return Inertia::render('Parent/AccessHistory', [
            'accessLogs' => $accessLogs,
            'groupedLogs' => $groupedLogs
        ]);
    }

    // ========================================
    // QUICK ACTIONS
    // ========================================

    public function quickDownloadLatest()
    {
        $parent = Auth::guard('parent')->user();
        $latestKhs = $parent->student->getLatestKhsFile();

        if (!$latestKhs) {
            return redirect()->route('parent.khs.index')
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Tidak ada file KHS yang tersedia.'
                ]);
        }

        return $this->downloadKhs($latestKhs);
    }

    // ========================================
    // API ENDPOINTS
    // ========================================

    public function getKhsByYear($year)
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        $khsFiles = $student->khsFiles()
            ->ready()
            ->whereHas('academicPeriod', function ($query) use ($year) {
                $query->where('year', $year);
            })
            ->with('academicPeriod')
            ->orderBy('academic_period_id', 'desc')
            ->get();

        return response()->json($khsFiles);
    }

    public function getAccessStats()
    {
        $parent = Auth::guard('parent')->user();
        $stats = $parent->getKhsAccessStatistics(30);

        return response()->json($stats);
    }

    public function searchKhs(Request $request)
    {
        $parent = Auth::guard('parent')->user();
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        $khsFiles = $parent->getStudentKhsFiles()
            ->where(function ($query) use ($search) {
                $query->where('semester_name', 'like', "%{$search}%")
                    ->orWhereHas('academicPeriod', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('academic_year', 'like', "%{$search}%");
                    });
            })
            ->limit(10)
            ->get();

        return response()->json($khsFiles);
    }
}
