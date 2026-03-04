<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeGallerySection;
use App\Models\HomeMosaicImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeMosaicController extends Controller
{
    public function index()
    {
        $section = HomeGallerySection::first();
        $images  = HomeMosaicImage::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.home.mosaic.index', compact('section', 'images'));
    }

    public function updateSection(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'required|string|max:100',
            'button_url'  => 'required|string|max:255',
        ]);

        $section = HomeGallerySection::first();
        if ($section) {
            $section->update($data);
        } else {
            HomeGallerySection::create($data);
        }

        return redirect()->route('admin.home.mosaic.index')
            ->with('success', 'Gallery section updated successfully!');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'image'      => 'required|image|max:5120',
            'caption'    => 'nullable|string|max:255',
            'span'       => 'in:1x1,2x1,1x2,2x2',
            'sort_order' => 'integer|min:0',
        ]);

        $path = $request->file('image')->store('mosaic', 'public');

        HomeMosaicImage::create([
            'image_path' => $path,
            'caption'    => $request->caption,
            'span'       => $request->span ?? '1x1',
            'is_active'  => true,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.home.mosaic.index')
            ->with('success', 'Mosaic image added successfully!');
    }

    public function destroyImage(HomeMosaicImage $image)
    {
        if ($image->image_path && !str_starts_with($image->image_path, 'http')) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return redirect()->route('admin.home.mosaic.index')
            ->with('success', 'Image removed from the gallery mosaic.');
    }
}
