<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOBPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('supervisor');
            $table->string('position');
            $table->string('department');
            $table->text('purpose');            
            $table->date('date');
            $table->string('time_left');
            $table->string('time_arrived');
            $table->integer('manager');
            $table->integer('manager_action');            
            $table->integer('hrd');
            $table->integer('hrd_action');
            $table->integer('level');
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
        Schema::dropIfExists('obps');
    }
}
