<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowerSlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrower_slips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset_request_no');
            $table->string('asset_barcode')->nullable();
            $table->integer('released')->nullable();
            $table->integer('returned')->nullable();
            $table->date('must_date');
            $table->date('return_date')->nullable();
            $table->string('borrow_code')->nullable();
            $table->string('item');
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
        Schema::dropIfExists('borrower_slips');
    }
}
