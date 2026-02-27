<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutAdvantage;
use Illuminate\Http\Request;

class AboutAdvantageController extends Controller
{
    public function index()
    {
        $advantages = AboutAdvantage::orderBy('sort_order', 'asc')->get();
        return view('admin.about.advantages.index', compact('advantages'));
    }

    public function create()
    {
        return view('admin.about.advantages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'card_bg_color' => 'required|string|max:20',
            'icon_bg_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'desc_color' => 'required|string|max:20',
            'border_class' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        AboutAdvantage::create($request->all());

        return redirect()->route('admin.about.advantages.index')->with('success', 'Advantage created successfully!');
    }

    public function edit(AboutAdvantage $advantage)
    {
        return view('admin.about.advantages.edit', compact('advantage'));
    }

    public function update(Request $request, AboutAdvantage $advantage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'card_bg_color' => 'required|string|max:20',
            'icon_bg_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'desc_color' => 'required|string|max:20',
            'border_class' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $advantage->update($request->all());

        return redirect()->route('admin.about.advantages.index')->with('success', 'Advantage updated successfully!');
    }

    public function destroy(AboutAdvantage $advantage)
    {
        $advantage->delete();
        return redirect()->route('admin.about.advantages.index')->with('success', 'Advantage deleted successfully!');
    }
}
