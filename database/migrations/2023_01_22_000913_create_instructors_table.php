<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('user_id');

            $table->string('profession', 150)->nullable();
            $table->string('profession_document', 150)->nullable();
            $table->string('remunaration_type', 3)->nullable();
            $table->float('remuneration_value')->nullable();
            $table->integer('calc_on_absense')->default(0);
            $table->string('comments')->nullable();
            $table->integer('enabled')->default(1);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
}
