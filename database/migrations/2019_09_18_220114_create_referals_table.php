<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referals', function (Blueprint $table) {
            $table->bigInteger('inviter_user_id')->unsigned()->index();
            $table->bigInteger('invited_user_id')->unsigned()->index();
            $table->ipAddress('invited_user_ip')->index();
            $table->timestamps();

            $table->foreign('inviter_user_id')->references('id')->on('users')->onDeletes('cascade');
            
            $table->foreign('invited_user_id')->references('id')->on('users')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referals');
    }
}
