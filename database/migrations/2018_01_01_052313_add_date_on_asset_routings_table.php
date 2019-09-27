<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateOnAssetRoutingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_routings', function (Blueprint $table) {            
            $table->string('must_date')->nullbale()->after('holder');            
            $table->string('returned_date')->after('must_date');    
            $table->integer('return_status')->after('returned_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_routings', function (Blueprint $table) {            
            $table->dropColumn('must_date');
            $table->dropColumn('returned_date');
            $table->dropColumn('return_status');
        });
    }
}
