<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeExitPassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_exit_passes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exit_no')->nullable();
            $table->integer('supervisor')->default(0);
            $table->integer('user_id');
            $table->text('purpose')->nullable();
            $table->date('date')->nullable();
            $table->string('time_in')->nullable();
            $table->string('time_out')->nullable();
            $table->boolean('appr_obp')->default(0);
            $table->boolean('appr_leave')->default(0);
            $table->boolean('others')->default(0);
            $table->integer('dep_manager_approver')->nullable();
            $table->integer('dep_manager_action')->nullable();
            $table->text('dep_remarks')->nullable();
            $table->integer('hrd_approver')->nullable();
            $table->integer('hrd_action')->nullable();
            $table->text('hrd_remarks')->nullable();
            $table->integer('vp_hr_approval_approver')->nullable();
            $table->integer('vp_hr_approval_action')->nullable();
            $table->text('vp_hr_approval_remarks')->nullable();
            $table->integer('vp_division_approver')->nullable();
            $table->integer('vp_division_action')->nullable();
            $table->text('vp_division_remarks')->nullable();
            $table->string('security_guard')->nullable();
            $table->integer('status')->default(0);
            $table->integer('level')->default(1);
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
        Schema::dropIfExists('employee_exit_passes');
    }
}
