<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryHero;

class GalleryHeroController extends Controller
{
    public function edit()
    {
        $hero = GalleryHero::first() ?? new GalleryHero([
            'badge_text' => 'VISUAL JOURNEY',
            'title' => 'Moments In Motion.',
            'subtitle' => 'Step inside the most exclusive events. Explore our collection of captured memories, from high-energy concerts to elite sports finals.'
        ]);
        return view('admin.gallery.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
        ]);

        GalleryHero::updateOrCreate(
            ['id' => 1],
            $request->only(['title', 'badge_text', 'subtitle'])
        );

        return back()->with('success', 'Gallery Hero section updated successfully!');
    }
}
