<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinemaStaffMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_staff_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('cinema_id')->unsigned()->index();
            $table->string('staff_member_name')->index();
            $table->string('staff_member_father_name');
            $table->char('staff_member_gender',1);
            $table->date('staff_member_date_of_birth');
            $table->tinyInteger('status');
            $table->text('settings');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDeletes('cascade');

            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinema_staff_members');
    }
}
