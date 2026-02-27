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
        Schema::create('about_stories', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('OUR STORY');
            $table->string('title_main')->default('Reimagining the');
            $table->string('title_highlight')->default('Fan Journey');
            $table->text('paragraph_1')->nullable();
            $table->text('paragraph_2')->nullable();
            $table->string('image')->nullable();
            
            // Mini Card 1
            $table->string('card_1_icon')->default('fas fa-fire');
            $table->string('card_1_bg_color')->default('#f0f5ff');
            $table->string('card_1_icon_color')->default('bg-blue-500');
            $table->string('card_1_title')->default('Passion');
            $table->text('card_1_description')->nullable();

            // Mini Card 2
            $table->string('card_2_icon')->default('fas fa-heart');
            $table->string('card_2_bg_color')->default('#fff0f2');
            $table->string('card_2_icon_color')->default('bg-rose-500');
            $table->string('card_2_title')->default('Community');
            $table->text('card_2_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_stories');
    }
};
