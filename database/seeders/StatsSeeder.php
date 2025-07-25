<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stats;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        // Current year stats
        Stats::create([
            'total_students' => 2547,
            'total_partnerships' => 85,
            'total_alumni' => 12350,
            'total_lecturers' => 65,
            'year' => date('Y'),
            'is_current' => true,
        ]);

        // Previous years for historical data
        Stats::create([
            'total_students' => 2398,
            'total_partnerships' => 78,
            'total_alumni' => 11245,
            'total_lecturers' => 62,
            'year' => date('Y') - 1,
            'is_current' => false,
        ]);

        Stats::create([
            'total_students' => 2156,
            'total_partnerships' => 71,
            'total_alumni' => 10120,
            'total_lecturers' => 58,
            'year' => date('Y') - 2,
            'is_current' => false,
        ]);
    }
}
