<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes to events table for frequently queried columns.
     * These columns appear in WHERE clauses on nearly every page.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Composite index for the most common query pattern:
            // WHERE status = 'Live' AND is_approved = 1 AND date >= NOW()
            $table->index(['status', 'is_approved', 'date'], 'events_status_approved_date_index');

            // Index for featured events filtering
            $table->index('is_featured', 'events_is_featured_index');

            // Index for category-based lookups
            $table->index('category_id', 'events_category_id_index');

            // Index for sort ordering
            $table->index('sort_order', 'events_sort_order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_status_approved_date_index');
            $table->dropIndex('events_is_featured_index');
            $table->dropIndex('events_category_id_index');
            $table->dropIndex('events_sort_order_index');
        });
    }
};
