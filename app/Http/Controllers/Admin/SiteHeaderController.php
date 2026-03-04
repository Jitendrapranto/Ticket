<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteHeader;
use Illuminate\Http\Request;

class SiteHeaderController extends Controller
{
    public function edit()
    {
        $header = SiteHeader::first();
        return view('admin.site.header', compact('header'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'logo'               => 'nullable|image|max:5120',
            'search_placeholder' => 'required|string|max:255',
            'login_text'         => 'required|string|max:50',
            'signup_text'        => 'required|string|max:50',
            'nav_links'          => 'nullable|array',
            'nav_links.*.label'  => 'required|string|max:50',
            'nav_links.*.url'    => 'required|string|max:255',
        ]);

        $header = SiteHeader::firstOrNew();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('site', 'public');
            $header->logo_path = $path;
        }

        $header->search_placeholder = $data['search_placeholder'];
        $header->login_text          = $data['login_text'];
        $header->signup_text         = $data['signup_text'];
        $header->nav_links           = $data['nav_links'] ?? [];
        $header->save();

        return redirect()->route('admin.site.header.edit')
            ->with('success', 'Header content updated successfully!');
    }
}
