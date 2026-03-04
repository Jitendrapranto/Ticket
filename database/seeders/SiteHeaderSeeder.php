<?php

namespace Database\Seeders;

use App\Models\SiteHeader;
use Illuminate\Database\Seeder;

class SiteHeaderSeeder extends Seeder
{
    public function run(): void
    {
        SiteHeader::updateOrCreate(['id' => 1], [
            'logo_path'          => 'Blue_Simple_Technology_Logo.png',
            'search_placeholder' => 'Search for Movies, Events, Plays, Sports and Activities',
            'login_text'         => 'Login',
            'signup_text'        => 'Sign Up',
            'nav_links'          => [
                ['label' => 'HOME',    'url' => '/'],
                ['label' => 'EVENTS',  'url' => '/events'],
                ['label' => 'GALLERY', 'url' => '/gallery'],
                ['label' => 'ABOUT',   'url' => '/about'],
                ['label' => 'CONTACT', 'url' => '/contact'],
            ],
        ]);
    }
}
