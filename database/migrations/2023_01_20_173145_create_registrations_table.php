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
            $table->unsignedBigInteger('plan_id');
            
            $table->integer('current')->nullable();
            $table->integer('due_date')->nullable();
            $table->float('value')->nullable();
            $table->float('discount')->nullable();
            $table->float('final_value')->nullable();
            $table->float('class_value')->nullable();
            $table->date('start');
            $table->date('end');
            $table->text('comments')->nullable();
            $table->integer('status')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->string('cancellation_reason', 1000)->nullable();


            
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('plan_id')->references('id')->on('plans');
            
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
