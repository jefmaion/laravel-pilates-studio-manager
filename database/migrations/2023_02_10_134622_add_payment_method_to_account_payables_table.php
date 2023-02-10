<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodToAccountPayablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_payables', function (Blueprint $table) {
            $table->unsignedBigInteger('initial_payment_method_id')->after('student_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->after('initial_payment_method_id')->nullable();

            $table->foreign('initial_payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_payables', function (Blueprint $table) {
            $table->dropColumn('payment_method_id');
        });
    }
}
