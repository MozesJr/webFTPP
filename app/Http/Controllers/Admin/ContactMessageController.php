<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ContactMessage::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->latest()->paginate(10);

        return Inertia::render('Admin/ContactMessages/Index', [
            'messages' => $messages,
            'filters' => $request->only(['status', 'search'])
        ]);
    }

    public function show(ContactMessage $contactMessage): Response
    {
        // Mark as read
        if ($contactMessage->status === 'unread') {
            $contactMessage->markAsRead();
        }

        return Inertia::render('Admin/ContactMessages/Show', [
            'message' => $contactMessage
        ]);
    }

    public function update(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'admin_notes' => $request->admin_notes,
            'status' => $request->status
        ]);

        if ($request->status === 'replied') {
            $contactMessage->markAsReplied();
        }

        return redirect()->back()
            ->with('success', 'Status pesan berhasil diupdate.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
