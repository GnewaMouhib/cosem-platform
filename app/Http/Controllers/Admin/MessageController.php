<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactsMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactsMessage::latest()->paginate(15),
            'unreadCount' => ContactsMessage::where('is_read', false)->count(),
        ]);
    }

    public function show(ContactsMessage $message): View
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', ['message' => $message]);
    }

    public function toggleRead(ContactsMessage $message): RedirectResponse
    {
        $message->update(['is_read' => ! $message->is_read]);

        $status = $message->is_read ? 'marqué comme lu' : 'marqué comme non lu';

        return back()->with('success', "Message {$status}.");
    }

    public function destroy(ContactsMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message supprimé avec succès.');
    }
}
