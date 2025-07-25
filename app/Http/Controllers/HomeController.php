<?php
// app/Http/Controllers/HomeController.php - FIXED VERSION

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\About;
use App\Models\Stats;
use App\Models\ProgramStudi;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        try {
            // Fetch data with fallbacks
            $hero = HeroSection::where('is_active', true)->first();
            $about = About::where('is_active', true)->first();
            $stats = Stats::where('is_current', true)->first();

            // Program Studi dengan fallback
            $programStudis = ProgramStudi::where('is_active', true)
                ->with(['features' => function ($query) {
                    $query->where('is_active', true)->orderBy('order_index');
                }])
                ->take(6)
                ->get();

            // Clients dengan fallback
            $clients = Client::where('is_active', true)
                ->orderBy('order_index')
                ->get();

            // Testimonials dengan fallback
            $testimonials = Testimonial::where('is_active', true)
                ->where('is_featured', true)
                ->with('programStudi')
                ->take(6)
                ->get();

            // Latest News dengan fallback
            $latestNews = News::where('status', 'published')
                ->where('published_at', '<=', now())
                ->with(['category', 'author'])
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();

            // Upcoming Events dengan fallback
            $upcomingEvents = Event::where('status', 'upcoming')
                ->where('event_date', '>=', now())
                ->with('programStudi')
                ->take(3)
                ->get();

            // Gallery dengan fallback
            $gallery = Gallery::where('is_active', true)
                ->orderBy('event_date', 'desc')
                ->take(8)
                ->get();

            // Site Settings dengan fallback
            $siteSettings = [
                'site_title' => SiteSetting::get('site_title', 'Fakultas Website'),
                'site_description' => SiteSetting::get('site_description', 'Official Faculty Website'),
                'contact_email' => SiteSetting::get('contact_email', 'info@fakultas.ac.id'),
                'contact_phone' => SiteSetting::get('contact_phone', '+62 21 1234567'),
                'facebook_url' => SiteSetting::get('facebook_url', ''),
                'instagram_url' => SiteSetting::get('instagram_url', ''),
                'youtube_url' => SiteSetting::get('youtube_url', ''),
                // 'testimoni_back' => SiteSetting::get('testimoni_back', ''),
                'testimoni_back' => '/storage/assets/img/imgBg1.jpg',
            ];
            $data = [
                'hero' => $hero,
                'about' => $about,
                'stats' => $stats,
                'programStudis' => $programStudis,
                'clients' => $clients,
                'testimonials' => $testimonials,
                'latestNews' => $latestNews,
                'upcomingEvents' => $upcomingEvents,
                'gallery' => $gallery,
                'siteSettings' => $siteSettings
            ];

            // dd($data);
            return Inertia::render('Home', $data);
        } catch (\Exception $e) {
            // Fallback jika ada error
            return Inertia::render('Home', [
                'hero' => null,
                'about' => null,
                'stats' => null,
                'programStudis' => collect([]),
                'clients' => collect([]),
                'testimonials' => collect([]),
                'latestNews' => collect([]),
                'upcomingEvents' => collect([]),
                'gallery' => collect([]),
                'siteSettings' => [
                    'site_title' => 'Fakultas Website',
                    'site_description' => 'Official Faculty Website',
                    'contact_email' => 'info@fakultas.ac.id',
                    'contact_phone' => '+62 21 1234567',
                    'facebook_url' => '',
                    'instagram_url' => '',
                    'youtube_url' => '',
                ]
            ]);
        }
    }
}
