<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactSupport::create([
            'badge_text' => '24 / 7 SUPPORT',
            'email' => 'support@ticketkinun.com',
            'phone' => '+880 1234 567 890',
            'address' => 'Gulshan-2, Dhaka, Bangladesh',
            'card_title' => 'Dedicated Support Team',
            'card_description' => 'Our specialists handle every request with precision and care. You\'re in good hands.',
            'image' => 'https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'call_url' => 'tel:+8801234567890',
            'whatsapp_url' => 'https://wa.me/8801234567890',
        ]);
    }
}
