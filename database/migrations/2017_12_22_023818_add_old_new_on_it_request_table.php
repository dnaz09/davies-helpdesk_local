<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOldNewOnItRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_t_requests', function (Blueprint $table) {            
            $table->integer('old')->deafult(0)->after('sub_category');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_t_requests', function (Blueprint $table) {            
            $table->dropColumn('old');                                   
        });
    }
}
