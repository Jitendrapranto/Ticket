<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = \App\Models\ContactMessage::latest()->paginate(15);
        return view('admin.contact.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('admin.contact.messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->delete();
        return redirect()->route('admin.contact.messages.index')->with('success', 'Message deleted successfully.');
    }
}
