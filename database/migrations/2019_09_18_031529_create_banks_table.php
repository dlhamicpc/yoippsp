<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('admin_name');
            $table->string('admin_father_name');
            $table->string('admin_office_phone_number')->nullable();
            $table->string('bank_name')->unique();
            $table->string('bank_logo')->default('logo.png');
            $table->string('bank_headquarter_address');
            $table->string('bank_headquarter_city');
            $table->string('bank_headquarter_state');
            $table->string('bank_headquarter_country');
            $table->string('bank_headquarter_address_from_google_map')->nullable();
            $table->string('bank_headquarter_coordinates_from_google_map')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('banks');
    }
}
