<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevelsOnUndertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('undertimes', function (Blueprint $table) {            
            $table->integer('manager')->default(0)->after('date');            
            $table->integer('manager_action')->default(0)->after('manager');    
            $table->integer('level')->default(1)->after('status');
            $table->boolean('generated')->default(0)->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('undertimes', function (Blueprint $table) {            
            $table->dropColumn('manager');
            $table->dropColumn('manager_action');
            $table->dropColumn('level');
            $table->dropColumn('generated');
        });
    }
}
