<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactHero;
use Illuminate\Http\Request;

class ContactHeroController extends Controller
{
    public function edit()
    {
        $hero = ContactHero::firstOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'CONTACT CENTER',
                'title_main' => 'Get In',
                'title_accent' => 'Touch.',
                'subtitle' => 'Have a question or need assistance with your booking? Our dedicated support team is available 24/7 to ensure your experience is flawless.',
            ]
        );

        return view('admin.contact.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge_text' => 'required|string|max:100',
            'title_main' => 'required|string|max:255',
            'title_accent' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
        ]);

        $hero = ContactHero::first();
        $hero->update($request->all());

        return redirect()->route('admin.contact.hero.edit')->with('success', 'Contact Hero section updated successfully!');
    }
}
