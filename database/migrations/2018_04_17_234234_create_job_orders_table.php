<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_submitted');
            $table->integer('user_id');
            $table->integer('dept_id');
            $table->integer('role_id');
            $table->string('req_work');
            $table->integer('approved_by')->default(0);
            $table->integer('repair');
            $table->integer('project');
            $table->string('work_done')->nullable();
            $table->string('served_by')->nullable();
            $table->string('verified_by')->nullable();
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
        Schema::dropIfExists('job_orders');
    }
}
