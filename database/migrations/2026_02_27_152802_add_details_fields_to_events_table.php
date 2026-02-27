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
        Schema::table('events', function (Blueprint $table) {
            $table->string('venue_name')->nullable()->after('location');
            $table->string('language')->nullable()->after('description');
            $table->string('age_limit')->nullable()->after('language');
            $table->string('duration')->nullable()->after('age_limit');
            $table->text('you_should_know')->nullable()->after('duration');
            $table->text('terms_conditions')->nullable()->after('you_should_know');
            $table->json('artists')->nullable()->after('terms_conditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['venue_name', 'language', 'age_limit', 'duration', 'you_should_know', 'terms_conditions', 'artists']);
        });
    }
};
