<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeanGreetingRequest;
use App\Http\Requests\UpdateDeanGreetingRequest;
use App\Models\DeanGreeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DeanGreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', DeanGreeting::class);

        $greeting = DeanGreeting::ordered()->first();

        return Inertia::render('Admin/DeanGreeting/Index', [
            'greeting' => $greeting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', DeanGreeting::class);

        // Check if greeting already exists
        $existingGreeting = DeanGreeting::first();

        if ($existingGreeting) {
            return redirect()
                ->route('admin.dean-greeting.index')
                ->with('warning', 'Sambutan dekan sudah ada. Silakan edit yang sudah ada.');
        }

        return Inertia::render('Admin/DeanGreeting/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeanGreetingRequest $request): RedirectResponse
    {
        Gate::authorize('create', DeanGreeting::class);

        // Check if greeting already exists
        $existingGreeting = DeanGreeting::first();

        if ($existingGreeting) {
            return redirect()
                ->route('admin.dean-greeting.index')
                ->with('warning', 'Sambutan dekan sudah ada. Silakan edit yang sudah ada.');
        }

        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('dean_photo')) {
            $data['dean_photo'] = $request->file('dean_photo')
                ->store('dean-greetings', 'public');
        }

        DeanGreeting::create($data);

        return redirect()
            ->route('admin.dean-greeting.index')
            ->with('message', 'Sambutan dekan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeanGreeting $deanGreeting): Response
    {
        Gate::authorize('update', $deanGreeting);

        return Inertia::render('Admin/DeanGreeting/Edit', [
            'greeting' => $deanGreeting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeanGreetingRequest $request, DeanGreeting $deanGreeting): RedirectResponse
    {
        Gate::authorize('update', $deanGreeting);

        $data = $request->validated();

        // Handle photo removal
        if ($request->boolean('remove_photo') && $deanGreeting->dean_photo) {
            if (Storage::disk('public')->exists($deanGreeting->dean_photo)) {
                Storage::disk('public')->delete($deanGreeting->dean_photo);
            }
            $data['dean_photo'] = null;
        }

        // Handle photo upload
        if ($request->hasFile('dean_photo')) {
            // Delete old photo
            if ($deanGreeting->dean_photo && Storage::disk('public')->exists($deanGreeting->dean_photo)) {
                Storage::disk('public')->delete($deanGreeting->dean_photo);
            }

            $data['dean_photo'] = $request->file('dean_photo')
                ->store('dean-greetings', 'public');
        }

        $deanGreeting->update($data);

        return redirect()
            ->route('admin.dean-greeting.index')
            ->with('message', 'Sambutan dekan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeanGreeting $deanGreeting): RedirectResponse
    {
        Gate::authorize('delete', $deanGreeting);

        $deanGreeting->delete();

        return redirect()
            ->route('admin.dean-greeting.index')
            ->with('message', 'Sambutan dekan berhasil dihapus.');
    }

    /**
     * Toggle the active status of the greeting.
     */
    public function toggleStatus(DeanGreeting $deanGreeting): RedirectResponse
    {
        Gate::authorize('update', $deanGreeting);

        $deanGreeting->update([
            'is_active' => !$deanGreeting->is_active,
        ]);

        $status = $deanGreeting->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('message', "Sambutan dekan berhasil {$status}.");
    }
}
