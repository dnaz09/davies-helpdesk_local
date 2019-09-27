<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_requisitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ereq_no')->nullable();
            $table->string('job_title');
            $table->string('company');
            $table->string('dept_id');
            $table->string('work_site');
            $table->integer('no_needed');
            $table->date('date_needed');
            $table->integer('req_type');
            $table->integer('gender');
            $table->integer('age');
            $table->string('details');
            $table->integer('user_id');
            $table->integer('manager');
            $table->integer('sup_action')->default(0);
            $table->integer('superior')->nullable();
            $table->integer('hr_action')->default(0);
            $table->integer('hrd')->nullable();
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
        Schema::dropIfExists('employee_requisitions');
    }
}
