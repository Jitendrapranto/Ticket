<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventCategory;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Music',
                'icon' => 'fas fa-music',
                'description' => 'From underground jazz clubs to stadium rock concerts.',
                'slug' => 'music'
            ],
            [
                'name' => 'Sports',
                'icon' => 'fas fa-trophy',
                'description' => 'Live tournaments, championships, and athletic showdowns.',
                'slug' => 'sports'
            ],
            [
                'name' => 'Cinema',
                'icon' => 'fas fa-film',
                'description' => 'Exclusive premieres, film festivals, and director screenings.',
                'slug' => 'cinema'
            ],
            [
                'name' => 'Theater',
                'icon' => 'fas fa-theater-masks',
                'description' => 'Broadway hits, indie plays, and performance arts.',
                'slug' => 'theater'
            ],
            [
                'name' => 'Lifestyle',
                'icon' => 'fas fa-glass-cheers',
                'description' => 'Gala dinners, fashion shows, and wellness retreats.',
                'slug' => 'lifestyle'
            ],
        ];

        foreach ($categories as $category) {
            EventCategory::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
