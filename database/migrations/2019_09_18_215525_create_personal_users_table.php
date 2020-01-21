<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('name')->index();
            $table->string('father_name');
            $table->string('govt_id_number')->nullable();
            $table->char('gender',1);
            $table->date('date_of_birth');
            $table->smallInteger('age')->index();
            $table->double('balance',20,2)->default(0.0);
            $table->string('home_number')->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('city_id')->unsigned()->index();
            $table->bigInteger('state_id')->unsigned()->index();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->string('city')->index();
            $table->string('state')->nullable()->index();
            $table->string('country')->index();
            $table->string('home_address_from_google_map')->nullable();
            $table->string('home_coordinates_from_google_map')->nullable(); //to be changed to geometry
            $table->text('settings'); //to be changed to json
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perosnal_users');
    }
}
