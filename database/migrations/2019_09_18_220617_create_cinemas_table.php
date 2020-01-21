<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('admin_name')->index();
            $table->string('admin_father_name');
            $table->char('admin_gender',1);
            $table->date('admin_date_of_birth');
            $table->string('admin_office_phone_number');
            $table->string('cinema_name')->index();
            $table->double('balance',20,2)->default(0.0);
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('headquarter_home_number')->nullable();
            $table->string('headquarter_address');
            $table->string('headquarter_address_from_google_map')->nullable();
            $table->string('headquarter_coordinates_from_google_map')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinemas');
    }
}
