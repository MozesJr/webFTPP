<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleDriveService;
use App\Models\AcademicPeriod;

class SetupKhsSystem extends Command
{
    protected $signature = 'khs:setup {--test-connection : Test Google Drive connection}';
    protected $description = 'Setup KHS system and Google Drive integration';

    public function handle()
    {
        $this->info('Setting up KHS System...');

        if ($this->option('test-connection')) {
            return $this->testGoogleDriveConnection();
        }

        // Setup Google Drive folders
        try {
            $gdriveService = app(GoogleDriveService::class);
            $rootFolderId = $gdriveService->setupFolderStructure();

            $this->info("✓ Google Drive folder structure created");
            $this->info("Root folder ID: {$rootFolderId}");
        } catch (\Exception $e) {
            $this->error("✗ Failed to setup Google Drive: " . $e->getMessage());
            return 1;
        }

        // Check academic periods
        $periodsCount = AcademicPeriod::count();
        $this->info("✓ Academic periods: {$periodsCount} found");

        if ($periodsCount === 0) {
            $this->warn("No academic periods found. Run: php artisan db:seed --class=AcademicPeriodSeeder");
        }

        $this->info('KHS System setup completed successfully!');
        return 0;
    }

    private function testGoogleDriveConnection()
    {
        $this->info('Testing Google Drive connection...');

        try {
            $gdriveService = app(GoogleDriveService::class);

            if ($gdriveService->testConnection()) {
                $this->info('✓ Google Drive connection successful');
                return 0;
            } else {
                $this->error('✗ Google Drive connection failed');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('✗ Google Drive connection error: ' . $e->getMessage());
            return 1;
        }
    }
}
