<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('contact_name')->index();
            $table->string('contact_father_name');
            $table->char('contact_gender',1);
            $table->date('contact_date_of_birth');
            $table->string('business_name')->index();
            $table->string('business_phone_number')->nullable();
            $table->string('business_tin_number')->nullable();
            $table->double('balance',20,2)->default(0.0);
            $table->bigInteger('city_id')->unsigned()->index();
            $table->bigInteger('state_id')->unsigned()->index();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->string('address_home_number')->nullable();
            $table->string('headquarter_address')->nullable();
            $table->string('headquarter_address_from_google_map')->nullable();
            $table->string('headquarter_coordinates_from_google_map')->nullable();
            $table->text('settings');
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
        Schema::dropIfExists('business_users');
    }
}
