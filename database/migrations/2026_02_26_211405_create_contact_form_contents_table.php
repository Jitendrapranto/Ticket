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
        Schema::create('contact_form_contents', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('SEND A MESSAGE');
            $table->string('title')->default('Drop Us A Line.');
            $table->text('description')->nullable();
            $table->string('button_text')->default('SEND MESSAGE');
            
            $table->string('name_label')->default('FULL NAME');
            $table->string('name_placeholder')->default('John Doe');
            $table->string('email_label')->default('EMAIL ADDRESS');
            $table->string('email_placeholder')->default('john@example.com');
            $table->string('phone_label')->default('PHONE NUMBER');
            $table->string('phone_placeholder')->default('+880 1234 567 890');
            $table->string('subject_label')->default('SUBJECT');
            $table->string('message_label')->default('YOUR MESSAGE');
            $table->string('message_placeholder')->default('How can we help you today?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form_contents');
    }
};
