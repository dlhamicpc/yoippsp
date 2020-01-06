<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_payment_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bill_payment_user_id')->unsigned()->index();
            $table->double('total_expected_amount',20,2)->nullable();
            $table->double('total_collected_amount',20,2)->default(0.0);
            $table->date('payment_start_on');
            $table->date('payment_end_on');
            $table->year('payment_of_year');
            $table->tinyInteger('payment_of_month');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bill_payment_user_id')->references('id')->on('bill_payment_users')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_payment_posts');
    }
}
