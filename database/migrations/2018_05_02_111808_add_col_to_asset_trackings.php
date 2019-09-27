<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToAssetTrackings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_trackings', function (Blueprint $table) {
            $table->string('category')->after('remarks');
            $table->string('brand')->after('category');
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
            $table->dropIfExist('category');
            $table->dropIfExist('brand');
        });
    }
}
