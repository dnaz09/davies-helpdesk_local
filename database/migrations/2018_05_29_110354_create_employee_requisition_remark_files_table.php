<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRequisitionRemarkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_requisition_remark_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ereq_no');
            $table->integer('e_remark_id');
            $table->string('filename');
            $table->string('encryptname');
            $table->string('uploaded_by');
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
        Schema::dropIfExists('employee_requisition_remark_files');
    }
}
