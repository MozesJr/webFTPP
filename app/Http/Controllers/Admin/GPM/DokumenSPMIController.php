<?php

namespace App\Http\Controllers\Admin\GPM;

use App\Http\Controllers\Controller;
use App\Models\GPM\DokumenSPMI;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenSPMIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DokumenSPMI::query()->with('uploader');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Order
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $dokumen = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/GPM/DokumenSPMI/Index', [
            'dokumen' => $dokumen,
            'filters' => $request->only(['search', 'category', 'status', 'sort_by', 'sort_order']),
            'categories' => [
                'standar' => 'Standar SPMI',
                'manual' => 'Manual SPMI',
                'formulir' => 'Formulir',
                'sop' => 'SOP',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/GPM/DokumenSPMI/Create', [
            'categories' => [
                'standar' => 'Standar SPMI',
                'manual' => 'Manual SPMI',
                'formulir' => 'Formulir',
                'sop' => 'SOP',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:standar,manual,formulir,sop',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'document_code' => 'nullable|string|max:50',
            'version' => 'nullable|string|max:20',
            'published_date' => 'nullable|date',
            'effective_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'is_published' => 'boolean',
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
            'file.required' => 'File dokumen wajib diunggah.',
            'file.mimes' => 'File harus berformat: pdf, doc, docx, xls, xlsx.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Upload file
        $fileData = $this->uploadFile($request->file('file'));
        $validated = array_merge($validated, $fileData);

        // Auto generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Make slug unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (DokumenSPMI::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        // Set uploaded_by
        $validated['uploaded_by'] = auth()->id();

        // Set published_at if published
        if ($validated['is_published'] && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        DokumenSPMI::create($validated);

        return redirect()
            ->route('admin.gpm.dokumen-spmi.index')
            ->with('success', 'Dokumen SPMI berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumenSPMI $dokumenSpmi)
    {
        $dokumenSpmi->load('uploader');
        $dokumenSpmi->incrementViews();

        return Inertia::render('Admin/GPM/DokumenSPMI/Show', [
            'dokumen' => $dokumenSpmi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenSPMI $dokumenSpmi)
    {
        return Inertia::render('Admin/GPM/DokumenSPMI/Edit', [
            'dokumen' => $dokumenSpmi,
            'categories' => [
                'standar' => 'Standar SPMI',
                'manual' => 'Manual SPMI',
                'formulir' => 'Formulir',
                'sop' => 'SOP',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenSPMI $dokumenSpmi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:standar,manual,formulir,sop',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'document_code' => 'nullable|string|max:50',
            'version' => 'nullable|string|max:20',
            'published_date' => 'nullable|date',
            'effective_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'is_published' => 'boolean',
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
            'file.mimes' => 'File harus berformat: pdf, doc, docx, xls, xlsx.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Upload new file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            $this->deleteFile($dokumenSpmi->file_path);
            
            // Upload new file
            $fileData = $this->uploadFile($request->file('file'));
            $validated = array_merge($validated, $fileData);
        }

        // Update slug if title changed
        if ($validated['title'] !== $dokumenSpmi->title) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Make slug unique
            $originalSlug = $validated['slug'];
            $count = 1;
            while (DokumenSPMI::where('slug', $validated['slug'])
                ->where('id', '!=', $dokumenSpmi->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Set published_at if status changed to published
        if ($validated['is_published'] && !$dokumenSpmi->is_published) {
            $validated['published_at'] = now();
        }

        $dokumenSpmi->update($validated);

        return redirect()
            ->route('admin.gpm.dokumen-spmi.index')
            ->with('success', 'Dokumen SPMI berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenSPMI $dokumenSpmi)
    {
        // Delete file
        $this->deleteFile($dokumenSpmi->file_path);

        $dokumenSpmi->delete();

        return redirect()
            ->route('admin.gpm.dokumen-spmi.index')
            ->with('success', 'Dokumen SPMI berhasil dihapus.');
    }

    /**
     * Download the document.
     */
    public function download(DokumenSPMI $dokumenSpmi)
    {
        $dokumenSpmi->incrementDownloads();

        $storagePath = str_replace('storage/', '', $dokumenSpmi->file_path);
        
        if (!Storage::disk('public')->exists($storagePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($storagePath, $dokumenSpmi->file_name);
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(DokumenSPMI $dokumenSpmi)
    {
        $isPublished = !$dokumenSpmi->is_published;
        
        $dokumenSpmi->update([
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        $status = $isPublished ? 'dipublikasikan' : 'di-draft';

        return back()->with('success', "Dokumen berhasil {$status}.");
    }

    /**
     * Upload file.
     */
    private function uploadFile($file): array
    {
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('assets/gpm/dokumen', $filename, 'public');

        return [
            'file_path' => 'storage/' . $path,
            'file_name' => $originalName,
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientOriginalExtension(),
        ];
    }

    /**
     * Delete file.
     */
    private function deleteFile(string $path): void
    {
        $storagePath = str_replace('storage/', '', $path);
        
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }
}
