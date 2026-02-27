<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCta;
use Illuminate\Http\Request;

class AboutCtaController extends Controller
{
    public function edit()
    {
        $cta = AboutCta::first();
        if (!$cta) {
            $cta = AboutCta::create([
                'title' => 'Ready to partner?',
                'subtitle' => 'Join our global network of organizers and bring your events to millions.',
                'button_text' => 'CONTACT US TODAY',
                'button_url' => '/contact',
            ]);
        }
        return view('admin.about.cta', compact('cta'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string|max:255',
        ]);

        $cta = AboutCta::first();
        $cta->update($request->all());

        return redirect()->route('admin.about.cta.edit')->with('success', 'CTA Section updated successfully!');
    }
}
