<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountPayablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('registration_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();


            $table->date('due_date');
            $table->decimal('value');
            $table->string('description');
            $table->integer('status')->default(0);
            $table->integer('order')->nullable();

            $table->foreign('registration_id')->references('id')->on('registrations');
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
        Schema::dropIfExists('account_payables');
    }
}
