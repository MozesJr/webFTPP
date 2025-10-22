<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities for public view.
     */
    public function index(Request $request): Response
    {
        $query = Facility::active()->available();

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $facilities = $query->ordered()
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Facilities/Index', [
            'facilities' => $facilities,
            'search' => $request->search,
        ]);
    }

    /**
     * Display the specified facility.
     */
    public function show($slug): Response
    {
        $facility = Facility::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get related facilities (same category or random)
        $relatedFacilities = Facility::active()
            ->available()
            ->where('id', '!=', $facility->id)
            ->ordered()
            ->limit(3)
            ->get();

        return Inertia::render('Facilities/Show', [
            'facility' => $facility,
            'relatedFacilities' => $relatedFacilities,
        ]);
    }
}
