<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactMap::create([
            'title' => 'Find Us On Map',
            'subtitle' => 'Visit our head office for a coffee and chat.',
            'map_image' => 'https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
            'google_map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14602.700312011246!2d90.41266!3d23.7915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7a0f70deb73%3A0x30c3642c3d0b88dc!2sGulshan%202%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1714123456789!5m2!1sen!2sbd'
        ]);
    }
}
