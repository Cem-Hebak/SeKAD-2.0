<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counselling_sessions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('student_name'); // Student's name
            $table->string('student_form'); // Form (1, 2, 3, etc.)
            $table->string('student_class'); // Class (Pendeta, Sarjana, etc.)
            $table->string('time_slot'); // Time slot for the session
            $table->text('session_reason'); // Reason for the session
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending'); // Status of booking
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counselling_sessions');
    }
};
