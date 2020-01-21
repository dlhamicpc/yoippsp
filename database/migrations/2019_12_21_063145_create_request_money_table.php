<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_money', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->unsigned()->index();
            $table->string('sender_name')->index();
            $table->bigInteger('receiver_id')->unsigned()->index();
            $table->string('receiver_name')->index();
            $table->double('amount',20,2);
            $table->text('description')->nullable();
            $table->string('payment_due_date')->nullable();
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
        Schema::dropIfExists('request_money');
    }
}
