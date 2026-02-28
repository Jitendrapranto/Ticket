<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->string('revenue_model')->default('percentage'); // percentage, fixed
            $table->decimal('default_percentage', 5, 2)->default(10.00);
            $table->decimal('fixed_amount', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Initialize default record
        \DB::table('commission_settings')->insert([
            'revenue_model' => 'percentage',
            'default_percentage' => 10,
            'fixed_amount' => 0,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_settings');
    }
};
