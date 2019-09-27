<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSupplyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_supply_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_no');
            $table->integer('user_id');
            $table->string('details');
            $table->integer('manager_action')->default(0);
            $table->integer('manager')->nullable();
            $table->integer('superior')->nullable();
            $table->integer('admin_action')->default(0);
            $table->integer('admin')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('admin_supply_requests');
    }
}
