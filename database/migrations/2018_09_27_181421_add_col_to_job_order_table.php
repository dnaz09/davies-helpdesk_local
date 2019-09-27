<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToJobOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->string('work_for')->after('description')->nullable();
            $table->string('other_info')->after('work_for')->nullable();
            $table->string('asset_no')->after('other_info')->nullable();
            $table->integer('jo_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->dropColumn('work_for');
            $table->dropColumn('other_info');
            $table->dropColumn('asset_no');
        });
    }
}
