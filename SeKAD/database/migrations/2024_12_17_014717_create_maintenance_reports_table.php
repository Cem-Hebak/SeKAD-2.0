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
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // User's name
            $table->date('date_of_reporting'); // Date of reporting
            $table->time('time_of_reporting'); // Time of reporting
            $table->date('date_of_repair_completion')->nullable(); // Date of repair completion
            $table->time('time_of_repair_completion')->nullable(); // Time of repair completion
            $table->string('picture')->nullable(); // Picture file path
            $table->text('description'); // Details about the damage
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
