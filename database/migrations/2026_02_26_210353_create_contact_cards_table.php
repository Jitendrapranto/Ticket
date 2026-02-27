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
        Schema::create('contact_cards', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fas fa-envelope');
            $table->string('title');
            $table->text('description');
            $table->string('action_text')->nullable();
            $table->string('action_url')->nullable();
            $table->string('bg_color')->default('#f8fafc');
            $table->string('theme_color')->default('#520C6B');
            $table->string('title_color')->default('#111827');
            $table->string('desc_color')->default('#64748b');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_cards');
    }
};
