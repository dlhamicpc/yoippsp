<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitePaymentTransactionTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_payment_transaction_temporaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('website_user_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned()->index()->nullable(); // payer_id
            $table->string('website_user_public_key');
            $table->string('payer_identification');
            $table->string('payer_ip');
            $table->longText('metadata')->nullable();
            $table->double('amount',2);
            $table->enum('status', ['Pending', 'Paid', 'Failed'])->default('Pending');
            $table->timestamps();

            $table->foreign('website_user_id')->references('id')->on('website_users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_payment_transaction_temporaries');
    }
}
