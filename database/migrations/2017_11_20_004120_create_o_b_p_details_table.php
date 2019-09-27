<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOBPDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obp_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('obp_id');
            $table->string('destination');
            $table->string('person_visited');
            $table->string('time_of_arrival');
            $table->string('time_of_departure');
            $table->string('destination2')->nullable();
            $table->string('person_visited2')->nullable();
            $table->string('time_of_arrival2')->nullable();
            $table->string('time_of_departure2')->nullable();
            $table->string('destination3')->nullable();
            $table->string('person_visited3')->nullable();
            $table->string('time_of_arrival3')->nullable();
            $table->string('time_of_departure3')->nullable();
            $table->string('destination4')->nullable();
            $table->string('person_visited4')->nullable();
            $table->string('time_of_arrival4')->nullable();
            $table->string('time_of_departure4')->nullable();
            $table->string('destination5')->nullable();
            $table->string('person_visited5')->nullable();
            $table->string('time_of_arrival5')->nullable();
            $table->string('time_of_departure5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obp_details');
    }
}
