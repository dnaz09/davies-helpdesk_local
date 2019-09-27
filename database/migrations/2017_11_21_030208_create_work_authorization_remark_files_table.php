<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkAuthorizationRemarkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_authorization_remark_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_authorization_remark_id');
            $table->integer('work_authorization');            
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
        Schema::dropIfExists('work_authorization_remark_files');
    }
}
