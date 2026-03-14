<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteFooterController extends Controller
{
    public function edit()
    {
        $footer = SiteFooter::first();
        return view('admin.site.footer', compact('footer'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'logo'               => 'nullable|image|max:5120',
            'description'        => 'nullable|string',
            'facebook_url'       => 'nullable|string|max:255',
            'twitter_url'        => 'nullable|string|max:255',
            'instagram_url'      => 'nullable|string|max:255',
            'linkedin_url'       => 'nullable|string|max:255',
            'explorer_title'     => 'required|string|max:100',
            'explorer_links'     => 'nullable|array',
            'explorer_links.*.label' => 'required|string|max:100',
            'explorer_links.*.url'   => 'required|string|max:255',
            'collections_title'  => 'required|string|max:100',
            'collections_items'  => 'nullable|array',
            'collections_items.*.label' => 'required|string|max:100',
            'contact_title'      => 'required|string|max:100',
            'contact_email'      => 'nullable|string|max:255',
            'contact_phone'      => 'nullable|string|max:50',
            'contact_address'    => 'nullable|string|max:255',
            'copyright_text'     => 'nullable|string|max:500',
            'privacy_url'        => 'nullable|string|max:255',
            'terms_url'          => 'nullable|string|max:255',
            'cookies_url'        => 'nullable|string|max:255',
        ]);

        $footer = SiteFooter::firstOrNew();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('site', 'public');
            $footer->logo_path = $path;
        }

        $footer->description        = $data['description'];
        $footer->facebook_url       = $data['facebook_url'];
        $footer->twitter_url        = $data['twitter_url'];
        $footer->instagram_url      = $data['instagram_url'];
        $footer->linkedin_url       = $data['linkedin_url'];
        $footer->explorer_title     = $data['explorer_title'];
        $footer->explorer_links     = $data['explorer_links'] ?? [];
        $footer->collections_title  = $data['collections_title'];
        $footer->collections_items  = $data['collections_items'] ?? [];
        $footer->contact_title      = $data['contact_title'];
        $footer->contact_email      = $data['contact_email'];
        $footer->contact_phone      = $data['contact_phone'];
        $footer->contact_address    = $data['contact_address'];
        $footer->copyright_text     = $data['copyright_text'];
        $footer->privacy_url        = $data['privacy_url'];
        $footer->terms_url          = $data['terms_url'];
        $footer->cookies_url        = $data['cookies_url'];
        $footer->save();

        Cache::forget('site_footer');

        return redirect()->route('admin.site.footer.edit')
            ->with('success', 'Footer content updated successfully!');
    }
}
