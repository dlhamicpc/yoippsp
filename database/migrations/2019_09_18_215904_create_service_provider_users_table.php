<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProviderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('admin_name');
            $table->string('admin_father_name');
            $table->string('admin_office_phone_number');
            $table->string('admin_gender');
            $table->string('admin_date_of_birth');
            $table->string('service_provider_name')->unique();
            $table->tinyInteger('type');//0.cinema,*
            $table->double('balance',20,2);
            $table->bigInteger('city_id')->unsigned()->index();
            $table->bigInteger('state_id')->unsigned()->index();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->string('headquarter_home_number')->nullable();
            $table->string('headquarter_address')->nullable();
            $table->string('headquarter_address_from_google_map')->nullable();
            $table->string('headquarter_coordinates_from_google_map')->nullable(); // to be changed to geometry
            $table->text('settings'); // to be changed to json
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
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
        Schema::dropIfExists('service_provider_users');
    }
}
