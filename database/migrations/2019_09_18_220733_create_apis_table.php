<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->tinyInteger('api_type_id')->index(); //0.website,*
            $table->string('private_key')->unique()->index(); //hash(user_id + type + user_id)
            $table->string('public_key')->unique()->index(); //hash(api_id+ time() + api_id );
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');
            $table->foreign('api_type_id')->references('id')->on('api_types')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apis');
    }
}
