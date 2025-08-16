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

    // ========================================
    // MAIN DASHBOARD
    // ========================================

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

        return Inertia::render('SuperAdmin/Khs/Upload', [
            'periods' => $periods,
            'students' => $students
        ]);
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
}
