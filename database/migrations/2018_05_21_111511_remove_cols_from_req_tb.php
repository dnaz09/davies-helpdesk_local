<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColsFromReqTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropColumn('coe');
            $table->dropColumn('itr2316');
            $table->dropColumn('philhealth');
            $table->dropColumn('others');
            $table->dropColumn('unit1');
            $table->dropColumn('unit2');
            $table->dropColumn('unit3');
            $table->dropColumn('unit4');
            $table->dropColumn('unit5');
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
