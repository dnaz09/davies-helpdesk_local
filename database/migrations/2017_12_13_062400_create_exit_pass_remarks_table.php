<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitPassRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_pass_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exit_id');
            $table->string('exit_no');
            $table->text('details');
            $table->integer('remarks_by');
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
        Schema::dropIfExists('exit_pass_remarks');
    }
}
