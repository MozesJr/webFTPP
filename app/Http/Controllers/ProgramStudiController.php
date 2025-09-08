<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Feature;
use App\Models\Kurikulum;
use App\Models\MataKuliah;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Document;
use App\Models\JadwalKuliah;
use Inertia\Inertia;
use Inertia\Response;

class ProgramStudiController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ProgramStudi/Index', [
            'programStudis' => ProgramStudi::active()
                ->with(['features' => function ($query) {
                    $query->where('is_active', true)->orderBy('order_index', 'asc')->take(3);
                }])
                ->get()
                ->groupBy('degree_level')
        ]);
    }

    public function show(ProgramStudi $programStudi): Response
    {
        // Load relationships
        $programStudi->load([
            'kurikulums' => function ($query) {
                $query->where('is_active', true)->orderBy('academic_year', 'desc');
            },
            'features' => function ($query) {
                $query->where('is_active', true)->orderBy('order_index', 'asc');
            },
            'teams' => function ($query) {
                $query->where('is_active', true)
                    ->with('position')
                    ->orderBy('order_index', 'asc');
            },
            'testimonials' => function ($query) {
                $query->where('is_active', true)->take(6);
            },
            'penjaminanMutus' => function ($query) {
                $query->where('status', 'active');
            },
            // Public Documents
            'documents' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('document_type')
                    ->orderBy('order_index')
                    ->orderBy('title');
            }
        ]);

        // Get current curriculum with subjects
        $currentKurikulum = $programStudi->kurikulums()
            ->where('is_active', true)
            ->orderBy('academic_year', 'desc')
            ->first();

        // Get subjects by semester
        $subjectsBySemester = collect();
        if ($currentKurikulum) {
            $subjectsBySemester = MataKuliah::where('kurikulum_id', $currentKurikulum->id)
                ->where('is_active', true)
                ->orderBy('semester')
                ->orderBy('category')
                ->orderBy('name')
                ->get()
                ->groupBy('semester');
        }

        // Get schedules (jadwal kuliah) with related data
        $schedules = JadwalKuliah::whereHas('mataKuliah', function ($query) use ($programStudi) {
            $query->whereHas('kurikulum', function ($subQuery) use ($programStudi) {
                $subQuery->where('prodi_id', $programStudi->id);
            });
        })
            ->where('is_active', true)
            ->with(['mataKuliah', 'dosen'])
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester')
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'subject_code' => $jadwal->mataKuliah->code ?? '-',
                    'subject_name' => $jadwal->mataKuliah->name ?? '-',
                    'credits' => $jadwal->mataKuliah->credits ?? 0,
                    'class_name' => $jadwal->class_name,
                    'day' => $this->formatDay($jadwal->day),
                    'start_time' => $jadwal->start_time,
                    'end_time' => $jadwal->end_time,
                    'room' => $jadwal->room,
                    'lecturer_name' => $jadwal->dosen->name ?? '-',
                    'semester' => $jadwal->semester,
                    'academic_year' => $jadwal->academic_year,
                    'capacity' => $jadwal->capacity,
                    'enrolled_students' => $jadwal->enrolled_students,
                ];
            });

        // Get related programs (all programs)
        $relatedPrograms = ProgramStudi::active()
            ->select(['id', 'name', 'code', 'degree_level'])
            ->orderBy('name')
            ->orderBy('degree_level')
            ->get();

        return Inertia::render('ProgramStudi/Show', [
            'programStudi' => $programStudi,
            'currentKurikulum' => $currentKurikulum,
            'subjectsBySemester' => $subjectsBySemester,
            'relatedPrograms' => $relatedPrograms,
            'schedules' => $schedules
        ]);
    }

    /**
     * Format day name for display
     */
    private function formatDay($day)
    {
        $days = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];

        return $days[strtolower($day)] ?? $day;
    }
}
