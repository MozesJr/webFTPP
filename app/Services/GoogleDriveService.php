<?php
// app/Services/GoogleDriveService.php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use App\Models\AcademicPeriod;
use App\Models\GdriveFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    private $client;
    private $service;

    public function __construct()
    {
        $this->initializeClient();
    }

    // ========================================
    // INITIALIZATION
    // ========================================

    private function initializeClient()
    {
        $this->client = new Client();

        // Set auth config
        $this->client->setAuthConfig([
            'client_id' => config('services.google.drive.client_id'),
            'client_secret' => config('services.google.drive.client_secret'),
            'redirect_uris' => [config('services.google.drive.redirect_uri')]
        ]);

        $this->client->addScope(Drive::DRIVE);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        // Set refresh token if available
        if ($refreshToken = config('services.google.drive.refresh_token')) {
            $this->client->refreshToken($refreshToken);
        }

        $this->service = new Drive($this->client);
    }

    // ========================================
    // FOLDER MANAGEMENT
    // ========================================

    /**
     * Setup folder structure:
     * 📁 KHS_Portal_Orang_Tua/
     *   📁 2025-2026/
     *     📁 Semester_Ganjil/
     *     📁 Semester_Genap/
     */
    public function setupFolderStructure()
    {
        try {
            $rootFolder = $this->getOrCreateRootFolder();

            Log::info('Google Drive folder structure initialized', [
                'root_folder_id' => $rootFolder
            ]);

            return $rootFolder;
        } catch (\Exception $e) {
            Log::error('Failed to setup Google Drive folder structure: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getOrCreateRootFolder()
    {
        // Check if root folder already exists in DB
        $existingRoot = GdriveFolder::where('folder_type', 'root')->first();

        if ($existingRoot && $this->folderExists($existingRoot->gdrive_folder_id)) {
            return $existingRoot->gdrive_folder_id;
        }

        // Create new root folder
        $rootFolder = $this->createFolder('KHS_Portal_Orang_Tua', null);

        GdriveFolder::updateOrCreate(
            ['folder_type' => 'root'],
            [
                'folder_name' => 'KHS_Portal_Orang_Tua',
                'gdrive_folder_id' => $rootFolder->getId(),
                'folder_type' => 'root',
                'is_active' => true
            ]
        );

        return $rootFolder->getId();
    }

    public function getOrCreatePeriodFolder(AcademicPeriod $period)
    {
        // Check if folder already exists
        $existingFolder = GdriveFolder::where('academic_period_id', $period->id)
            ->where('folder_type', 'semester')
            ->first();

        if ($existingFolder && $this->folderExists($existingFolder->gdrive_folder_id)) {
            return $existingFolder->gdrive_folder_id;
        }

        try {
            // Get or create academic year folder
            $yearFolderId = $this->getOrCreateYearFolder($period->academic_year);

            // Create semester folder
            $semesterFolderName = "Semester_" . ucfirst($period->semester);
            $semesterFolder = $this->createFolder($semesterFolderName, $yearFolderId);

            // Save to database
            GdriveFolder::updateOrCreate(
                [
                    'academic_period_id' => $period->id,
                    'folder_type' => 'semester'
                ],
                [
                    'folder_name' => $semesterFolderName,
                    'gdrive_folder_id' => $semesterFolder->getId(),
                    'parent_folder_id' => $yearFolderId,
                    'folder_type' => 'semester',
                    'academic_period_id' => $period->id,
                    'is_active' => true
                ]
            );

            Log::info('Created semester folder', [
                'period' => $period->name,
                'folder_id' => $semesterFolder->getId()
            ]);

            return $semesterFolder->getId();
        } catch (\Exception $e) {
            Log::error('Failed to create period folder: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getOrCreateYearFolder($academicYear)
    {
        // Check existing
        $existingFolder = GdriveFolder::where('folder_type', 'academic_year')
            ->where('folder_name', $academicYear)
            ->first();

        if ($existingFolder && $this->folderExists($existingFolder->gdrive_folder_id)) {
            return $existingFolder->gdrive_folder_id;
        }

        // Get root folder
        $rootFolder = GdriveFolder::where('folder_type', 'root')->first();

        if (!$rootFolder) {
            $rootFolderId = $this->setupFolderStructure();
            $rootFolder = GdriveFolder::where('folder_type', 'root')->first();
        }

        // Create year folder
        $yearFolder = $this->createFolder($academicYear, $rootFolder->gdrive_folder_id);

        GdriveFolder::updateOrCreate(
            [
                'folder_type' => 'academic_year',
                'folder_name' => $academicYear
            ],
            [
                'folder_name' => $academicYear,
                'gdrive_folder_id' => $yearFolder->getId(),
                'parent_folder_id' => $rootFolder->gdrive_folder_id,
                'folder_type' => 'academic_year',
                'is_active' => true
            ]
        );

        return $yearFolder->getId();
    }

    // ========================================
    // FILE OPERATIONS
    // ========================================

    public function uploadKhsFile(UploadedFile $file, $student, AcademicPeriod $period)
    {
        try {
            // Get semester folder
            $folderId = $this->getOrCreatePeriodFolder($period);

            // Generate consistent filename
            $filename = $this->generateKhsFilename($student, $period);

            // Check if file with same name already exists and delete it
            $this->deleteExistingFile($filename, $folderId);

            // Create file metadata
            $fileMetadata = new DriveFile([
                'name' => $filename,
                'parents' => [$folderId]
            ]);

            // Upload file
            $result = $this->service->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart'
            ]);

            // Set file permissions
            $this->setFilePermissions($result->getId());

            Log::info('KHS file uploaded successfully', [
                'filename' => $filename,
                'file_id' => $result->getId(),
                'student_nim' => $student->nim
            ]);

            return [
                'file_id' => $result->getId(),
                'file_name' => $filename,
                'view_url' => "https://drive.google.com/file/d/{$result->getId()}/view",
                'download_url' => "https://drive.google.com/uc?export=download&id={$result->getId()}",
                'folder_id' => $folderId
            ];
        } catch (\Exception $e) {
            Log::error('Failed to upload KHS file: ' . $e->getMessage(), [
                'student_nim' => $student->nim ?? null,
                'period' => $period->name ?? null
            ]);
            throw $e;
        }
    }

    private function deleteExistingFile($filename, $folderId)
    {
        try {
            // Search for existing file
            $query = "name='{$filename}' and '{$folderId}' in parents and trashed=false";
            $response = $this->service->files->listFiles([
                'q' => $query,
                'spaces' => 'drive'
            ]);

            foreach ($response->getFiles() as $file) {
                $this->service->files->delete($file->getId());
                Log::info('Deleted existing KHS file', ['filename' => $filename]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to check/delete existing file: ' . $e->getMessage());
        }
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    private function createFolder($name, $parentId = null)
    {
        $fileMetadata = new DriveFile([
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        if ($parentId) {
            $fileMetadata->setParents([$parentId]);
        }

        return $this->service->files->create($fileMetadata);
    }

    private function setFilePermissions($fileId)
    {
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader'
        ]);

        $this->service->permissions->create($fileId, $permission);
    }

    private function folderExists($folderId)
    {
        try {
            $this->service->files->get($folderId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function generateKhsFilename($student, AcademicPeriod $period)
    {
        return "{$student->nim}_KHS_" . ucfirst($period->semester) . "_{$period->academic_year}.pdf";
    }

    // ========================================
    // PUBLIC UTILITY METHODS
    // ========================================

    public function deleteFile($fileId)
    {
        try {
            $this->service->files->delete($fileId);
            Log::info('Deleted Google Drive file', ['file_id' => $fileId]);
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete GDrive file: " . $e->getMessage());
            return false;
        }
    }

    public function getFileInfo($fileId)
    {
        try {
            return $this->service->files->get($fileId, [
                'fields' => 'id,name,size,mimeType,createdTime,modifiedTime,parents'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get GDrive file info: " . $e->getMessage());
            return null;
        }
    }

    public function generateDirectDownloadUrl($fileId)
    {
        return "https://drive.google.com/uc?export=download&id={$fileId}";
    }

    public function generatePreviewUrl($fileId)
    {
        return "https://drive.google.com/file/d/{$fileId}/view";
    }

    public function testConnection()
    {
        try {
            $this->service->about->get(['fields' => 'user']);
            return true;
        } catch (\Exception $e) {
            Log::error('Google Drive connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // BATCH OPERATIONS
    // ========================================

    public function batchUpload(array $files, AcademicPeriod $period, $callback = null)
    {
        $results = [
            'success' => [],
            'failed' => [],
            'total' => count($files)
        ];

        foreach ($files as $nim => $file) {
            try {
                $student = \App\Models\Student::where('nim', $nim)->first();

                if (!$student) {
                    $results['failed'][$nim] = 'Student not found';
                    continue;
                }

                $uploadResult = $this->uploadKhsFile($file, $student, $period);
                $results['success'][$nim] = $uploadResult;

                // Call progress callback if provided
                if ($callback) {
                    $callback($nim, true, $uploadResult);
                }
            } catch (\Exception $e) {
                $results['failed'][$nim] = $e->getMessage();

                if ($callback) {
                    $callback($nim, false, $e->getMessage());
                }
            }
        }

        return $results;
    }
}
