<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsOutersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_outers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('email');
            $table->text('body');
            $table->ipAddress('ip');
            $table->string('device_info');
            $table->string('address_from_google_map')->nullable();
            $table->string('coordinates_from_google_map')->nullable(); //to be geometry
            $table->timestamp('sent_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us_outers');
    }
}
