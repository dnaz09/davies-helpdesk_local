<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateITRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_t_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->string('reqit_no');
            $table->integer('level');
            $table->text('details');
            $table->string('status');
            $table->integer('solved_by');
            $table->integer('service_type');
            $table->string('category');
            $table->string('sub_category')->nullable();            
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
        Schema::dropIfExists('i_t_requests');
    }
}
