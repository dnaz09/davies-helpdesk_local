<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnEmployeeExitPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_exit_passes', function (Blueprint $table) {            
            $table->integer('obp_id')->default(0)->after('exit_no');            
            $table->integer('undertime_id')->default(0)->after('obp_id');            
            $table->string('arrival_time')->nullable()->after('time_out');            
            $table->string('departure_time')->nullable()->after('arrival_time');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {            
            $table->dropColumn('obp_id');                    
            $table->dropColumn('undertime_id');     
            $table->dropColumn('arrival_time');     
            $table->dropColumn('departure_time');     
        });
    }
}
