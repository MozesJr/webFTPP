<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Facility::class);

        $query = Facility::query();

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by availability
        if ($request->has('availability') && $request->availability !== 'all') {
            $query->where('is_available', $request->availability === 'available');
        }

        $facilities = $query->ordered()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Facility/Index', [
            'facilities' => $facilities,
            'filters' => $request->only(['search', 'status', 'availability']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Facility::class);

        return Inertia::render('Admin/Facility/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacilityRequest $request): RedirectResponse
    {
        Gate::authorize('create', Facility::class);

        $data = $request->validated();

        // Handle main image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('facilities', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('facilities/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Clean features array (remove empty values)
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], function ($value) {
                return !empty(trim($value));
            });
            $data['features'] = array_values($data['features']); // Re-index array
        }

        Facility::create($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('message', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility): Response
    {
        Gate::authorize('view', $facility);

        return Inertia::render('Admin/Facility/Show', [
            'facility' => $facility,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility): Response
    {
        Gate::authorize('update', $facility);

        return Inertia::render('Admin/Facility/Edit', [
            'facility' => $facility,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacilityRequest $request, Facility $facility): RedirectResponse
    {
        Gate::authorize('update', $facility);

        $data = $request->validated();

        // Handle main image removal
        if ($request->boolean('remove_image') && $facility->image) {
            if (Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
            $data['image'] = null;
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }

            $data['image'] = $request->file('image')
                ->store('facilities', 'public');
        }

        // Handle gallery images removal
        if ($request->has('remove_gallery') && is_array($request->remove_gallery)) {
            $currentGallery = $facility->gallery ?? [];
            foreach ($request->remove_gallery as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $currentGallery = array_filter($currentGallery, function ($path) use ($imagePath) {
                    return $path !== $imagePath;
                });
            }
            $data['gallery'] = array_values($currentGallery);
        }

        // Handle new gallery images upload
        if ($request->hasFile('gallery')) {
            $currentGallery = $data['gallery'] ?? $facility->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $currentGallery[] = $image->store('facilities/gallery', 'public');
            }
            $data['gallery'] = $currentGallery;
        }

        // Clean features array
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], function ($value) {
                return !empty(trim($value));
            });
            $data['features'] = array_values($data['features']);
        }

        $facility->update($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('message', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        Gate::authorize('delete', $facility);

        $facility->delete();

        return redirect()
            ->route('admin.facilities.index')
            ->with('message', 'Fasilitas berhasil dihapus.');
    }

    /**
     * Toggle the active status of the facility.
     */
    public function toggleStatus(Facility $facility): RedirectResponse
    {
        Gate::authorize('update', $facility);

        $facility->update([
            'is_active' => !$facility->is_active,
        ]);

        $status = $facility->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('message', "Fasilitas berhasil {$status}.");
    }

    /**
     * Toggle the availability status of the facility.
     */
    public function toggleAvailability(Facility $facility): RedirectResponse
    {
        Gate::authorize('update', $facility);

        $facility->update([
            'is_available' => !$facility->is_available,
        ]);

        $status = $facility->is_available ? 'tersedia' : 'tidak tersedia';

        return back()->with('message', "Fasilitas berhasil diubah menjadi {$status}.");
    }
}
