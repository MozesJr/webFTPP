<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AboutController extends Controller
{
    public function index(): Response
    {
        $about = About::first(); // Karena hanya 1 data

        return Inertia::render('Admin/About/Index', [
            'about' => $about
        ]);
    }

    public function create(): Response
    {
        // Check if data already exists
        $existingAbout = About::first();

        if ($existingAbout) {
            return redirect()->route('admin.about.edit')
                ->with('message', 'Data About sudah ada. Anda akan diarahkan ke halaman edit.');
        }

        return Inertia::render('Admin/About/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Check if data already exists
        if (About::exists()) {
            return redirect()->route('admin.about.index')
                ->with('error', 'Data About sudah ada. Tidak dapat menambah data baru.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|string|url',
            'video_title' => 'nullable|string|max:255',
            'video_description' => 'nullable|string',
            'secondary_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Handle main image upload
        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $this->uploadImage($request->file('image_url'), 'main');
        }

        // Handle secondary image upload
        if ($request->hasFile('secondary_image_url')) {
            $validated['secondary_image_url'] = $this->uploadImage($request->file('secondary_image_url'), 'secondary');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        About::create($validated);

        return redirect()->route('admin.about.index')
            ->with('message', 'Data About berhasil dibuat.');
    }

    public function show(About $about): Response
    {
        return Inertia::render('Admin/About/Show', [
            'about' => $about
        ]);
    }

    public function edit(): Response
    {
        $about = About::first();

        if (!$about) {
            return redirect()->route('admin.about.create')
                ->with('message', 'Data About belum ada. Silakan buat terlebih dahulu.');
        }

        return Inertia::render('Admin/About/Edit', [
            'about' => $about
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $about = About::first();

        if (!$about) {
            return redirect()->route('admin.about.create')
                ->with('error', 'Data About tidak ditemukan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|string|url',
            'video_title' => 'nullable|string|max:255',
            'video_description' => 'nullable|string',
            'secondary_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Handle main image upload
        if ($request->hasFile('image_url')) {
            // Delete old image
            if ($about->image_url) {
                $this->deleteImage($about->image_url);
            }
            $validated['image_url'] = $this->uploadImage($request->file('image_url'), 'main');
        }

        // Handle secondary image upload
        if ($request->hasFile('secondary_image_url')) {
            // Delete old secondary image
            if ($about->secondary_image_url) {
                $this->deleteImage($about->secondary_image_url);
            }
            $validated['secondary_image_url'] = $this->uploadImage($request->file('secondary_image_url'), 'secondary');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $about->update($validated);

        return redirect()->route('admin.about.index')
            ->with('message', 'Data About berhasil diperbarui.');
    }

    public function destroy(): RedirectResponse
    {
        $about = About::first();

        if (!$about) {
            return redirect()->route('admin.about.index')
                ->with('error', 'Data About tidak ditemukan.');
        }

        // Delete associated images
        if ($about->image_url) {
            $this->deleteImage($about->image_url);
        }
        if ($about->secondary_image_url) {
            $this->deleteImage($about->secondary_image_url);
        }

        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('message', 'Data About berhasil dihapus.');
    }

    public function toggleStatus(): RedirectResponse
    {
        $about = About::first();

        if (!$about) {
            return redirect()->route('admin.about.index')
                ->with('error', 'Data About tidak ditemukan.');
        }

        $about->update(['is_active' => !$about->is_active]);

        $status = $about->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.about.index')
            ->with('message', "Data About berhasil $status.");
    }

    /**
     * Upload image to public/storage/assets/img/about/
     */
    private function uploadImage($file, $type = 'main')
    {
        // Create directory if not exists
        $uploadPath = public_path('storage/assets/img/about');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = $type . '_' . time() . '_' . uniqid() . '.' . $extension;

        // Move file to destination
        $file->move($uploadPath, $filename);

        // Return relative path for database storage
        return 'storage/assets/img/about/' . $filename;
    }

    /**
     * Delete image from public directory
     */
    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            $fullPath = public_path($imagePath);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
