<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToReqTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->string('item1')->after('item_no1');
            $table->string('item2')->after('item_no2')->nullable();
            $table->string('item3')->after('item_no3')->nullable();
            $table->string('item4')->after('item_no4')->nullable();
            $table->string('item5')->after('item_no5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
