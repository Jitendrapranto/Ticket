<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($validated);

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }
}
