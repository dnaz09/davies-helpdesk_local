<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkAuthDetailsTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_authorization_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_auth_id');
            $table->integer('user_id');
            $table->integer('superior');
            $table->integer('superior_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_authorization_details');
    }
}
