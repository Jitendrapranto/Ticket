<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactSupportController extends Controller
{
    public function edit()
    {
        $support = ContactSupport::firstOrCreate(
            ['id' => 1],
            [
                'badge_text' => '24 / 7 SUPPORT',
                'email' => 'support@ticketkinun.com',
                'phone' => '+880 1234 567 890',
                'address' => 'Gulshan-2, Dhaka, Bangladesh',
                'card_title' => 'Dedicated Support Team',
                'card_description' => 'Our specialists handle every request with precision and care. You\'re in good hands.',
                'image' => 'https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'call_url' => 'tel:+8801234567890',
                'whatsapp_url' => 'https://wa.me/8801234567890',
            ]
        );

        return view('admin.contact.support', compact('support'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge_text' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'card_title' => 'required|string|max:255',
            'card_description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|string',
            'call_url' => 'nullable|string',
            'whatsapp_url' => 'nullable|string',
        ]);

        $support = ContactSupport::first();
        $data = $request->only([
            'badge_text', 'email', 'phone', 'address', 'card_title', 'card_description', 'call_url', 'whatsapp_url'
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('contact', 'public');
            $data['image'] = Storage::url($path);
        } elseif ($request->image_url) {
            $data['image'] = $request->image_url;
        }

        $support->update($data);

        return redirect()->route('admin.contact.support.edit')->with('success', 'Support section updated successfully!');
    }
}
