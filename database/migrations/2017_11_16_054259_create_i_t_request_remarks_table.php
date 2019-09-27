<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateITRequestRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_request_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->string('ticket_no');
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
        Schema::dropIfExists('it_request_remarks');
    }
}
