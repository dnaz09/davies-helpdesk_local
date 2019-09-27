<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrderRemarkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_remark_files', function(Blueprint $table){
            $table->increments('id');
            $table->integer('jo_id');
            $table->integer('jo_remark_id');
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
        Schema::dropIfExists('job_order_remarks_file');
    }
}
