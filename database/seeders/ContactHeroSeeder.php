<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactHero::create([
            'badge_text' => 'CONTACT CENTER',
            'title_main' => 'Get In',
            'title_accent' => 'Touch.',
            'subtitle' => 'Have a question or need assistance with your booking? Our dedicated support team is available 24/7 to ensure your experience is flawless.',
        ]);
    }
}
