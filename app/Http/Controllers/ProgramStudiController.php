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
                    $query->active()->ordered()->take(3);
                }])
                ->get()
                ->groupBy('degree_level')
        ]);
    }

    public function show(ProgramStudi $programStudi): Response
    {
        $programStudi->load([
            'kurikulums' => function ($query) {
                $query->active()->latest();
            },
            'features' => function ($query) {
                $query->active()->ordered();
            },
            'teams' => function ($query) {
                $query->active()->with('position')->ordered();
            },
            'testimonials' => function ($query) {
                $query->active()->take(6);
            },
            'penjaminanMutus' => function ($query) {
                $query->where('status', 'active');
            }
        ]);

        // Get current curriculum with subjects
        $currentKurikulum = $programStudi->kurikulums()
            ->active()
            ->with(['mataKuliahs' => function ($query) {
                $query->active()->orderBy('semester')->orderBy('category');
            }])
            ->latest()
            ->first();

        return Inertia::render('ProgramStudi/Show', [
            'programStudi' => $programStudi,
            'currentKurikulum' => $currentKurikulum,
            'subjectsBySemester' => $currentKurikulum
                ? $currentKurikulum->mataKuliahs->groupBy('semester')
                : collect()
        ]);
    }
}
