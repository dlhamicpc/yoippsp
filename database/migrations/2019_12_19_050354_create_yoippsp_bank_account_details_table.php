<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYoippspBankAccountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yoippsp_bank_account_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bank_id')->unsigned()->index();
            $table->string('bank_account_number');
            $table->double('amount', 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_id')->references('id')->on('banks')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yoippsp_bank_account_details');
    }
}
