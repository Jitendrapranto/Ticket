<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ticketkinun.official@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Ghosh2001@'),
                'role' => 'admin',
            ]
        );
    }
}
