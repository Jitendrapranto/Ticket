<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutStatistic;

class AboutStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statistics = [
            [
                'icon' => 'fas fa-globe',
                'color' => '#3b82f6',
                'value' => '500+',
                'label' => 'GLOBAL EVENTS',
                'sort_order' => 1,
            ],
            [
                'icon' => 'fas fa-users',
                'color' => '#10b981',
                'value' => '1M+',
                'label' => 'HAPPY FANS',
                'sort_order' => 2,
            ],
            [
                'icon' => 'fas fa-award',
                'color' => '#f59e0b',
                'value' => '25+',
                'label' => 'INDUSTRY AWARDS',
                'sort_order' => 3,
            ],
            [
                'icon' => 'fas fa-shield-alt',
                'color' => '#6366f1',
                'value' => '100%',
                'label' => 'SECURE SALES',
                'sort_order' => 4,
            ],
        ];

        foreach ($statistics as $stat) {
            AboutStatistic::create($stat);
        }
    }
}
