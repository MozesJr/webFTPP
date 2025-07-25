<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Team;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = News::with(['category', 'author']);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $news = $query->latest()->paginate(10);

        return Inertia::render('Admin/News/Index', [
            'news' => $news,
            'categories' => NewsCategory::active()->get(),
            'filters' => $request->only(['search', 'category', 'status'])
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/News/Create', [
            'categories' => NewsCategory::active()->get(),
            'authors' => Team::active()->get()
        ]);
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        // Set published_at if status is published
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(News $news): Response
    {
        $news->load(['category', 'author']);

        return Inertia::render('Admin/News/Show', [
            'news' => $news
        ]);
    }

    public function edit(News $news): Response
    {
        return Inertia::render('Admin/News/Edit', [
            'news' => $news,
            'categories' => NewsCategory::active()->get(),
            'authors' => Team::active()->get()
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        // Set published_at if status changed to published
        if ($data['status'] === 'published' && $news->status !== 'published') {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
