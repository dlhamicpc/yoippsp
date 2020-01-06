<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinemaTicketBoughtTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_ticket_bought_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('movie_id')->unsigned()->index();
            $table->smallInteger('seat_number');

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');

            $table->foreign('movie_id')->references('id')->on('cinema_posts')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinema_ticket_bought_transactions');
    }
}
