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
        Schema::create('meeting_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained('halls')->cascadeOnDelete();
            $table->foreignId('requester_user_id')->constrained('users');
            $table->enum('meeting_type', ['G2B', 'B2B']);
            $table->string('topic');
            $table->date('date');
            $table->time('time');
            $table->unsignedInteger('booked_count')->default(0);
            $table->enum('status', ['confirmed', 'cancelled', 'rescheduled'])->default('confirmed');
            $table->timestamps();
            $table->unique(['hall_id', 'requester_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_bookings');
    }
};
