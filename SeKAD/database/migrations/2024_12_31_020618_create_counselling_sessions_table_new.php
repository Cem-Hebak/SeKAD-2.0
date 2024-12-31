<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounsellingSessionsTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counselling_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('student_name'); // Name of the student
            $table->string('student_form'); // Form of the student
            $table->string('student_class'); // Class of the student
            $table->string('time_slot'); // Time slot for the session
            $table->text('session_reason'); // Reason for the session
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending'); // Status of the session
            $table->timestamps(); // Created_at and updated_at columns
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
}
