<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutAdvantage;

class AboutAdvantageSeeder extends Seeder
{
    public function run(): void
    {
        $advantages = [
            [
                'title' => 'Hyper-Speed Booking',
                'description' => 'Our optimized systems guarantee a place in seconds without missing a beat.',
                'icon' => 'fas fa-bolt text-xl',
                'card_bg_color' => '#fffbf0',
                'icon_bg_color' => '#f59e0b',
                'title_color' => '#92400e',
                'desc_color' => '#b45309',
                'border_class' => 'border-orange-50/50',
                'sort_order' => 1,
            ],
            [
                'title' => 'Total Security',
                'description' => 'Every transaction is backed with private, zero-trust technology.',
                'icon' => 'fas fa-shield-alt text-xl',
                'card_bg_color' => '#f4f7ff',
                'icon_bg_color' => '#3b82f6',
                'title_color' => '#1e3a8a',
                'desc_color' => '#1d4ed8',
                'border_class' => 'border-blue-50/50',
                'sort_order' => 2,
            ],
            [
                'title' => 'Exclusive Access',
                'description' => 'Early entry and VIP roles for our dedicated community members.',
                'icon' => 'fas fa-star border text-xl border-dashed rounded p-1 border-white/40',
                'card_bg_color' => '#fcf5ff',
                'icon_bg_color' => '#a855f7',
                'title_color' => '#4c1d95',
                'desc_color' => '#6d28d9',
                'border_class' => 'border-purple-50/50',
                'sort_order' => 3,
            ]
        ];

        foreach ($advantages as $advantage) {
            AboutAdvantage::create($advantage);
        }
    }
}
