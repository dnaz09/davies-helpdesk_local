<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateneededToBorrowerSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('borrower_slips', function (Blueprint $table) {
            $table->string('date_needed')->after('must_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrower_slips', function (Blueprint $table) {
            $table->dropColumn('date_needed');
        });
    }
}
