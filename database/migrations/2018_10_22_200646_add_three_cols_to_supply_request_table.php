<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColsToSupplyRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_supply_requests', function(Blueprint $table) {
            $table->string('via')->after('status')->nullable();
            $table->string('deliver')->after('via')->nullable();
            $table->string('value')->after('deliver')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_supply_requests', function(Blueprint $table) {
            $table->dropColumn('via');
            $table->dropColumn('deliver');
            $table->dropColumn('value');
        });
    }
}
