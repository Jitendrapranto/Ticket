<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'bKash',
                'slug' => 'bkash',
                'instructions' => "1. Go to your bKash App or Dial *247#\n2. Select **\"Send Money\"** or **\"Payment\"**\n3. Enter the bKash number: **01712-345678**\n4. Enter Total Amount: **৳[amount]**\n5. After successful payment, enter the **Transaction ID** below and upload a screenshot.",
                'account_number' => '01712-345678',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Rocket',
                'slug' => 'rocket',
                'instructions' => "1. Go to your Rocket App or Dial *322#\n2. Select **\"Send Money\"**\n3. Enter the Rocket number: **01712-345678-0**\n4. Enter Total Amount: **৳[amount]**\n5. After successful payment, enter the **Transaction ID** below and upload a screenshot.",
                'account_number' => '01712-345678-0',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Nagad',
                'slug' => 'nagad',
                'instructions' => "1. Go to your Nagad App or Dial *167#\n2. Select **\"Send Money\"**\n3. Enter the Nagad number: **01712-345678**\n4. Enter Total Amount: **৳[amount]**\n5. After successful payment, enter the **Transaction ID** below and upload a screenshot.",
                'account_number' => '01712-345678',
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($methods as $method) {
            \App\Models\PaymentMethod::updateOrCreate(['slug' => $method['slug']], $method);
        }
    }
}
