<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_payment_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index(); //payer_id
            $table->bigInteger('website_user_id')->unsigned()->index();
            $table->bigInteger('wptt_id')->unsigned()->index(); ////website_payment_transaction_temporary_id
            $table->bigInteger('transaction_id')->unsigned()->index();
            $table->bigInteger('website_type_id')->unsigned()->index();
            $table->text('metadata')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('website_user_id')->references('id')->on('website_users')->onDeletes('cascade');
            $table->foreign('wptt_id')->references('id')->on('website_payment_transaction_temporaries')->onDeletes('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDeletes('cascade');
            $table->foreign('website_type_id')->references('id')->on('website_types')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_payment_transactions');
    }
}
