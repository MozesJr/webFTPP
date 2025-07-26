<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Stats;
use App\Models\Team;
use App\Models\TeamPosition;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\SiteSetting;
use App\Models\ProgramStudi;

class AboutController extends Controller
{
    public function index(): Response
    {
        $data = [
            'about' => About::active()->first(),
            'stats' => Stats::current()->first(),
            'leadership' => Team::active()
                ->with(['position', 'programStudi'])
                ->whereHas('position', function ($query) {
                    $query->where('level', '<=', 3); // Top 3 levels
                })
                ->ordered()
                ->get()
                ->groupBy('position.name'),
            'faculty' => Team::active()
                ->with(['position', 'programStudi'])
                ->whereHas('position', function ($query) {
                    $query->where('level', '>', 3);
                })
                ->ordered()
                ->get()
                ->groupBy('programStudi.name'),
            'sejarah' => SiteSetting::get('sejarah', ''),
            // Tambahkan data program studi untuk tabel akreditasi
            'programStudi' => ProgramStudi::active()
                ->select([
                    'id',
                    'name',
                    'code',
                    'degree_level',
                    'accreditation',
                    'accreditation_date',
                    'accreditation_expire'
                ])
                ->orderBy('degree_level')
                ->orderBy('name')
                ->get(),
            // Data program studi untuk section cards (dikelompokkan berdasarkan nama)
            'programStudiCards' => $this->getProgramStudiCards()
        ];

        // dd($data);

        return Inertia::render('About', $data);
    }

    private function getProgramStudiCards()
    {
        return ProgramStudi::active()
            ->select([
                'id',
                'name',
                'code',
                'degree_level',
                'description',
                'overview',
                'image_url',
                'accreditation',
                'head_of_program',
                'established_year'
            ])
            ->orderBy('name')
            ->orderBy('degree_level')
            ->get()
            ->map(function ($prodi) {
                return [
                    'id' => $prodi->id,
                    'name' => $prodi->name,
                    'code' => $prodi->code,
                    'degree_level' => $prodi->degree_level,
                    'full_name' => $prodi->name . ' (' . $prodi->degree_level . ')',
                    'description' => $prodi->description,
                    'overview' => $prodi->overview,
                    'image_url' => $prodi->image_url,
                    'accreditation' => $prodi->accreditation ?? '-',
                    'head_of_program' => $prodi->head_of_program,
                    'established_year' => $prodi->established_year
                ];
            });
    }
}
