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
        Schema::create('contact_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('CONTACT CENTER');
            $table->string('title_main')->default('Get In');
            $table->string('title_accent')->default('Touch.');
            $table->text('subtitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_heroes');
    }
};
