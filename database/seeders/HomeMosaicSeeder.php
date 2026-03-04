<?php

namespace Database\Seeders;

use App\Models\HomeGallerySection;
use App\Models\HomeMosaicImage;
use Illuminate\Database\Seeder;

class HomeMosaicSeeder extends Seeder
{
    public function run(): void
    {
        HomeGallerySection::firstOrCreate(
            ['id' => 1],
            [
                'title'       => 'Moments That Stick Forever',
                'description' => 'Browse through thousands of captured memories from our global community of event lovers.',
                'button_text' => 'OPEN GALLERY',
                'button_url'  => '/gallery',
            ]
        );

        $images = [
            [
                'image_path' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'caption'    => 'Neon World Tour Final',
                'span'       => '2x2',
                'sort_order' => 1,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'caption'    => 'Light Trails',
                'span'       => '1x1',
                'sort_order' => 2,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'caption'    => 'Festival Energy',
                'span'       => '1x1',
                'sort_order' => 3,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1472653425572-ca97664ff3AD?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'caption'    => 'Experience The Unseen',
                'span'       => '2x1',
                'sort_order' => 4,
            ],
        ];

        foreach ($images as $img) {
            HomeMosaicImage::firstOrCreate(
                ['image_path' => $img['image_path']],
                array_merge($img, ['is_active' => true])
            );
        }
    }
}
