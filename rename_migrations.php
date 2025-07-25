<?php

/**
 * Script untuk rename file migration Laravel agar terurut
 * Jalankan script ini di root directory Laravel Anda
 */

$migrationPath = 'database/migrations/';

// Daftar file migration yang akan di-rename secara berurutan
$migrations = [
    '0001_01_01_000000_create_users_table.php',
    '0001_01_01_000001_create_cache_table.php',
    '0001_01_01_000002_create_jobs_table.php',
    '2025_07_17_133104_create_telescope_entries_table.php',
    '2025_07_17_133718_1_create_hero_sections_table.php',
    '2025_07_17_133726_2_create_abouts_table.php',
    '2025_07_17_133727_3_create_stats_table.php',
    '2025_07_17_133727_4_create_program_studis_table.php',
    '2025_07_17_133727_5_create_kurikulums_table.php',
    '2025_07_17_133727_6_create_mata_kuliahs_table.php',
    '2025_07_17_133727_7_create_team_positions_table.php',
    '2025_07_17_133727_8_create_teams_table.php',
    '2025_07_17_133727_9_create_jadwal_kuliahs_table.php',
    '2025_07_17_133727_10_create_rps_table.php',
    '2025_07_17_133727_11_create_rps_weekly_plans_table.php',
    '2025_07_17_133727_12_create_dosen_mata_kuliahs_table.php',
    '2025_07_17_133738_13_create_penjaminan_mutus_table.php',
    '2025_07_17_133750_14_create_clients_table.php',
    '2025_07_17_133750_15_create_features_table.php',
    '2025_07_17_133750_16_create_testimonials_table.php',
    '2025_07_17_133754_17_create_news_categories_table.php',
    '2025_07_17_133755_18_create_news_table.php',
    '2025_07_17_133806_19_create_contact_infos_table.php',
    '2025_07_17_133807_20_create_contact_messages_table.php',
    '2025_07_17_133807_21_create_site_settings_table.php',
    '2025_07_17_133811_22_create_galleries_table.php',
    '2025_07_17_133811_23_create_events_table.php',
    '2025_07_17_133819_create_permission_tables.php'
];

function renameMigrations($migrationPath, $migrations)
{
    echo "Starting migration file renaming...\n";

    // Cek apakah folder migrations ada
    if (!is_dir($migrationPath)) {
        echo "Error: Migration directory not found at {$migrationPath}\n";
        return false;
    }

    $counter = 0;
    $success = 0;
    $errors = [];

    foreach ($migrations as $oldName) {
        $counter++;

        // Format nama file baru dengan padding 6 digit
        $newName = sprintf(
            '0001_01_01_%06d_%s',
            $counter - 1,
            preg_replace('/^\d{4}_\d{2}_\d{2}_\d+_?/', '', $oldName)
        );

        $oldPath = $migrationPath . $oldName;
        $newPath = $migrationPath . $newName;

        // Cek apakah file lama ada
        if (!file_exists($oldPath)) {
            $errors[] = "File not found: {$oldName}";
            continue;
        }

        // Cek apakah file baru sudah ada
        if (file_exists($newPath)) {
            $errors[] = "Target file already exists: {$newName}";
            continue;
        }

        // Rename file
        if (rename($oldPath, $newPath)) {
            echo "✓ Renamed: {$oldName} -> {$newName}\n";
            $success++;
        } else {
            $errors[] = "Failed to rename: {$oldName} -> {$newName}";
        }
    }

    // Summary
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "SUMMARY:\n";
    echo "Total files processed: " . count($migrations) . "\n";
    echo "Successfully renamed: {$success}\n";
    echo "Errors: " . count($errors) . "\n";

    if (!empty($errors)) {
        echo "\nERRORS:\n";
        foreach ($errors as $error) {
            echo "✗ {$error}\n";
        }
    }

    return count($errors) === 0;
}

// Jalankan fungsi rename
if (renameMigrations($migrationPath, $migrations)) {
    echo "\n✅ All migrations renamed successfully!\n";
    echo "You can now run: php artisan migrate\n";
} else {
    echo "\n❌ Some errors occurred during renaming.\n";
    echo "Please check the errors above and fix them manually.\n";
}
