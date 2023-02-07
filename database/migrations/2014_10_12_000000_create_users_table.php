<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->string('nickname', 100)->nullable();
            $table->string('cpf')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('complement', 500)->nullable();
            $table->string('district', 500)->nullable();
            $table->string('city', 500)->nullable();
            $table->string('state', 500)->nullable();
            $table->string('phone_wpp', 500)->nullable();
            $table->string('phone2', 500)->nullable();

            $table->string('image', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
