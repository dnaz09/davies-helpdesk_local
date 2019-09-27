<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateITRequestFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_request_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->string('ticket_no');
            $table->string('filename');
            $table->string('encryptname');
            $table->integer('uploaded_by');        
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
        Schema::dropIfExists('it_request_files');
    }
}
