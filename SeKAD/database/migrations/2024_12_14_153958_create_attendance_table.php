<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to the users table (using 'id' as the reference)
            $table->string('name'); // Add name column to store the user's name
            $table->string('ic_number'); // Add ic_number column to store the user's IC number
            $table->date('date'); // Date of attendance
            $table->tinyInteger('present')->default(0); // Attendance status (0 for absent, 1 for present)
            $table->timestamps(); // Created at / updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
