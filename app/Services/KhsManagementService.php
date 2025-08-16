<?php
// app/Services/KhsManagementService.php

namespace App\Services;

use App\Models\KhsFile;
use App\Models\Student;
use App\Models\AcademicPeriod;
use App\Models\ParentModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class KhsManagementService
{
    private $gdriveService;

    public function __construct(GoogleDriveService $gdriveService)
    {
        $this->gdriveService = $gdriveService;
    }

    // ========================================
    // SINGLE FILE OPERATIONS
    // ========================================

    public function uploadKhsForStudent(
        UploadedFile $file,
        Student $student,
        AcademicPeriod $period,
        $uploadedBy
    ) {
        DB::beginTransaction();

        try {
            // Check if KHS already exists
            $existingKhs = KhsFile::where('student_id', $student->id)
                ->where('academic_period_id', $period->id)
                ->first();

            if ($existingKhs) {
                // Delete old file from Google Drive
                if ($existingKhs->gdrive_file_id) {
                    $this->gdriveService->deleteFile($existingKhs->gdrive_file_id);
                }
                $existingKhs->delete();
            }

            // Create initial record with uploading status
            $khsFile = KhsFile::create([
                'student_id' => $student->id,
                'academic_period_id' => $period->id,
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'upload_status' => 'uploading',
                'uploaded_by' => $uploadedBy,
                'upload_date' => now(),
                'semester_name' => $period->name,
                'student_nim' => $student->nim,
                'student_name' => $student->name
            ]);

            // Upload to Google Drive
            $gdriveResult = $this->gdriveService->uploadKhsFile($file, $student, $period);

            // Update with Google Drive information
            $khsFile->update([
                'gdrive_file_id' => $gdriveResult['file_id'],
                'gdrive_folder_id' => $gdriveResult['folder_id'],
                'gdrive_url' => $gdriveResult['view_url'],
                'gdrive_download_url' => $gdriveResult['download_url'],
                'upload_status' => 'ready'
            ]);

            DB::commit();

            Log::info('KHS uploaded successfully', [
                'student_nim' => $student->nim,
                'period' => $period->name,
                'file_id' => $khsFile->id
            ]);

            return $khsFile;
        } catch (\Exception $e) {
            DB::rollback();

            // Mark as failed if record was created
            if (isset($khsFile)) {
                $khsFile->markAsFailed($e->getMessage());
            }

            Log::error("KHS Upload failed: " . $e->getMessage(), [
                'student_nim' => $student->nim ?? null,
                'period' => $period->name ?? null
            ]);

            throw $e;
        }
    }

    // ========================================
    // BULK OPERATIONS
    // ========================================

    public function bulkUploadKhs(array $files, AcademicPeriod $period, $uploadedBy, $callback = null)
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
            'processed' => []
        ];

        $total = count($files);
        $processed = 0;

        foreach ($files as $nim => $file) {
            $processed++;

            try {
                $student = Student::where('nim', $nim)->first();

                if (!$student) {
                    $results['failed']++;
                    $results['errors'][] = "Student with NIM {$nim} not found";
                    $results['processed'][$nim] = [
                        'status' => 'failed',
                        'error' => 'Student not found'
                    ];
                    continue;
                }

                $khsFile = $this->uploadKhsForStudent($file, $student, $period, $uploadedBy);

                $results['success']++;
                $results['processed'][$nim] = [
                    'status' => 'success',
                    'khs_file_id' => $khsFile->id,
                    'student_name' => $student->name
                ];

                // Progress callback
                if ($callback) {
                    $callback($processed, $total, $nim, 'success');
                }
            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = "Failed to upload for NIM {$nim}: " . $e->getMessage();
                $results['processed'][$nim] = [
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];

                // Progress callback
                if ($callback) {
                    $callback($processed, $total, $nim, 'failed', $e->getMessage());
                }
            }
        }

        Log::info('Bulk KHS upload completed', [
            'period' => $period->name,
            'total' => $total,
            'success' => $results['success'],
            'failed' => $results['failed']
        ]);

        return $results;
    }

    // ========================================
    // QUERY & RETRIEVAL METHODS
    // ========================================

    public function getStudentKhsHistory(Student $student)
    {
        return KhsFile::byStudent($student->id)
            ->with(['academicPeriod', 'uploader'])
            ->ready()
            ->orderBy('academic_period_id', 'desc')
            ->get();
    }

    public function getParentAccessibleKhs($parentId)
    {
        $parent = ParentModel::with('student')->find($parentId);

        if (!$parent || !$parent->student) {
            return collect();
        }

        return $this->getStudentKhsHistory($parent->student);
    }

    public function getKhsForStudentPeriod($studentId, $periodId)
    {
        return KhsFile::byStudent($studentId)
            ->byPeriod($periodId)
            ->ready()
            ->first();
    }

    public function searchKhsFiles($search, $periodId = null, $status = null)
    {
        $query = KhsFile::with(['student', 'academicPeriod', 'uploader']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('student_nim', 'like', "%{$search}%")
                    ->orWhere('original_filename', 'like', "%{$search}%");
            });
        }

        if ($periodId) {
            $query->byPeriod($periodId);
        }

        if ($status) {
            $query->where('upload_status', $status);
        }

        return $query->orderBy('upload_date', 'desc')->paginate(20);
    }

    // ========================================
    // ACCESS CONTROL & LOGGING
    // ========================================

    public function canParentAccessKhs(ParentModel $parent, KhsFile $khsFile)
    {
        return $parent->student_id === $khsFile->student_id
            && $khsFile->upload_status === 'ready';
    }

    public function logParentAccess(ParentModel $parent, KhsFile $khsFile, $accessType = 'view')
    {
        if (!$this->canParentAccessKhs($parent, $khsFile)) {
            throw new \Exception('Parent cannot access this KHS file');
        }

        $khsFile->logAccess($parent->id, $accessType);

        Log::info('Parent accessed KHS', [
            'parent_id' => $parent->id,
            'student_nim' => $khsFile->student_nim,
            'period' => $khsFile->semester_name,
            'access_type' => $accessType
        ]);
    }

    // ========================================
    // STATISTICS & ANALYTICS
    // ========================================

    public function getPeriodStatistics(AcademicPeriod $period)
    {
        $stats = $period->getUploadStatistics();

        // Add access statistics
        $accessStats = DB::table('parent_khs_access_logs')
            ->join('khs_files', 'parent_khs_access_logs.khs_file_id', '=', 'khs_files.id')
            ->where('khs_files.academic_period_id', $period->id)
            ->selectRaw('
                COUNT(*) as total_access,
                COUNT(DISTINCT parent_id) as unique_parents,
                SUM(CASE WHEN access_type = "download" THEN 1 ELSE 0 END) as downloads,
                SUM(CASE WHEN access_type = "view" THEN 1 ELSE 0 END) as views
            ')
            ->first();

        return array_merge($stats, [
            'access_stats' => [
                'total_access' => $accessStats->total_access ?? 0,
                'unique_parents' => $accessStats->unique_parents ?? 0,
                'downloads' => $accessStats->downloads ?? 0,
                'views' => $accessStats->views ?? 0,
            ]
        ]);
    }

    public function getUploadTrends($days = 30)
    {
        return KhsFile::selectRaw('DATE(upload_date) as date, COUNT(*) as count')
            ->where('upload_date', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getTopAccessedFiles($limit = 10)
    {
        return KhsFile::with(['student', 'academicPeriod'])
            ->ready()
            ->orderBy('access_count', 'desc')
            ->limit($limit)
            ->get();
    }

    // ========================================
    // MAINTENANCE & CLEANUP
    // ========================================

    public function retryFailedUploads(AcademicPeriod $period = null)
    {
        $query = KhsFile::failed();

        if ($period) {
            $query->byPeriod($period->id);
        }

        $failedFiles = $query->get();
        $retryResults = ['success' => 0, 'failed' => 0];

        foreach ($failedFiles as $khsFile) {
            try {
                // Mark as uploading
                $khsFile->retry();

                // Get original file path (you might need to store this)
                // This is a simplified version - in real implementation,
                // you'd need to re-upload from stored location or ask user

                $retryResults['success']++;
            } catch (\Exception $e) {
                Log::error('Retry failed: ' . $e->getMessage());
                $retryResults['failed']++;
            }
        }

        return $retryResults;
    }

    public function cleanupOrphanedFiles()
    {
        // Find KHS files that exist in DB but not in Google Drive
        $orphanedFiles = KhsFile::ready()
            ->whereNotNull('gdrive_file_id')
            ->get()
            ->filter(function ($khsFile) {
                return !$this->gdriveService->getFileInfo($khsFile->gdrive_file_id);
            });

        foreach ($orphanedFiles as $file) {
            $file->markAsFailed('File not found in Google Drive');
            Log::warning('Marked orphaned KHS file as failed', ['id' => $file->id]);
        }

        return $orphanedFiles->count();
    }

    // ========================================
    // UTILITY METHODS
    // ========================================

    public function validateUploadFile(UploadedFile $file)
    {
        $maxSize = config('khs.max_file_size', 10240); // KB
        $allowedTypes = config('khs.allowed_mime_types', ['application/pdf']);

        if ($file->getSize() > ($maxSize * 1024)) {
            throw new \Exception("File size exceeds maximum allowed size of {$maxSize}KB");
        }

        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw new \Exception('Only PDF files are allowed');
        }

        return true;
    }

    public function generateKhsReport(AcademicPeriod $period)
    {
        $files = KhsFile::byPeriod($period->id)
            ->with(['student', 'uploader'])
            ->get();

        return [
            'period' => $period,
            'summary' => [
                'total_files' => $files->count(),
                'ready_files' => $files->where('upload_status', 'ready')->count(),
                'failed_files' => $files->where('upload_status', 'failed')->count(),
                'total_size' => $files->sum('file_size'),
                'unique_students' => $files->unique('student_id')->count(),
            ],
            'files' => $files,
            'generated_at' => now()
        ];
    }
}
