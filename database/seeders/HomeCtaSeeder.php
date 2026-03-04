<?php

namespace Database\Seeders;

use App\Models\HomeCtaSection;
use Illuminate\Database\Seeder;

class HomeCtaSeeder extends Seeder
{
    public function run(): void
    {
        HomeCtaSection::firstOrCreate(
            ['id' => 1],
            [
                'heading'           => 'Your Journey Starts Now.',
                'heading_highlight' => 'Starts Now.',
                'description'       => 'Join over 2.5 million event enthusiasts discovering the most exclusive experiences every day.',
                'button_text'       => 'Join as a Organizer',
                'button_url'        => '/organizer/register',
                'button_bg_color'   => '#FFE700',
                'button_text_color' => '#21032B',
                'bg_image_url'      => 'https://images.unsplash.com/photo-1540575861501-7ad05823123d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
            ]
        );
    }
}
