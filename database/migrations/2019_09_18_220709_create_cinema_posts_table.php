<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCinemaPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_member_id')->unsigned()->index();
            $table->string('cinema_branch_city')->nullable();
            $table->string('cinema_branch_address');
            $table->string('cinema_branch_address_from_google_map')->nullable();
            $table->string('cinema_branch_coordinates_from_google_map')->nullable();
            $table->string('movie_name')->index();
            $table->string('movie_language')->index();
            $table->string('movie_genre')->index();
            $table->string('movie_picture');
            $table->string('movie_trailer')->nullable();
            $table->date('movie_start_date');
            $table->date('movie_end_date');
            $table->text('movie_price_due_date_time'); // to be changed to json
            $table->string('number_of_seat');
            $table->text('numbers_of_seat_taken'); //!!atomic rule broken -> trade of for performance
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staff_member_id')->references('id')->on('cinema_staff_members')->onDeletes('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinema_posts');
    }
}
