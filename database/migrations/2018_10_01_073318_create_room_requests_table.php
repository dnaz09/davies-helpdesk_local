<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_no');
            $table->integer('dept_id');
            $table->integer('user_id');
            $table->string('room');
            $table->string('details');
            $table->integer('approval')->default(0);
            $table->integer('approver')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('room_requests');
    }
}
