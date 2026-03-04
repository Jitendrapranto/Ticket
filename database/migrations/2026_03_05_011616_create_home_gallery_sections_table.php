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
        Schema::create('home_gallery_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Moments That Stick Forever');
            $table->text('description')->nullable();
            $table->string('button_text')->default('OPEN GALLERY');
            $table->string('button_url')->default('/gallery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_gallery_sections');
    }
};
