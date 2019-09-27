<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherFieldsOnEmployeeExitPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_exit_passes', function (Blueprint $table) {            
            $table->string('others_details')->nullable()->after('others');                                            
            $table->string('guard_remarks')->nullable()->after('security_guard');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_exit_passes', function (Blueprint $table) {            
            $table->dropColumn('others_details');
            $table->dropColumn('guard_remarks');            
        });
    }
}
