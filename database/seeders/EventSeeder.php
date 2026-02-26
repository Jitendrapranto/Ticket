<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventCategory;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $categories = EventCategory::all();

        if ($categories->isEmpty()) {
            $this->call(EventCategorySeeder::class);
            $categories = EventCategory::all();
        }

        $events = [
            [
                'title' => 'Neon Nights: Underground Jazz',
                'organizer' => 'Blue Note Collective',
                'location' => 'The Cellar, Manhattan',
                'price' => 45.00,
                'category_name' => 'Music',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1511192303578-4a7bb0838a48?w=1280&q=80',
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'World Cup Qualifiers: Finals',
                'organizer' => 'Global Sports Federation',
                'location' => 'MetLife Stadium, NJ',
                'price' => 85.00,
                'category_name' => 'Sports',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1280&q=80',
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Indie Filmmakers Premiere',
                'organizer' => 'Cinema Society',
                'location' => 'Historic Roxy Theater',
                'price' => 25.00,
                'category_name' => 'Cinema',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=1280&q=80',
                'is_featured' => false,
                'sort_order' => 3
            ],
            [
                'title' => 'The Phantom of the Opera',
                'organizer' => 'Broadway Elite',
                'location' => 'Majestic Theatre, NY',
                'price' => 120.00,
                'category_name' => 'Theater',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?w=1280&q=80',
                'is_featured' => true,
                'sort_order' => 0
            ],
            [
                'title' => 'Met Gala: After Party',
                'organizer' => 'Vogue Events',
                'location' => 'The Metropolitan Museum',
                'price' => 500.00,
                'category_name' => 'Lifestyle',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1280&q=80',
                'is_featured' => false,
                'sort_order' => 10
            ],
            [
                'title' => 'Rock Revolution 2026',
                'organizer' => 'Live Nation',
                'location' => 'Madison Square Garden',
                'price' => 95.00,
                'category_name' => 'Music',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1459749411177-042180ce673f?w=1280&q=80',
                'is_featured' => false,
                'sort_order' => 5
            ],
            [
                'title' => 'Wimbledon Championship Day 1',
                'organizer' => 'All England Club',
                'location' => 'London, UK',
                'price' => 150.00,
                'category_name' => 'Sports',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a4bd13?w=1280&q=80'
            ],
            [
                'title' => 'Cannes Film Festival Spotlight',
                'organizer' => 'Cannes Official',
                'location' => 'Palais des Festivals',
                'price' => 75.00,
                'category_name' => 'Cinema',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=1280&q=80'
            ],
            [
                'title' => 'Hamilton: The Musical',
                'organizer' => 'Lin-Manuel Productions',
                'location' => 'Richard Rodgers Theatre',
                'price' => 180.00,
                'category_name' => 'Theater',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=1280&q=80'
            ],
            [
                'title' => 'Paris Fashion Week Showcase',
                'organizer' => 'Chambre Syndicale',
                'location' => 'Grand Palais, Paris',
                'price' => 300.00,
                'category_name' => 'Lifestyle',
                'status' => 'Live',
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=1280&q=80'
            ],
            [
                'title' => 'Symphony Under the Stars',
                'organizer' => 'Philharmonic Orch',
                'location' => 'Central Park, NY',
                'price' => 0.00,
                'category_name' => 'Music',
                'status' => 'Draft',
                'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1280&q=80'
            ],
            [
                'title' => 'NBA All-Star Weekend',
                'organizer' => 'NBA',
                'location' => 'Staples Center, LA',
                'price' => 250.00,
                'category_name' => 'Sports',
                'status' => 'Draft',
                'image' => 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?w=1280&q=80'
            ],
        ];

        foreach ($events as $eventData) {
            $cat = $categories->where('name', $eventData['category_name'])->first();
            $title = $eventData['title'];
            unset($eventData['category_name']);
            
            Event::updateOrCreate(['title' => $title], array_merge($eventData, [
                'category_id' => $cat->id,
                'slug' => \Illuminate\Support\Str::slug($title),
                'date' => Carbon::now()->addDays(rand(10, 60)),
                'registration_deadline' => Carbon::now()->addDays(rand(1, 5)),
                'description' => 'Experience the magic of ' . $title . '. A world-class event organized by ' . $eventData['organizer'] . '.',
            ]));
        }
    }
}
