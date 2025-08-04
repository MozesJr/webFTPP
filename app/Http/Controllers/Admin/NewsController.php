<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        // Ambil filter dari request
        $filters = $request->only(['search', 'category', 'status']);

        $news = News::query()
            ->with(['category', 'author'])
            // Filter pencarian
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            // Filter kategori
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category_id', $category);
            })
            // Filter status
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/News/Index', [
            'news' => $news,
            'categories' => NewsCategory::where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/News/Create', [
            'categories' => NewsCategory::where('is_active', true)->get(),
            'authors' => Team::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    'unique:news,title'
                ],
                'excerpt' => [
                    'required',
                    'string',
                    'min:20',
                    'max:500'
                ],
                'content' => [
                    'required',
                    'string',
                    'min:50'
                ],
                'featured_image' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048'
                ],
                'category_id' => [
                    'required',
                    'exists:news_categories,id'
                ],
                'author_id' => [
                    'nullable',
                    'exists:teams,id'
                ],
                'status' => [
                    'required',
                    'in:draft,published,archived'
                ],
                'published_at' => [
                    'nullable',
                    'date',
                    'after_or_equal:today'
                ],
                'is_featured' => [
                    'boolean'
                ],
                'tags' => [
                    'nullable',
                    'string',
                    'max:500'
                ],
                'meta_title' => [
                    'nullable',
                    'string',
                    'max:60'
                ],
                'meta_description' => [
                    'nullable',
                    'string',
                    'max:160'
                ]
            ], [
                // Custom error messages
                'title.required' => 'Judul berita wajib diisi.',
                'title.min' => 'Judul berita minimal 5 karakter.',
                'title.max' => 'Judul berita maksimal 255 karakter.',
                'title.unique' => 'Judul berita sudah digunakan.',

                'excerpt.required' => 'Ringkasan berita wajib diisi.',
                'excerpt.min' => 'Ringkasan berita minimal 20 karakter.',
                'excerpt.max' => 'Ringkasan berita maksimal 500 karakter.',

                'content.required' => 'Konten berita wajib diisi.',
                'content.min' => 'Konten berita minimal 50 karakter.',

                'featured_image.image' => 'File harus berupa gambar.',
                'featured_image.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
                'featured_image.max' => 'Ukuran gambar maksimal 2MB.',

                'category_id.required' => 'Kategori berita wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',

                'author_id.exists' => 'Penulis yang dipilih tidak valid.',

                'status.required' => 'Status berita wajib dipilih.',
                'status.in' => 'Status berita tidak valid.',

                'published_at.date' => 'Format tanggal publikasi tidak valid.',
                'published_at.after_or_equal' => 'Tanggal publikasi tidak boleh sebelum hari ini.',

                'tags.max' => 'Tags maksimal 500 karakter.',
                'meta_title.max' => 'Meta title maksimal 60 karakter.',
                'meta_description.max' => 'Meta description maksimal 160 karakter.',
            ]);

            // Generate slug
            $validated['slug'] = Str::slug($validated['title']);

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                try {
                    $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return back()->withErrors(['featured_image' => 'Gagal mengunggah gambar.'])->withInput();
                }
            }

            // Set default values
            $validated['author_id'] = $validated['author_id'] ?? auth()->id();
            $validated['is_featured'] = $request->boolean('is_featured', false);
            $validated['views_count'] = 0;

            // Convert tags string to array if provided
            if (!empty($validated['tags'])) {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            } else {
                $validated['tags'] = [];
            }

            // Set published_at if status is published and not set
            if ($validated['status'] === 'published' && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            // Create the news
            News::create($validated);

            return redirect()->route('admin.news.index')
                ->with('message', 'Berita berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(News $news): Response
    {
        // dd($news);
        // Load relationships
        $news->load(['category', 'author']);

        // Convert tags array to string for form
        if (is_array($news->tags)) {
            $news->tags_string = implode(', ', $news->tags);
        } else {
            $news->tags_string = '';
        }

        return Inertia::render('Admin/News/Edit', [
            'news' => $news,
            'categories' => NewsCategory::where('is_active', true)->get(),
            'authors' => Team::where('is_active', true)->get()
        ]);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    'unique:news,title,' . $news->id
                ],
                'excerpt' => [
                    'required',
                    'string',
                    'min:20',
                    'max:500'
                ],
                'content' => [
                    'required',
                    'string',
                    'min:50'
                ],
                'featured_image' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048'
                ],
                'category_id' => [
                    'required',
                    'exists:news_categories,id'
                ],
                'author_id' => [
                    'nullable',
                    'exists:teams,id'
                ],
                'status' => [
                    'required',
                    'in:draft,published,archived'
                ],
                'published_at' => [
                    'nullable',
                    'date'
                ],
                'is_featured' => [
                    'boolean'
                ],
                'tags' => [
                    'nullable',
                    'string',
                    'max:500'
                ],
                'meta_title' => [
                    'nullable',
                    'string',
                    'max:60'
                ],
                'meta_description' => [
                    'nullable',
                    'string',
                    'max:160'
                ]
            ], [
                // Same custom error messages as store method
                'title.required' => 'Judul berita wajib diisi.',
                'title.min' => 'Judul berita minimal 5 karakter.',
                'title.max' => 'Judul berita maksimal 255 karakter.',
                'title.unique' => 'Judul berita sudah digunakan.',

                'excerpt.required' => 'Ringkasan berita wajib diisi.',
                'excerpt.min' => 'Ringkasan berita minimal 20 karakter.',
                'excerpt.max' => 'Ringkasan berita maksimal 500 karakter.',

                'content.required' => 'Konten berita wajib diisi.',
                'content.min' => 'Konten berita minimal 50 karakter.',

                'featured_image.image' => 'File harus berupa gambar.',
                'featured_image.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
                'featured_image.max' => 'Ukuran gambar maksimal 2MB.',

                'category_id.required' => 'Kategori berita wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',

                'author_id.exists' => 'Penulis yang dipilih tidak valid.',

                'status.required' => 'Status berita wajib dipilih.',
                'status.in' => 'Status berita tidak valid.',

                'published_at.date' => 'Format tanggal publikasi tidak valid.',

                'tags.max' => 'Tags maksimal 500 karakter.',
                'meta_title.max' => 'Meta title maksimal 60 karakter.',
                'meta_description.max' => 'Meta description maksimal 160 karakter.',
            ]);

            // Update slug if title changed
            if ($validated['title'] !== $news->title) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                try {
                    // Delete old image
                    if ($news->featured_image) {
                        $this->deleteImage($news->featured_image);
                    }
                    $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
                } catch (\Exception $e) {
                    Log::error('Image upload failed during update: ' . $e->getMessage());
                    return back()->withErrors(['featured_image' => 'Gagal mengunggah gambar.'])->withInput();
                }
            } else {
                // Keep existing image
                unset($validated['featured_image']);
            }

            $validated['is_featured'] = $request->boolean('is_featured', false);

            // Convert tags string to array if provided
            if (!empty($validated['tags'])) {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            } else {
                $validated['tags'] = [];
            }

            // Set published_at if status changed to published
            if ($validated['status'] === 'published' && $news->status !== 'published' && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            $news->update($validated);

            return redirect()->route('admin.news.index')
                ->with('message', 'Berita berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating news: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(News $news): RedirectResponse
    {
        try {
            // Delete associated image
            if ($news->featured_image) {
                $this->deleteImage($news->featured_image);
            }

            $news->delete();

            // Pastikan redirect ke route yang benar
            return redirect()->route('admin.news.index')
                ->with('message', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting news: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Upload image to public/storage/assets/img/news/
     */
    private function uploadImage($file): string
    {
        try {
            // Create directory if not exists
            $uploadPath = public_path('storage/assets/img/news');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $filename = 'news_' . time() . '_' . uniqid() . '.' . $extension;

            // Move file to destination
            $file->move($uploadPath, $filename);

            // Return relative path for database storage
            return 'assets/img/news/' . $filename;
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            throw new \Exception('Gagal mengunggah gambar: ' . $e->getMessage());
        }
    }

    /**
     * Delete image from public directory
     */
    private function deleteImage(?string $imagePath): void
    {
        try {
            if ($imagePath) {
                $fullPath = public_path('storage/' . $imagePath);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        } catch (\Exception $e) {
            Log::error('Image deletion error: ' . $e->getMessage());
            // Don't throw exception for deletion errors, just log them
        }
    }
}
