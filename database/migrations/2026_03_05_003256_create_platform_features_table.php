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
        Schema::create('platform_features', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fas fa-star');  // FontAwesome class
            $table->string('title');
            $table->text('description');
            $table->string('action_label')->default('Learn More');
            $table->string('card_bg')->default('#F3EEFF');    // card background hex
            $table->string('icon_bg')->default('#520C6B');    // icon box background hex
            $table->string('accent_color')->default('#520C6B'); // link / text accent
            $table->string('border_color')->default('#E9D5FF'); // card border hex
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_features');
    }
};
