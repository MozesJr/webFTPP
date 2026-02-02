<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/**
 * GPM Controller
 * ==============
 * Handles all GPM (Gugus Penjaminan Mutu) related pages
 *
 * Path: app/Http/Controllers/GPMController.php
 *
 * ARCHITECTURE NOTES:
 * - Thin controller: hanya routing dan passing data minimal
 * - Data akan di-fetch dari model/repository (untuk fase selanjutnya)
 * - Setiap method mereturn Inertia response dengan Vue component
 */
class GPMController extends Controller
{
    /**
     * Display GPM main/index page
     * Route: /evaluation
     */
    public function index(): Response
    {
        return Inertia::render('GPM/Index', [
            'pageTitle' => 'Gugus Penjaminan Mutu',
            'pageDescription' => 'Sistem Penjaminan Mutu Internal Fakultas Teknologi Pertambangan dan Perminyakan',
        ]);
    }

    /**
     * Display Struktur Organisasi GPM
     * Route: /gpm/struktur-organisasi
     */
    public function strukturOrganisasi(): Response
    {
        // TODO: Fetch data dari StrukturOrganisasiGPM model
        // $strukturs = StrukturOrganisasiGPM::active()->orderBy('order')->get();

        return Inertia::render('GPM/StrukturOrganisasi', [
            'pageTitle' => 'Struktur Organisasi GPM',
            'pageDescription' => 'Struktur Organisasi Gugus Penjaminan Mutu FTPP',
            // 'strukturs' => $strukturs,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Struktur Organisasi', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Dokumen SPMI
     * Route: /gpm/dokumen-spmi
     *
     * SPMI: Sistem Penjaminan Mutu Internal
     */
    public function dokumenSPMI(): Response
    {
        // TODO: Fetch data dari DokumenSPMI model
        // $dokumens = DokumenSPMI::with('category')
        //     ->published()
        //     ->latest()
        //     ->paginate(12);

        return Inertia::render('GPM/DokumenSPMI', [
            'pageTitle' => 'Dokumen SPMI',
            'pageDescription' => 'Dokumen Sistem Penjaminan Mutu Internal FTPP',
            // 'dokumens' => $dokumens,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Dokumen SPMI', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Survey Kepuasan
     * Route: /gpm/survey-kepuasan
     */
    public function surveyKepuasan(): Response
    {
        // TODO: Fetch active surveys dari SurveyKepuasan model
        // $surveys = SurveyKepuasan::active()
        //     ->with('questions')
        //     ->latest()
        //     ->get();

        return Inertia::render('GPM/SurveyKepuasan', [
            'pageTitle' => 'Survey Kepuasan',
            'pageDescription' => 'Survey Kepuasan Mahasiswa, Dosen, dan Stakeholder',
            // 'surveys' => $surveys,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Survey Kepuasan', 'url' => null],
            ],
        ]);
    }

    /**
     * Display Survey EDOM
     * Route: /gpm/survey-edom
     *
     * EDOM: Evaluasi Dosen Oleh Mahasiswa
     */
    public function surveyEDOM(): Response
    {
        // TODO: Fetch active EDOM surveys
        // $edomSurveys = SurveyEDOM::active()
        //     ->with(['courses', 'lecturers'])
        //     ->latest()
        //     ->get();

        return Inertia::render('GPM/SurveyEDOM', [
            'pageTitle' => 'Survey EDOM',
            'pageDescription' => 'Evaluasi Dosen Oleh Mahasiswa',
            // 'edomSurveys' => $edomSurveys,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'GPM', 'url' => '/evaluation'],
                ['label' => 'Survey EDOM', 'url' => null],
            ],
        ]);
    }
}
