<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_type');
            $table->string('job_type');
            $table->integer('assignment_letter_number')->nullable();
            $table->string('name')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('month');
            $table->integer('year');
            $table->json('photo')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('activities');
    }
}
