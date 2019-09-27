<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToWorkAuthDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_authorization_details', function (Blueprint $table) {
            $table->string('exit_time')->nullable()->after('superior_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_authorization_details', function (Blueprint $table) {
            $table->dropColumn('exit_time');
        });
    }
}
