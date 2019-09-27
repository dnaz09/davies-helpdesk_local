<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undertimes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('sched');
            $table->text('reason');
            $table->date('date');
            $table->integer('approve_by');      
            $table->integer('status');
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
        Schema::dropIfExists('undertimes');
    }
}
