<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_headers', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable();
            $table->string('search_placeholder')->default('Search for Movies, Events, Plays, Sports and Activities');
            $table->string('login_text')->default('Login');
            $table->string('signup_text')->default('Sign Up');
            $table->json('nav_links')->nullable(); // JSON array of {label, url}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_headers');
    }
};
