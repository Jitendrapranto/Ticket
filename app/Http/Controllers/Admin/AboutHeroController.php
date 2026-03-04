<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutHero;
use Illuminate\Http\Request;

class AboutHeroController extends Controller
{
    public function edit()
    {
        $hero = AboutHero::firstOrCreate(
            ['id' => 1],
            [
                'badge_text'  => 'ABOUT US',
                'title_main'  => 'The Story',
                'title_accent' => 'Behind Kinun.',
                'subtitle'    => 'We are a passionate team dedicated to transforming the way the world experiences live events. From stadium concerts to intimate theatre shows, Ticket Kinun is your trusted partner.',
            ]
        );

        return view('admin.about.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge_text'   => 'required|string|max:100',
            'title_main'   => 'required|string|max:255',
            'title_accent' => 'required|string|max:255',
            'subtitle'     => 'nullable|string',
        ]);

        $hero = AboutHero::firstOrCreate(['id' => 1]);
        $hero->update($request->only('badge_text', 'title_main', 'title_accent', 'subtitle'));

        return redirect()->route('admin.about.hero.edit')->with('success', 'About Hero section updated successfully.');
    }
}
