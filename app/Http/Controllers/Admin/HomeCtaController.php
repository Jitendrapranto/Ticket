<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCtaSection;
use Illuminate\Http\Request;

class HomeCtaController extends Controller
{
    public function edit()
    {
        $cta = HomeCtaSection::first();
        return view('admin.home.cta.edit', compact('cta'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'heading'           => 'required|string|max:255',
            'heading_highlight' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'button_text'       => 'required|string|max:100',
            'button_url'        => 'required|string|max:255',
            'button_bg_color'   => 'required|string|max:20',
            'button_text_color' => 'required|string|max:20',
            'bg_image_url'      => 'nullable|url|max:500',
        ]);

        $cta = HomeCtaSection::first();
        if ($cta) {
            $cta->update($data);
        } else {
            HomeCtaSection::create($data);
        }

        return redirect()->route('admin.home.cta.edit')
            ->with('success', 'CTA section updated successfully!');
    }
}
