<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->unsigned()->index()->nullable();
            $table->string('sender_name')->index();
            $table->bigInteger('receiver_id')->unsigned()->index()->nullable();
            $table->smallInteger('type')->unsigned()->unsigned(); // 0.received payment, 1.requested payment, 2.billpayment, 3.ticket payment, 4.bank related, 5.yoippsp relaetd
            $table->text('message');
            $table->text('image'); // to be changed to json
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('notification_messages');
    }
}
