<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EventHero;

class EventHeroController extends Controller
{
    public function edit()
    {
        $hero = EventHero::first() ?? new EventHero([
            'title' => 'Find Your Next Experience',
            'search_placeholder' => 'Search events, venues, or cities...'
        ]);
        return view('admin.events.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'search_placeholder' => 'nullable|string|max:255',
        ]);

        EventHero::updateOrCreate(
            ['id' => 1],
            $request->only(['title', 'badge_text', 'subtitle', 'search_placeholder'])
        );

        return back()->with('success', 'Hero section updated successfully!');
    }
}
