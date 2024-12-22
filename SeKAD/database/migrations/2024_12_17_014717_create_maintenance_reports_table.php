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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('event_name'); // Event name
            $table->string('pic_name'); // Person in charge
            $table->string('phone_number'); // Phone number
            $table->date('start_date'); // Start date
            $table->time('start_time'); // Start time
            $table->date('finish_date'); // Finish date
            $table->time('finish_time'); // Finish time
            $table->text('description'); // Description
            $table->string('poster')->nullable(); // Poster path (nullable)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
