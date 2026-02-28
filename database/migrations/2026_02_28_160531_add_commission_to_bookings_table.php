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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('subtotal_amount', 10, 2)->after('user_id')->nullable();
            $table->decimal('commission_amount', 10, 2)->after('subtotal_amount')->nullable();
            $table->decimal('commission_percentage', 5, 2)->after('commission_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['subtotal_amount', 'commission_amount', 'commission_percentage']);
        });
    }
};
