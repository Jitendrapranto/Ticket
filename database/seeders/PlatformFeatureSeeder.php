<?php

namespace Database\Seeders;

use App\Models\PlatformFeature;
use Illuminate\Database\Seeder;

class PlatformFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'icon'         => 'fas fa-ticket-alt',
                'title'        => 'Smart Ticketing',
                'description'  => 'Skip the lines with our zero-wait entry technology. Your phone is your key to the world of events and exclusive experiences.',
                'action_label' => 'Learn More',
                'card_bg'      => '#FFF8EC',
                'icon_bg'      => '#F59E0B',
                'accent_color' => '#D97706',
                'border_color' => '#FDE68A',
                'is_active'    => true,
                'sort_order'   => 1,
            ],
            [
                'icon'         => 'fas fa-shield-alt',
                'title'        => 'Total Security',
                'description'  => 'Encrypted transactions and anti-fraud technology protect every booking you make on our platform, giving you complete peace of mind.',
                'action_label' => 'Learn More',
                'card_bg'      => '#EEF0FF',
                'icon_bg'      => '#6366F1',
                'accent_color' => '#4F46E5',
                'border_color' => '#C7D2FE',
                'is_active'    => true,
                'sort_order'   => 2,
            ],
            [
                'icon'         => 'fas fa-headset',
                'title'        => 'VIP Support',
                'description'  => 'Dedicated 24/7 assistance from our expert team. We are always here whenever you need help with your bookings or events.',
                'action_label' => 'Get Support',
                'card_bg'      => '#F3EEFF',
                'icon_bg'      => '#520C6B',
                'accent_color' => '#520C6B',
                'border_color' => '#E9D5FF',
                'is_active'    => true,
                'sort_order'   => 3,
            ],
        ];

        foreach ($features as $feature) {
            PlatformFeature::firstOrCreate(['title' => $feature['title']], $feature);
        }
    }
}
