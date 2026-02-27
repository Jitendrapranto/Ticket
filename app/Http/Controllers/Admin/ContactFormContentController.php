<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactFormContent;
use Illuminate\Http\Request;

class ContactFormContentController extends Controller
{
    public function edit()
    {
        $content = ContactFormContent::firstOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'SEND A MESSAGE',
                'title' => 'Drop Us A Line.',
                'description' => 'Fill out the form and our team will get back to you within 2 hours.',
                'button_text' => 'SEND MESSAGE',
                'name_label' => 'FULL NAME',
                'name_placeholder' => 'John Doe',
                'email_label' => 'EMAIL ADDRESS',
                'email_placeholder' => 'john@example.com',
                'phone_label' => 'PHONE NUMBER',
                'phone_placeholder' => '+880 1234 567 890',
                'subject_label' => 'SUBJECT',
                'message_label' => 'YOUR MESSAGE',
                'message_placeholder' => 'How can we help you today?',
            ]
        );

        return view('admin.contact.form_content', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge_text' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'required|string|max:100',
            'name_label' => 'required|string|max:100',
            'name_placeholder' => 'required|string|max:255',
            'email_label' => 'required|string|max:100',
            'email_placeholder' => 'required|string|max:255',
            'phone_label' => 'required|string|max:100',
            'phone_placeholder' => 'required|string|max:255',
            'subject_label' => 'required|string|max:100',
            'message_label' => 'required|string|max:100',
            'message_placeholder' => 'required|string',
        ]);

        $content = ContactFormContent::first();
        $content->update($request->all());

        return redirect()->route('admin.contact.form.edit')->with('success', 'Contact Form content updated successfully!');
    }
}
