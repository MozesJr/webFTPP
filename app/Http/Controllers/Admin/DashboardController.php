<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use App\Models\Team;
use App\Models\News;
use App\Models\Event;
use App\Models\ContactMessage;
use App\Models\Stats;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_program_studis' => ProgramStudi::active()->count(),
                'total_teams' => Team::active()->count(),
                'total_news' => News::published()->count(),
                'upcoming_events' => Event::upcoming()->count(),
                'unread_messages' => ContactMessage::unread()->count(),
            ],
            'recentNews' => News::with(['category', 'author'])
                ->latest()
                ->take(5)
                ->get(),
            'recentMessages' => ContactMessage::latest()
                ->take(5)
                ->get(),
            'upcomingEvents' => Event::upcoming()
                ->with('programStudi')
                ->take(5)
                ->get(),
            'currentStats' => Stats::current()->first()
        ]);
    }
}
