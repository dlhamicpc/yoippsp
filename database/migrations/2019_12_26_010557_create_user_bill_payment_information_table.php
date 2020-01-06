<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBillPaymentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bill_payment_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('link_id')->unsigned()->index();
            $table->bigInteger('bill_payment_user_id')->unsigned()->index();
            $table->double('amount',20,2);
            $table->year('payment_of_year')->nullable();
            $table->tinyInteger('payment_of_month')->nullable();
            $table->enum('payment_status', ['Pending', 'Paid', 'Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('link_id')->references('id')->on('user_bill_payment_links')->onDeletes('cascade');
            $table->foreign('bill_payment_user_id')->references('id')->on('bill_payment_users')->onDeletes('cascade');

            ///payment_identificaiton = user_payment_identificaiton
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bill_payment_information');
    }
}
