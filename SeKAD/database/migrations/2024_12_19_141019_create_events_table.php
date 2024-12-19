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
            $table->string('pic_name'); // Person in charge or company
            $table->string('phone_number'); // Phone number
            $table->string('event_name'); // Event name
            $table->date('start_date'); // Event start date
            $table->time('start_time'); // Event start time
            $table->date('finish_date'); // Event finish date
            $table->time('finish_time'); // Event finish time
            $table->text('description'); // Event description
            $table->string('poster_path')->nullable(); // Event poster (nullable)
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
