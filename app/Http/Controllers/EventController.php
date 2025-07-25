<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Event::with('programStudi');

        // Filter by status
        $status = $request->status ?? 'upcoming';
        if ($status === 'upcoming') {
            $query->upcoming();
        } elseif ($status === 'completed') {
            $query->completed();
        }

        // Filter by program studi
        if ($request->prodi) {
            $query->where('prodi_id', $request->prodi);
        }

        $events = $query->latest('event_date')->paginate(12);

        return Inertia::render('Events/Index', [
            'events' => $events,
            'programStudis' => ProgramStudi::active()->get(),
            'featuredEvents' => Event::upcoming()->featured()->take(3)->get(),
            'filters' => $request->only(['status', 'prodi'])
        ]);
    }

    public function show(Event $event): Response
    {
        $event->load('programStudi');

        return Inertia::render('Events/Show', [
            'event' => $event,
            'relatedEvents' => Event::upcoming()
                ->where('id', '!=', $event->id)
                ->when($event->prodi_id, function ($query) use ($event) {
                    $query->where('prodi_id', $event->prodi_id);
                })
                ->take(4)
                ->get()
        ]);
    }
}
