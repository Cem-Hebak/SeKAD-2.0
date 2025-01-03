<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiodataStudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata_stud', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // Foreign key to users.id
            $table->string('name');
            $table->string('class');
            $table->timestamps();

            // Define the foreign key constraint to ensure id matches users.id
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->primary('id'); // Set id as the primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biodata_stud');
    }
}

