<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToItRequestTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_t_requests', function (Blueprint $table) {
            $table->string('superior')->nullable();
            $table->string('sup_action')->default(0);
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
            $table->dropColumn('superior');
            $table->dropColumn('sup_action');
        });
    }
}
