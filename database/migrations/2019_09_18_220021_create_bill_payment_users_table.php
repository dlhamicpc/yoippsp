<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_payment_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('admin_name');
            $table->string('admin_father_name');
            $table->string('admin_office_phone_number');
            $table->char('admin_gender',1);
            $table->date('admin_date_of_birth');
            $table->string('bill_payment_name')->index();
            $table->tinyInteger('type');
            $table->boolean('database_synced')->default(false);
            $table->double('balance',20,2)->default(0.0);
            $table->bigInteger('city_id')->unsigned()->index();
            $table->bigInteger('state_id')->unsigned()->index();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->string('headquarter_home_number')->nullable();
            $table->string('headquarter_address');
            $table->string('headquarter_address_from_google_map')->nullable();
            $table->string('headquarter_coordinates_from_google_map')->nullable();
            $table->text('settings'); // to be changed to json
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('bill_payment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_payment_users');
    }
}
