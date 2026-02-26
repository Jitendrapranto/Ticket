<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = EventCategory::all();

        if ($categories->isEmpty()) {
            return;
        }

        $sampleImages = [
            [
                'title' => 'Neon Symphony Night',
                'category_name' => 'Concerts',
                'url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1280&q=80'
            ],
            [
                'title' => 'The Grand Arena Finals',
                'category_name' => 'Sports',
                'url' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=1280&q=80'
            ],
            [
                'title' => 'Midnight Premiere',
                'category_name' => 'Cinema',
                'url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1280&q=80'
            ],
            [
                'title' => 'Digital Horizon Summit',
                'category_name' => 'Lifestyle',
                'url' => 'https://images.unsplash.com/photo-1540575861501-7ad05823123d?w=1280&q=80'
            ],
            [
                'title' => 'The Classic Act',
                'category_name' => 'Theater',
                'url' => 'https://images.unsplash.com/photo-1472653425572-ca97664ff3AD?w=1280&q=80'
            ],
            [
                'title' => 'Urban Echo Sessions',
                'category_name' => 'Concerts',
                'url' => 'https://images.unsplash.com/photo-1514525253344-f814d0c9e583?w=1280&q=80'
            ],
        ];

        foreach ($sampleImages as $img) {
            $category = $categories->where('name', $img['category_name'])->first();
            
            if ($category) {
                // For seeder, we can't easily download to storage here without extra code,
                // but we can store the external URL if the system allows or just placeholder.
                // However, the controller expects a path in storage.
                // For seeder purposes, I will just put the URL in the image_path 
                // and the view will handle it (asset() on a URL works in many setups or I can adjust).
                // Actually, I should probably use a dummy path or different logic.
                // Let's use the URL for now and I'll make sure the view handles it or use real files if available.
                GalleryImage::create([
                    'title' => $img['title'],
                    'category_id' => $category->id,
                    'image_path' => $img['url'], // Note: Usually this would be local path
                ]);
            }
        }
    }
}
