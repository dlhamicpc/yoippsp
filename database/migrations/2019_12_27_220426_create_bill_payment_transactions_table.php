<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_payment_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('link_id')->unsigned()->index();
            $table->bigInteger('bill_payment_user_id')->unsigned()->index();
            $table->bigInteger('payment_info_id')->unsigned()->index();
            $table->bigInteger('transaction_id')->unsigned()->index();
            $table->string('bill_payment_type')->unsigned()->index();
            $table->string('description')->nullable();
            $table->text('content');

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('link_id')->references('id')->on('user_bill_payment_links')->onDeletes('cascade');
            $table->foreign('bill_payment_user_id')->references('id')->on('bill_payment_users')->onDeletes('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDeletes('cascade');
            $table->foreign('payment_info_id')->references('id')->on('user_bill_payment_information')->onDeletes('cascade');
            $table->foreign('bill_payment_type')->references('id')->on('bill_payment_types')->onDeletes('cascade');

            ///payment_info_id = user_bill_payment_information_id

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_payment_transactions');
    }
}
