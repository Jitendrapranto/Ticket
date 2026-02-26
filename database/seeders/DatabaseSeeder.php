<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EventCategorySeeder::class,
            EventSeeder::class,
            EventHeroSeeder::class,
            GalleryHeroSeeder::class,
            GalleryImageSeeder::class,
        ]);

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@ticket.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
    }
}
