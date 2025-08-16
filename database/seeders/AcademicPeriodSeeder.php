<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicPeriod;

class AcademicPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            [
                'name' => 'Semester Ganjil 2023/2024',
                'year' => 2023,
                'semester' => 'ganjil',
                'academic_year' => '2023/2024',
                'is_active' => false,
                'start_date' => '2023-08-01',
                'end_date' => '2024-01-31',
            ],
            [
                'name' => 'Semester Genap 2023/2024',
                'year' => 2024,
                'semester' => 'genap',
                'academic_year' => '2023/2024',
                'is_active' => false,
                'start_date' => '2024-02-01',
                'end_date' => '2024-07-31',
            ],
            [
                'name' => 'Semester Ganjil 2024/2025',
                'year' => 2024,
                'semester' => 'ganjil',
                'academic_year' => '2024/2025',
                'is_active' => false,
                'start_date' => '2024-08-01',
                'end_date' => '2025-01-31',
            ],
            [
                'name' => 'Semester Genap 2024/2025',
                'year' => 2025,
                'semester' => 'genap',
                'academic_year' => '2024/2025',
                'is_active' => true, // Current active period
                'start_date' => '2025-02-01',
                'end_date' => '2025-07-31',
            ],
            [
                'name' => 'Semester Ganjil 2025/2026',
                'year' => 2025,
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'is_active' => false,
                'start_date' => '2025-08-01',
                'end_date' => '2026-01-31',
            ],
        ];

        foreach ($periods as $period) {
            AcademicPeriod::updateOrCreate(
                [
                    'year' => $period['year'],
                    'semester' => $period['semester']
                ],
                $period
            );
        }
    }
}
