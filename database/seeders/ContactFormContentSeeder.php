<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactFormContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContactFormContent::create([
            'badge_text' => 'SEND A MESSAGE',
            'title' => 'Drop Us A Line.',
            'description' => 'Fill out the form and our team will get back to you within 2 hours.',
            'button_text' => 'SEND MESSAGE',
            'name_label' => 'FULL NAME',
            'name_placeholder' => 'John Doe',
            'email_label' => 'EMAIL ADDRESS',
            'email_placeholder' => 'john@example.com',
            'phone_label' => 'PHONE NUMBER',
            'phone_placeholder' => '+880 1234 567 890',
            'subject_label' => 'SUBJECT',
            'message_label' => 'YOUR MESSAGE',
            'message_placeholder' => 'How can we help you today?',
        ]);
    }
}
