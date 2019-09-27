<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndertimeRemarkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undertime_remark_files', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('undertime_id');
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
        Schema::dropIfExists('undertime_remark_files');
    }
}
