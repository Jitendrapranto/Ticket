<?php

namespace Database\Seeders;

use App\Models\GalleryHero;
use Illuminate\Database\Seeder;

class GalleryHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryHero::updateOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'VISUAL JOURNEY',
                'title' => 'Moments In Motion.',
                'subtitle' => 'Step inside the most exclusive events. Explore our collection of captured memories, from high-energy concerts to elite sports finals.',
            ]
        );
    }
}
