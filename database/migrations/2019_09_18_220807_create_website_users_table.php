<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('api_id')->unsigned()->index();
            $table->string('admin_name');
            $table->string('admin_father_name');
            $table->string('admin_office_phone_number');
            $table->char('admin_gender',1);
            $table->date('admin_date_of_birth');
            $table->string('website_name')->index();
            $table->tinyInteger('type');
            $table->string('website_url')->index();
            $table->ipAddress('website_ip')->nullable();
            $table->string('webhook_url')->nullable();
            $table->string('callback_url')->nullable();
            $table->double('balance',20,2)->default(0.0);
            $table->string('city')->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->string('country')->nullable()->index();
            $table->string('headquarter_home_number')->nullable();
            $table->string('headquarter_address')->nullable();
            $table->string('headquarter_address_from_google_map')->nullable();
            $table->string('headquarter_coordinates_from_google_map')->nullable();
            $table->text('settings'); // to be changed to json
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('api_id')->references('id')->on('apis')->onDeletes('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('website_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_users');
    }
}
