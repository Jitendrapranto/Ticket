<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutStory;
use Illuminate\Http\Request;

class AboutStoryController extends Controller
{
    public function edit()
    {
        $story = AboutStory::firstOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'OUR STORY',
                'title_main' => 'Reimagining the',
                'title_highlight' => 'Fan Journey',
                'card_1_icon' => 'fas fa-fire',
                'card_1_bg_color' => '#f0f5ff',
                'card_1_icon_color' => 'bg-blue-500',
                'card_2_icon' => 'fas fa-heart',
                'card_2_bg_color' => '#fff0f2',
                'card_2_icon_color' => 'bg-rose-500',
            ]
        );

        return view('admin.about.story', compact('story'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|string',
            'badge_text' => 'required|string|max:100',
            'title_main' => 'required|string|max:255',
            'title_highlight' => 'required|string|max:255',
            'paragraph_1' => 'nullable|string',
            'paragraph_2' => 'nullable|string',
            'card_1_title' => 'required|string|max:100',
            'card_1_description' => 'required|string',
            'card_1_icon' => 'required|string|max:50',
            'card_1_bg_color' => 'required|string|max:20',
            'card_1_icon_color' => 'required|string|max:50',
            'card_2_title' => 'required|string|max:100',
            'card_2_description' => 'required|string',
            'card_2_icon' => 'required|string|max:50',
            'card_2_bg_color' => 'required|string|max:20',
            'card_2_icon_color' => 'required|string|max:50',
        ]);

        $story = AboutStory::firstOrFail();

        $data = $request->except(['_token', '_method', 'image_file']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('about', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $story->update($data);

        return redirect()->route('admin.about.story.edit')->with('success', 'Our Story section updated successfully!');
    }
}
