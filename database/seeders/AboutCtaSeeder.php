<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutCta;

class AboutCtaSeeder extends Seeder
{
    public function run(): void
    {
        AboutCta::create([
            'title' => 'Ready to partner?',
            'subtitle' => 'Join our global network of organizers and bring your events to millions.',
            'button_text' => 'CONTACT US TODAY',
            'button_url' => '#',
        ]);
    }
}
