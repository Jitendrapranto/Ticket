<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutStory;

class AboutStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutStory::updateOrCreate(
            ['id' => 1],
            [
                'badge_text' => 'OUR STORY',
                'title_main' => 'Reimagining the',
                'title_highlight' => 'Fan Journey',
                'paragraph_1' => 'We founded Ticket Kinun with a simple mission: to bridge the gap between complex event logistics and the pure joy of the experience.',
                'paragraph_2' => 'Today, we empower thousands of organizers and millions of fans with a platform that prioritizes speed, security, and style above all else.',
                'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'card_1_icon' => 'fas fa-fire',
                'card_1_bg_color' => '#f0f5ff',
                'card_1_icon_color' => 'bg-blue-500',
                'card_1_title' => 'Passion',
                'card_1_description' => 'What drives us to build the best experience.',
                'card_2_icon' => 'fas fa-heart',
                'card_2_bg_color' => '#fff0f2',
                'card_2_icon_color' => 'bg-rose-500',
                'card_2_title' => 'Community',
                'card_2_description' => 'More than just a platform, it is a movement.',
            ]
        );
    }
}
