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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organizer_id')->nullable()->after('role');
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('booking_attendees', function (Blueprint $table) {
            $table->boolean('is_scanned')->default(false)->after('mobile');
            $table->timestamp('scanned_at')->nullable()->after('is_scanned');
            $table->unsignedBigInteger('scanner_id')->nullable()->after('scanned_at');
            $table->foreign('scanner_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn('organizer_id');
        });

        Schema::table('booking_attendees', function (Blueprint $table) {
            $table->dropForeign(['scanner_id']);
            $table->dropColumn(['is_scanned', 'scanned_at', 'scanner_id']);
        });
    }
};
