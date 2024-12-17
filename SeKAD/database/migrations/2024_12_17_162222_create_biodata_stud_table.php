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
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Student's name
            $table->string('class'); // Class name, e.g., "1 CENDEKIAWAN"
            $table->timestamps();
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
