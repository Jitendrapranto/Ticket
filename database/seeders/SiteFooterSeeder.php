<?php

namespace Database\Seeders;

use App\Models\SiteFooter;
use Illuminate\Database\Seeder;

class SiteFooterSeeder extends Seeder
{
    public function run(): void
    {
        SiteFooter::updateOrCreate(['id' => 1], [
            'logo_path'        => 'Blue_Simple_Technology_Logo.png',
            'description'      => 'Ticket Kinun is your premier gateway to life\'s most unforgettable experiences. Discover, book, and enjoy.',
            'facebook_url'     => '#',
            'twitter_url'      => '#',
            'instagram_url'    => '#',
            'linkedin_url'     => '#',
            'explorer_title'   => 'Explorer',
            'explorer_links'   => [
                ['label' => 'Discover Events', 'url' => '/events'],
                ['label' => 'Trending Now',    'url' => '/#trending'],
                ['label' => 'The Kinun Story', 'url' => '/about'],
                ['label' => 'Contact Us',      'url' => '/contact'],
            ],
            'collections_title' => 'Collections',
            'collections_items' => [
                ['label' => 'Live Concerts'],
                ['label' => 'Elite Sports'],
                ['label' => 'Cinema Premiers'],
                ['label' => 'Culture Fests'],
            ],
            'contact_title'    => 'Get In Touch',
            'contact_email'    => 'support@ticketkinun.com',
            'contact_phone'    => '+880 1234 567 890',
            'contact_address'  => 'Gulshan, Dhaka, BD',
            'copyright_text'   => 'Copyright © 2024 Ticket Kinun. Crafted with precision for the ultimate fans.',
            'privacy_url'      => '#',
            'terms_url'        => '#',
            'cookies_url'      => '#',
        ]);
    }
}
