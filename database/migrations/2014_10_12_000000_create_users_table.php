<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('mobile_number',9)->index();
            $table->string('email')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('govt_id_number')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->boolean('online')->default(false);
            $table->timestamp('banned_until')->nullable();
            $table->ipAddress('last_login_ip');
            $table->timestamp('last_login_at')->nullable();
            $table->text('last_login_device_info');
            $table->string('last_login_address_from_google_map')->nullable();
            $table->string('last_login_coordinates_from_google_map')->nullable(); //to be changed to geometry for production or when upgrading mysql
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email', 'deleted_at']);
            $table->unique(['mobile_number', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
