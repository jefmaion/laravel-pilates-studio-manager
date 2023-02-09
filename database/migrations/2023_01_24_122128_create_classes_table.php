<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('classes_id')->nullable();
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('scheduled_instructor_id');
            
            $table->integer('class_order')->nullable();
            $table->string('type', 3)->nullable();
            $table->date('date');
            $table->time('time');
            $table->integer('weekday');
            $table->integer('has_replacement')->default(0);

            $table->integer('status')->default(0);
            $table->integer('finished')->default(0);
            $table->text('comments')->nullable();

            $table->foreign('classes_id')->references('id')->on('classes');
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('instructor_id')->references('id')->on('instructors');
            $table->foreign('scheduled_instructor_id')->references('id')->on('instructors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
