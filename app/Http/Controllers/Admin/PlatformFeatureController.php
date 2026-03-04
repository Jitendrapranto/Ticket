<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformFeature;
use Illuminate\Http\Request;

class PlatformFeatureController extends Controller
{
    public function index()
    {
        $features = PlatformFeature::orderBy('sort_order')->get();
        return view('admin.home.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.home.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon'         => 'required|string|max:100',
            'title'        => 'required|string|max:150',
            'description'  => 'required|string|max:500',
            'action_label' => 'required|string|max:80',
            'card_bg'      => 'required|string|max:20',
            'icon_bg'      => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'border_color' => 'required|string|max:20',
            'sort_order'   => 'nullable|integer',
        ]);

        PlatformFeature::create(array_merge($request->all(), [
            'is_active'  => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]));

        return redirect()->route('admin.home.features.index')
            ->with('success', 'Feature card created successfully!');
    }

    public function edit(PlatformFeature $feature)
    {
        return view('admin.home.features.edit', compact('feature'));
    }

    public function update(Request $request, PlatformFeature $feature)
    {
        $request->validate([
            'icon'         => 'required|string|max:100',
            'title'        => 'required|string|max:150',
            'description'  => 'required|string|max:500',
            'action_label' => 'required|string|max:80',
            'card_bg'      => 'required|string|max:20',
            'icon_bg'      => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'border_color' => 'required|string|max:20',
            'sort_order'   => 'nullable|integer',
        ]);

        $feature->update(array_merge($request->all(), [
            'is_active'  => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]));

        return redirect()->route('admin.home.features.index')
            ->with('success', 'Feature card updated successfully!');
    }

    public function destroy(PlatformFeature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.home.features.index')
            ->with('success', 'Feature card deleted successfully!');
    }
}
