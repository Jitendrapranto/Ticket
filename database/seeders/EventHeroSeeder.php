<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventHero;

class EventHeroSeeder extends Seeder
{
    public function run(): void
    {
        EventHero::updateOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'Visual Journey',
                'title' => 'Where Every Moment becomes a Legacy.',
                'subtitle' => 'Step into the pulse of the world. From legendary arenas to clandestine jazz clubs, discover experiences that define generations.',
                'search_placeholder' => 'Hunt for concerts, stadiums, or secret shows...'
            ]
        );
    }
}
