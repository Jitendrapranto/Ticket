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
        Schema::create('home_cta_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->default('Your Journey Starts Now.');
            $table->string('heading_highlight')->nullable()->default('Starts Now.');
            $table->text('description')->nullable();
            $table->string('button_text')->default('Join as a Organizer');
            $table->string('button_url')->default('/organizer/register');
            $table->string('button_bg_color')->default('#FFE700');
            $table->string('button_text_color')->default('#21032B');
            $table->string('bg_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_cta_sections');
    }
};
