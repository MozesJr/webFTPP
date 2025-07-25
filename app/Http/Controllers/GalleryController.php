<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Gallery::active()->with('programStudi');

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter by program studi
        if ($request->prodi) {
            $query->where('prodi_id', $request->prodi);
        }

        $galleries = $query->ordered()
            ->latest('event_date')
            ->paginate(24);

        return Inertia::render('Gallery/Index', [
            'galleries' => $galleries,
            'categories' => Gallery::active()
                ->distinct()
                ->pluck('category')
                ->filter(),
            'programStudis' => ProgramStudi::active()->get(),
            'filters' => $request->only(['category', 'prodi'])
        ]);
    }
}
