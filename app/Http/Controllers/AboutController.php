<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Stats;
use App\Models\Team;
use App\Models\TeamPosition;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('About', [
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
                ->groupBy('programStudi.name')
        ]);
    }
}
