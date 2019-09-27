<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRequisitionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_requisition_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ereq_no');
            $table->integer('hr_receiver');
            $table->integer('hr_manager_action');
            $table->integer('reco_approval');
            $table->string('reco_approver');
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
        Schema::dropIfExists('employee_requisition_details');
    }
}
