<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYoippspCompanyProjectProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yoippsp_company_project_progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned()->index();
            $table->float('completion')->default(0.0);
            $table->double('used_budget',20,2)->default(0.0);
            $table->text('stage_description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('yoippsp_company_projects')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yoippsp_company_project_progresses');
    }
}
