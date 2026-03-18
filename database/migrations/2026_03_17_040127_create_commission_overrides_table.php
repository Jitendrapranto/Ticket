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
        Schema::dropIfExists('commission_overrides');
        Schema::create('commission_overrides', function (Blueprint $table) {
            $table->id();
            $table->morphs('overridable'); // creates overridable_id and overridable_type
            $table->string('revenue_model')->default('percentage'); // 'percentage', 'fixed'
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->decimal('fixed_amount', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_overrides');
    }
};
