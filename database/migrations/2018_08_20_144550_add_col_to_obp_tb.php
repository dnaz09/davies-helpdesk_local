<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToObpTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obps', function(Blueprint $table) {
            $table->integer('hr_action')->after('approver')->default(0);
            $table->integer('hrd')->after('hr_action')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obps', function(Blueprint $table) {
            $table->dropColumn('hr_action');
            $table->dropColumn('hrd');
        });
    }
}
