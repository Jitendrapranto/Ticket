<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_footers', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            // Explorer Links (JSON)
            $table->string('explorer_title')->default('Explorer');
            $table->json('explorer_links')->nullable(); // [{label, url}]
            // Collections
            $table->string('collections_title')->default('Collections');
            $table->json('collections_items')->nullable(); // [{label}]
            // Contact Info
            $table->string('contact_title')->default('Get In Touch');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();
            // Bottom Bar
            $table->string('copyright_text')->nullable();
            $table->string('privacy_url')->nullable();
            $table->string('terms_url')->nullable();
            $table->string('cookies_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_footers');
    }
};
