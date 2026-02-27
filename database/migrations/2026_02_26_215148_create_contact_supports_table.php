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
        Schema::create('contact_supports', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('24 / 7 SUPPORT');
            $table->string('email')->default('support@ticketkinun.com');
            $table->string('phone')->default('+880 1234 567 890');
            $table->string('address')->default('Gulshan-2, Dhaka, Bangladesh');
            $table->string('card_title')->default('Dedicated Support Team');
            $table->text('card_description')->nullable();
            $table->string('image')->nullable();
            $table->string('call_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_supports');
    }
};
