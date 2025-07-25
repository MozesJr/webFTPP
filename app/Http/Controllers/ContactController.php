<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\ContactMessage;
use App\Http\Requests\ContactMessageRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact', [
            'contactInfos' => ContactInfo::active()
                ->ordered()
                ->get()
                ->groupBy('type')
        ]);
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan merespons segera.');
    }
}
