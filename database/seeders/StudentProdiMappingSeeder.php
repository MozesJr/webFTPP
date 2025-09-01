<?php
// database/seeders/StudentProdiMappingSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;

class StudentProdiMappingSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping program_studi (string) ke ProgramStudi ID
        $prodiMappings = [
            'Teknik Informatika' => 'Teknik Informatika',
            'Manajemen' => 'Manajemen',
            'Teknik Geologi' => 'Teknik Geologi',
            'Teknik Perminyakan' => 'Teknik Perminyakan',
            'Teknik Pertambangan' => 'Teknik Pertambangan',
            // Tambahkan mapping lainnya sesuai data Anda
        ];

        foreach ($prodiMappings as $studentProgram => $prodiName) {
            // Cari ProgramStudi berdasarkan nama
            $programStudi = ProgramStudi::where('name', 'LIKE', "%{$prodiName}%")->first();

            if ($programStudi) {
                // Update students yang memiliki program_studi ini
                Student::where('program_studi', $studentProgram)
                    ->whereNull('prodi_id')
                    ->update(['prodi_id' => $programStudi->id]);

                $this->command->info("Updated students with program_studi '{$studentProgram}' to prodi_id {$programStudi->id}");
            } else {
                $this->command->warn("ProgramStudi not found for: {$prodiName}");
            }
        }

        // Log hasil mapping
        $mappedCount = Student::whereNotNull('prodi_id')->count();
        $unmappedCount = Student::whereNull('prodi_id')->count();

        $this->command->info("Mapping completed: {$mappedCount} students mapped, {$unmappedCount} students unmapped");
    }
}
