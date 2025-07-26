<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Feature;
use App\Models\Kurikulum;
use App\Models\Team;
use App\Models\Testimonial;
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

        // dd($programStudi);
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
            }
        ]);

        // Get current curriculum with subjects (jika ada tabel mata kuliah)
        $currentKurikulum = $programStudi->kurikulums()
            ->where('is_active', true)
            ->orderBy('academic_year', 'desc')
            ->first();

        // Get subjects by semester (jika ada relationship ke mata kuliah)
        $subjectsBySemester = collect();
        if ($currentKurikulum && method_exists($currentKurikulum, 'mataKuliahs')) {
            $subjectsBySemester = $currentKurikulum->mataKuliahs()
                ->where('is_active', true)
                ->orderBy('semester')
                ->orderBy('category')
                ->get()
                ->groupBy('semester');
        }

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
            'relatedPrograms' => $relatedPrograms
        ]);
    }
}
