<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('student_id');

            $table->integer('current')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('class_per_week');
            $table->integer('due_date')->nullable();
            $table->float('value')->nullable();
            $table->float('class_value')->nullable();
            $table->date('start');
            $table->date('end');
            $table->text('comments')->nullable();
            $table->integer('status')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->string('cancellation_reason', 1000)->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
