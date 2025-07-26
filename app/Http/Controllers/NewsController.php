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
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->paginate(12);

        // Ensure featured news has proper relationships loaded
        $featuredNews = News::published()
            ->featured()
            ->with(['category', 'author'])
            ->take(3)
            ->get();

        $data = [
            'news' => $news,
            'categories' => NewsCategory::where('is_active', true)->get(),
            'featuredNews' => $featuredNews,
            'filters' => $request->only(['category', 'search'])
        ];

        return Inertia::render('News/Index', $data);
    }

    public function show(News $news): Response
    {
        // Increment views dengan session check untuk mencegah spam
        $this->incrementViews($news);

        // Load relationships
        $news->load([
            'category',
            'author' => function ($query) {
                $query->with('position');
            }
        ]);

        // Get related news (same category)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        // Get latest news for sidebar
        $latestNews = News::published()
            ->where('id', '!=', $news->id)
            ->with(['category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return Inertia::render('News/Show', [
            'news' => $news,
            'relatedNews' => $relatedNews,
            'latestNews' => $latestNews
        ]);
    }

    /**
     * Increment views count dengan session check
     */
    private function incrementViews(News $news)
    {
        $sessionKey = 'news_viewed_' . $news->id;

        if (!session()->has($sessionKey)) {
            $news->increment('views_count');
            session()->put($sessionKey, true);

            // Set session expire after 1 hour
            session()->put($sessionKey . '_time', now()->addHour());
        }
    }
}
