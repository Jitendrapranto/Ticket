<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::with('category')->latest()->paginate(12);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:event_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'image_path' => $imagePath,
            'show_on_homepage' => $request->input('show_on_homepage', 0) ? true : false,
            'homepage_sort_order' => $request->input('homepage_sort_order', 0),
        ]);

        return redirect()->route('admin.gallery.images.index')->with('success', 'Image added to gallery successfully!');
    }

    public function destroy(GalleryImage $image)
    {
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return back()->with('success', 'Image removed from gallery!');
    }

    public function toggleHomepage(GalleryImage $image)
    {
        $image->show_on_homepage = !$image->show_on_homepage;
        $image->save();

        $status = $image->show_on_homepage ? 'added to' : 'removed from';
        return back()->with('success', "Image \"{$image->title}\" has been {$status} the homepage gallery!");
    }

    public function edit(GalleryImage $image)
    {
        $categories = EventCategory::all();
        return view('admin.gallery.edit', compact('image', 'categories'));
    }

    public function update(Request $request, GalleryImage $image)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:event_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->image_path = $request->file('image')->store('gallery', 'public');
        }

        $image->title = $request->title;
        $image->category_id = $request->category_id;
        $image->show_on_homepage = $request->input('show_on_homepage', 0) ? true : false;
        $image->homepage_sort_order = $request->input('homepage_sort_order', 0);
        $image->save();

        return redirect()->route('admin.gallery.images.index')->with('success', 'Image updated successfully!');
    }
}
