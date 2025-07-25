<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = News::published()
            ->with(['category', 'author'])
            ->latest('published_at');

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->paginate(12);

        return Inertia::render('News/Index', [
            'news' => $news,
            'categories' => NewsCategory::active()->get(),
            'featuredNews' => News::published()->featured()->take(3)->get(),
            'filters' => $request->only(['category', 'search'])
        ]);
    }

    public function show(News $news): Response
    {
        // Increment views
        $news->incrementViews();

        $news->load(['category', 'author.position']);

        return Inertia::render('News/Show', [
            'news' => $news,
            'relatedNews' => News::published()
                ->where('id', '!=', $news->id)
                ->where('category_id', $news->category_id)
                ->take(4)
                ->get(),
            'latestNews' => News::published()
                ->where('id', '!=', $news->id)
                ->latest('published_at')
                ->take(5)
                ->get()
        ]);
    }
}
