<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ScannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first organizer to associate the scanner with
        $organizer = User::where('role', 'organizer')->first();

        User::updateOrCreate(
            ['email' => 'scanner@example.com'],
            [
                'name' => 'Demo Scanner',
                'password' => Hash::make('password'),
                'role' => 'scanner',
                'organizer_id' => $organizer?->id,
            ]
        );
    }
}
