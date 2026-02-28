<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('type')->default('text'); // text, email, number, select, textarea, date, checkbox
            $table->json('options')->nullable(); // for select type: ["Option1","Option2"]
            $table->boolean('is_required')->default(false);
            $table->boolean('is_default')->default(false); // marks the 4 default fields
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_form_fields');
    }
};
