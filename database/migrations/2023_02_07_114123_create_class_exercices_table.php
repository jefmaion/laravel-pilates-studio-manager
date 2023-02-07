<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassExercicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_exercices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('classes_id');
            $table->unsignedBigInteger('exercice_id');

            $table->foreign('classes_id')->references('id')->on('classes');
            $table->foreign('exercice_id')->references('id')->on('exercices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_exercices');
    }
}
