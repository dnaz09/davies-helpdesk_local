<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_no')->nullable();
            $table->integer('user_id');
            $table->string('category');
            $table->string('supply');
            $table->text('remarks')->nullable();
            $table->integer('done_by')->default(0);
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
        Schema::dropIfExists('supply_requests');
    }
}
