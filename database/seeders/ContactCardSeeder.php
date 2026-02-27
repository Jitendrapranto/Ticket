<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactCard::create([
            'title' => 'Email Support',
            'description' => 'Response within 2 hours. Reach us anytime for booking assistance.',
            'action_text' => 'support@ticketkinun.com',
            'action_url' => 'mailto:support@ticketkinun.com',
            'icon' => 'fas fa-envelope',
            'bg_color' => '#fffbf0',
            'theme_color' => '#f59e0b',
            'title_color' => '#92400e',
            'desc_color' => '#b45309',
            'sort_order' => 1
        ]);

        \App\Models\ContactCard::create([
            'title' => 'Call Us',
            'description' => '24/7 Priority Hotline. Encrypted and secure calls for your peace of mind.',
            'action_text' => '+880 1234 567 890',
            'action_url' => 'tel:+8801234567890',
            'icon' => 'fas fa-phone-alt',
            'bg_color' => '#eef2ff',
            'theme_color' => '#4f46e5',
            'title_color' => '#3730a3',
            'desc_color' => '#4338ca',
            'sort_order' => 2
        ]);

        \App\Models\ContactCard::create([
            'title' => 'Our Office',
            'description' => 'Gulshan-2, Dhaka. Visit us during office hours for in-person support.',
            'action_text' => 'Get Directions',
            'action_url' => '#',
            'icon' => 'fas fa-map-marker-alt',
            'bg_color' => '#faf5ff',
            'theme_color' => '#8b5cf6',
            'title_color' => '#4c1d95',
            'desc_color' => '#6d28d9',
            'sort_order' => 3
        ]);
    }
}
