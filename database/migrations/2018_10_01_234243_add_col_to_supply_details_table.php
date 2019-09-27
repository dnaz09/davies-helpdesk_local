<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToSupplyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_supply_request_details', function (Blueprint $table) {
            $table->string('measurement')->after('item')->nullable();
            $table->integer('qty_r')->after('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_supply_request_details', function (Blueprint $table) {
            $table->dropColumn('measurement');
            $table->dropColumn('qty_r');
        });
    }
}
