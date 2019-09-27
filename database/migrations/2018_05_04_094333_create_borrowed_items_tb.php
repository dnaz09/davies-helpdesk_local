<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowedItemsTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_no');
            $table->integer('user_id');
            $table->integer('solved_by');
            $table->string('barcode');
            $table->date('rel_date');
            $table->date('ret_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_reports');
    }
}
