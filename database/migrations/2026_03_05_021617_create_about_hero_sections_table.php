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
        Schema::create('about_hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('ABOUT US');
            $table->string('title_main')->default('The Story');
            $table->string('title_accent')->default('Behind Kinun.');
            $table->text('subtitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_hero_sections');
    }
};
