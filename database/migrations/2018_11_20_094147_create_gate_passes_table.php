<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_no');
            $table->integer('user_id');
            $table->string('company');
            $table->string('department');
            $table->string('ref_no');
            $table->string('purpose');
            $table->string('control_no');
            $table->string('date');
            $table->string('exit_gate_no');
            $table->string('requested_by');
            $table->string('issue_by')->nullable();
            $table->string('approve_for_release')->nullable();
            $table->integer('approval')->default(0);
            $table->string('checked_by')->nullable();
            $table->string('received_by')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('gate_passes');
    }
}
