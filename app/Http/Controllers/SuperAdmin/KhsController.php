<?php
// app/Http/Controllers/SuperAdmin/KhsController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use App\Models\KhsFile;
use App\Models\Student;
use App\Services\KhsManagementService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KhsController extends Controller
{
    private $khsService;

    public function __construct(KhsManagementService $khsService)
    {
        $this->khsService = $khsService;
    }

    public function index(Request $request)
    {
        $query = KhsFile::with(['student', 'academicPeriod', 'uploader']);

        // Filters
        if ($request->period_id) {
            $query->byPeriod($request->period_id);
        }

        if ($request->status) {
            $query->where('upload_status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->search . '%')
                    ->orWhere('student_nim', 'like', '%' . $request->search . '%')
                    ->orWhere('original_filename', 'like', '%' . $request->search . '%');
            });
        }

        $khsFiles = $query->orderBy('upload_date', 'desc')->paginate(20);

        // Get periods for filter
        $periods = AcademicPeriod::orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Get current period statistics
        $currentPeriod = AcademicPeriod::active()->first();
        $stats = $currentPeriod ? $this->khsService->getPeriodStatistics($currentPeriod) : null;

        return Inertia::render('SuperAdmin/Khs/Index', [
            'khsFiles' => $khsFiles,
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'statistics' => $stats,
            'filters' => $request->only(['period_id', 'status', 'search']),
        ]);
    }

    // ========================================
    // ACADEMIC PERIOD MANAGEMENT
    // ========================================

    public function periods()
    {
        $periods = AcademicPeriod::withCount('khsFiles')
            ->orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return Inertia::render('SuperAdmin/Khs/Periods', [
            'periods' => $periods
        ]);
    }

    public function createPeriod()
    {
        return Inertia::render('SuperAdmin/Khs/CreatePeriod');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'semester' => 'required|in:ganjil,genap',
            'name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        // Check if period already exists
        $exists = AcademicPeriod::where('year', $request->year)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['year' => 'Period untuk tahun dan semester ini sudah ada.']);
        }

        $academicYear = $request->semester === 'ganjil'
            ? $request->year . '/' . ($request->year + 1)
            : ($request->year - 1) . '/' . $request->year;

        $name = $request->name ?: "Semester " . ucfirst($request->semester) . " {$academicYear}";

        $period = AcademicPeriod::create([
            'name' => $name,
            'year' => $request->year,
            'semester' => $request->semester,
            'academic_year' => $academicYear,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? false
        ]);

        if ($request->is_active) {
            $period->activate();
        }

        return redirect()->route('super-admin.khs.periods')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Period akademik berhasil dibuat!'
            ]);
    }

    public function activatePeriod(AcademicPeriod $period)
    {
        $period->activate();

        return redirect()->back()
            ->with('flash', [
                'type' => 'success',
                'message' => "Period {$period->name} berhasil diaktifkan!"
            ]);
    }

    // ========================================
    // SINGLE FILE UPLOAD
    // ========================================

    public function upload()
    {
        $periods = AcademicPeriod::orderBy('year', 'desc')->get();
        $students = Student::where('is_active', true)
            ->orderBy('nim')
            ->get(['id', 'nim', 'name', 'program_studi']);

        $data = [
            'periods' => $periods,
            'students' => $students
        ];

        // dd($data);

        return Inertia::render('SuperAdmin/Khs/Upload', $data);
    }

    public function storeUpload(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB
        ]);

        try {
            $student = Student::findOrFail($request->student_id);
            $period = AcademicPeriod::findOrFail($request->academic_period_id);

            // Validate file
            $this->khsService->validateUploadFile($request->file('file'));

            // Upload KHS
            $khsFile = $this->khsService->uploadKhsForStudent(
                $request->file('file'),
                $student,
                $period,
                auth()->id()
            );

            return redirect()->route('super-admin.khs.index')
                ->with('flash', [
                    'type' => 'success',
                    'message' => "KHS untuk {$student->name} ({$student->nim}) berhasil diupload!"
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['file' => $e->getMessage()])
                ->withInput();
        }
    }



    // ========================================
    // BULK UPLOAD
    // ========================================

    public function bulkUpload()
    {
        $periods = AcademicPeriod::orderBy('year', 'desc')->get();

        return Inertia::render('SuperAdmin/Khs/BulkUpload', [
            'periods' => $periods
        ]);
    }

    public function storeBulkUpload(Request $request)
    {
        $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:pdf|max:10240',
        ]);

        try {
            $period = AcademicPeriod::findOrFail($request->academic_period_id);
            $files = $request->file('files');

            // Extract NIM from filenames
            $processedFiles = [];
            $errors = [];

            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();

                // Extract NIM from filename (assumes format: NIM_*.pdf or NIM.pdf)
                if (preg_match('/^(\d+)/', $filename, $matches)) {
                    $nim = $matches[1];
                    $processedFiles[$nim] = $file;
                } else {
                    $errors[] = "Cannot extract NIM from filename: {$filename}";
                }
            }

            if (empty($processedFiles)) {
                return redirect()->back()
                    ->withErrors(['files' => 'No valid files found. Filename should start with NIM.']);
            }

            // Bulk upload
            $results = $this->khsService->bulkUploadKhs(
                $processedFiles,
                $period,
                auth()->id()
            );

            $message = "Upload selesai! Berhasil: {$results['success']}, Gagal: {$results['failed']}";

            if (!empty($errors)) {
                $message .= " | Errors: " . implode(', ', array_slice($errors, 0, 3));
            }

            return redirect()->route('super-admin.khs.index')
                ->with('flash', [
                    'type' => $results['failed'] > 0 ? 'warning' : 'success',
                    'message' => $message
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['files' => 'Bulk upload failed: ' . $e->getMessage()]);
        }
    }

    // ========================================
    // FILE MANAGEMENT
    // ========================================

    public function show(KhsFile $khsFile)
    {
        $khsFile->load(['student', 'academicPeriod', 'uploader', 'accessLogs.parent']);

        $accessStats = $khsFile->getAccessStatistics();

        return Inertia::render('SuperAdmin/Khs/Show', [
            'khsFile' => $khsFile,
            'accessStats' => $accessStats
        ]);
    }

    public function destroy(KhsFile $khsFile)
    {
        try {
            // Delete from Google Drive
            if ($khsFile->gdrive_file_id) {
                app(\App\Services\GoogleDriveService::class)->deleteFile($khsFile->gdrive_file_id);
            }

            $studentName = $khsFile->student_name;
            $khsFile->delete();

            return redirect()->route('super-admin.khs.index')
                ->with('flash', [
                    'type' => 'success',
                    'message' => "KHS untuk {$studentName} berhasil dihapus!"
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Gagal menghapus file: ' . $e->getMessage()
                ]);
        }
    }

    public function retry(KhsFile $khsFile)
    {
        try {
            $khsFile->retry();

            return redirect()->back()
                ->with('flash', [
                    'type' => 'success',
                    'message' => 'File ditandai untuk retry upload.'
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Gagal retry: ' . $e->getMessage()
                ]);
        }
    }

    // ========================================
    // UTILITIES & REPORTS
    // ========================================

    public function downloadTemplate()
    {
        $templatePath = resource_path('templates/khs_upload_template.txt');

        $template = "Template Naming Convention untuk Upload KHS:\n\n";
        $template .= "Format filename: [NIM]_KHS_[Semester]_[TahunAkademik].pdf\n";
        $template .= "Contoh:\n";
        $template .= "- 2025001_KHS_Ganjil_2025-2026.pdf\n";
        $template .= "- 2025002_KHS_Genap_2024-2025.pdf\n\n";
        $template .= "Untuk bulk upload, pastikan:\n";
        $template .= "1. Semua file dalam format PDF\n";
        $template .= "2. Filename dimulai dengan NIM yang valid\n";
        $template .= "3. Ukuran file maksimal 10MB\n";
        $template .= "4. NIM mahasiswa sudah terdaftar di sistem\n\n";
        $template .= "Generated at: " . now()->format('Y-m-d H:i:s');

        return response($template)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="khs_upload_template.txt"');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id'
        ]);

        $period = AcademicPeriod::findOrFail($request->period_id);
        $report = $this->khsService->generateKhsReport($period);

        return Inertia::render('SuperAdmin/Khs/Report', [
            'report' => $report
        ]);
    }

    // ========================================
    // API ENDPOINTS FOR FRONTEND
    // ========================================

    public function getStudentsByPeriod(Request $request)
    {
        $periodId = $request->period_id;

        if (!$periodId) {
            return response()->json([]);
        }

        // Get students who don't have KHS for this period
        $studentsWithoutKhs = Student::where('is_active', true)
            ->whereDoesntHave('khsFiles', function ($query) use ($periodId) {
                $query->where('academic_period_id', $periodId)
                    ->where('upload_status', 'ready');
            })
            ->orderBy('nim')
            ->get(['id', 'nim', 'name', 'program_studi']);

        return response()->json($studentsWithoutKhs);
    }

    public function getPeriodStats(AcademicPeriod $period)
    {
        $stats = $this->khsService->getPeriodStatistics($period);

        return response()->json($stats);
    }

    public function searchStudents(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        $students = Student::where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('nim', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'nim', 'name', 'program_studi']);

        return response()->json($students);
    }

    /**
     * Update academic period
     */
    public function updatePeriod(Request $request, AcademicPeriod $period)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        $period->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? false
        ]);

        if ($request->is_active) {
            $period->activate();
        }

        return redirect()->back()
            ->with('flash', [
                'type' => 'success',
                'message' => "Period {$period->name} berhasil diupdate!"
            ]);
    }

    /**
     * Delete academic period
     */
    public function destroyPeriod(AcademicPeriod $period)
    {
        // Check if period has KHS files
        if ($period->khsFiles()->count() > 0) {
            return redirect()->back()
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Tidak dapat menghapus period yang memiliki file KHS!'
                ]);
        }

        $periodName = $period->name;
        $period->delete();

        return redirect()->back()
            ->with('flash', [
                'type' => 'success',
                'message' => "Period {$periodName} berhasil dihapus!"
            ]);
    }

    /**
     * Get period statistics for API
     */
    public function getPeriodStatisticsApi(AcademicPeriod $period)
    {
        $stats = $this->khsService->getPeriodStatistics($period);
        return response()->json($stats);
    }

    /**
     * Get students who don't have KHS for specific period
     */
    public function getStudentsWithoutKhs(Request $request)
    {
        $periodId = $request->period_id;

        if (!$periodId) {
            return response()->json([]);
        }

        $students = Student::where('is_active', true)
            ->whereDoesntHave('khsFiles', function ($query) use ($periodId) {
                $query->where('academic_period_id', $periodId)
                    ->where('upload_status', 'ready');
            })
            ->orderBy('nim')
            ->get(['id', 'nim', 'name', 'program_studi']);

        return response()->json($students);
    }

    /**
     * Bulk delete KHS files for a period
     */
    public function bulkDeleteByPeriod(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id',
            'confirm' => 'required|boolean|accepted'
        ]);

        $period = AcademicPeriod::findOrFail($request->period_id);
        $khsFiles = $period->khsFiles();
        $count = $khsFiles->count();

        // Delete files from Google Drive
        foreach ($khsFiles->get() as $khsFile) {
            if ($khsFile->gdrive_file_id) {
                try {
                    app(\App\Services\GoogleDriveService::class)->deleteFile($khsFile->gdrive_file_id);
                } catch (\Exception $e) {
                    \Log::warning("Failed to delete Google Drive file: " . $e->getMessage());
                }
            }
        }

        // Delete from database
        $khsFiles->delete();

        return redirect()->back()
            ->with('flash', [
                'type' => 'success',
                'message' => "Berhasil menghapus {$count} file KHS untuk period {$period->name}!"
            ]);
    }

    /**
     * Export KHS data for a period
     */
    public function exportPeriodData(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id',
            'format' => 'required|in:csv,excel'
        ]);

        $period = AcademicPeriod::with(['khsFiles.student'])->findOrFail($request->period_id);

        $data = $period->khsFiles->map(function ($khsFile) {
            return [
                'NIM' => $khsFile->student_nim,
                'Nama Mahasiswa' => $khsFile->student_name,
                'Program Studi' => $khsFile->student->program_studi ?? '',
                'Filename' => $khsFile->original_filename,
                'Status Upload' => $khsFile->status_label,
                'Ukuran File' => $khsFile->file_size_human,
                'Tanggal Upload' => $khsFile->upload_date?->format('Y-m-d H:i:s'),
                'Diupload Oleh' => $khsFile->uploader?->name ?? '',
                'Total Akses' => $khsFile->access_count,
                'Terakhir Diakses' => $khsFile->last_accessed_at?->format('Y-m-d H:i:s'),
            ];
        });

        $filename = "khs_data_{$period->academic_year}_{$period->semester}.csv";

        if ($request->format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function () use ($data) {
                $file = fopen('php://output', 'w');

                // Add headers
                if ($data->isNotEmpty()) {
                    fputcsv($file, array_keys($data->first()));
                }

                // Add data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // For Excel format, you might want to use Laravel Excel package
        // This is a simplified version
        return response()->json([
            'message' => 'Excel export will be available soon',
            'data' => $data
        ]);
    }

    /**
     * Get KHS access analytics
     */
    public function getAccessAnalytics(Request $request)
    {
        $request->validate([
            'period_id' => 'nullable|exists:academic_periods,id',
            'days' => 'nullable|integer|min:1|max:365'
        ]);

        $query = \App\Models\KhsAccessLog::with(['khsFile.academicPeriod']);

        if ($request->period_id) {
            $query->whereHas('khsFile', function ($q) use ($request) {
                $q->where('academic_period_id', $request->period_id);
            });
        }

        if ($request->days) {
            $query->where('accessed_at', '>=', now()->subDays($request->days));
        }

        $accessLogs = $query->orderBy('accessed_at', 'desc')->get();

        $analytics = [
            'total_access' => $accessLogs->count(),
            'unique_users' => $accessLogs->unique('parent_id')->count(),
            'unique_files' => $accessLogs->unique('khs_file_id')->count(),
            'daily_access' => $accessLogs->groupBy(function ($log) {
                return $log->accessed_at->format('Y-m-d');
            })->map->count(),
            'hourly_pattern' => $accessLogs->groupBy(function ($log) {
                return $log->accessed_at->format('H');
            })->map->count(),
            'most_accessed_files' => $accessLogs->groupBy('khs_file_id')
                ->map(function ($group) {
                    $first = $group->first();
                    return [
                        'file_id' => $first->khs_file_id,
                        'student_name' => $first->khsFile->student_name,
                        'student_nim' => $first->khsFile->student_nim,
                        'access_count' => $group->count()
                    ];
                })
                ->sortByDesc('access_count')
                ->take(10)
                ->values()
        ];

        return response()->json($analytics);
    }

    /**
     * Sync KHS files with Google Drive
     */
    public function syncWithGoogleDrive(Request $request)
    {
        try {
            $driveService = app(\App\Services\GoogleDriveService::class);
            $syncedCount = 0;
            $errorCount = 0;

            $khsFiles = KhsFile::where('upload_status', 'ready')
                ->whereNotNull('gdrive_file_id')
                ->get();

            foreach ($khsFiles as $khsFile) {
                try {
                    // Check if file still exists in Google Drive
                    $exists = $driveService->fileExists($khsFile->gdrive_file_id);

                    if (!$exists) {
                        $khsFile->update([
                            'upload_status' => 'failed',
                            'error_message' => 'File not found in Google Drive'
                        ]);
                        $errorCount++;
                    } else {
                        $syncedCount++;
                    }
                } catch (\Exception $e) {
                    $khsFile->update([
                        'upload_status' => 'failed',
                        'error_message' => 'Sync error: ' . $e->getMessage()
                    ]);
                    $errorCount++;
                }
            }

            return redirect()->back()
                ->with('flash', [
                    'type' => $errorCount > 0 ? 'warning' : 'success',
                    'message' => "Sync selesai! Berhasil: {$syncedCount}, Error: {$errorCount}"
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Gagal melakukan sync: ' . $e->getMessage()
                ]);
        }
    }

    public function editPeriod(AcademicPeriod $period)
    {
        return Inertia::render('SuperAdmin/Khs/EditPeriod', [
            'period' => $period
        ]);
    }
}
