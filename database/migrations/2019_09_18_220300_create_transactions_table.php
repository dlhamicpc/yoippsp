<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->string('sender_name')->index();
            $table->bigInteger('receiver_id')->unsigned()->index();
            $table->string('receiver_name')->index();
            $table->double('amount',20,2);
            $table->double('fee',20,2);
            $table->text('description')->nullable();
            $table->tinyInteger('transaction_type'); 
            //0.Normal Send, 1.Withdraw, 2.Deposit, 3.Request money, 4.onlinepayment, 5*.billpayment
            $table->enum('status', [0, 1, 2]); // 0.Failed, 1.Pending, 2.Completed
            $table->ipAddress('sender_ip');
            $table->string('sender_address_from_google_map')->nullable();
            $table->string('sender_coordinates_from_google_map')->nullable();
            $table->timestamp('sender_softdeletes')->nullable();
            $table->timestamp('receiver_softdeletes')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDeletes('cascade');

            $table->foreign('receiver_id')->references('id')->on('users')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
