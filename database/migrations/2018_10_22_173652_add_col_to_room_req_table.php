<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToRoomReqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_requests', function (Blueprint $table) {
            $table->string('start_date')->after('details');
            $table->string('end_date')->after('start_date');
            $table->string('start_time')->after('end_date');
            $table->string('end_time')->after('start_time');
            $table->string('facilitator')->after('end_time');
            $table->integer('att_no')->after('facilitator')->default(0);
            $table->string('setup')->after('att_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_requests', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('facilitator');
            $table->dropColumn('att_no');
            $table->dropColumn('setup');
        });
    }
}
