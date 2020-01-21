<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYoippspCompanyStaffMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yoippsp_company_staff_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('dept_id')->unsigned()->index();
            $table->bigInteger('job_id')->unsigned()->index();
            $table->string('name');
            $table->string('father_name');
            $table->char('gender',1); //M for male, F for female
            $table->date('date_of_birth');
            $table->double('salary',20,2)->default(0.0);
            $table->string('home_number')->nullable();
            $table->string('address');
            $table->string('city')->index();
            $table->string('state')->nullable()->index();
            $table->string('country')->index();
            $table->string('home_address_from_google_map')->nullable();
            $table->string('home_coordinates_from_google_map')->nullable(); //table datatype to be changed to geometry
            $table->text('settings'); // to be changed to json
            $table->tinyInteger('status')->unsigned()->default(1); //[ 0 => 'fired', 1 => 'active',2 => 'suspension', ]
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('dept_id')->references('id')->on('yoippsp_company_departments')->onDelete('cascade');

            $table->foreign('job_id')->references('id')->on('yoippsp_company_jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yoippsp_company_staff_members');
    }
}
