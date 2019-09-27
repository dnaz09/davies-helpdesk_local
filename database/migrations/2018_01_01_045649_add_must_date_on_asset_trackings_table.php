<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMustDateOnAssetTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_trackings', function (Blueprint $table) {            
            $table->string('must_date')->after('holder');            
            $table->string('returned_date')->after('must_date');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_trackings', function (Blueprint $table) {            
            $table->dropColumn('must_date');
            $table->dropColumn('returned_date');
        });
    }
}
