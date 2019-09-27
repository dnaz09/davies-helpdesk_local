<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rno');
            $table->integer('user_id');
            $table->integer('supervisor_id')->default(0);
            $table->string('recomm')->nullable();
            $table->boolean('coe')->default(0);
            $table->boolean('itr2316')->default(0);
            $table->boolean('philhealth')->default(0);
            $table->boolean('others')->default(0);
            $table->string('others_details')->nullable();
            $table->date('date_needed');         
            $table->string('purpose1')->nullable();
            $table->string('item_no1')->nullable();
            $table->string('desc1')->nullable();
            $table->string('qty1')->nullable();
            $table->string('unit1')->nullable();
            $table->string('purpose2')->nullable();
            $table->string('item_no2')->nullable();
            $table->string('desc2')->nullable();
            $table->string('qty2')->nullable();
            $table->string('unit2')->nullable();
            $table->string('purpose3')->nullable();
            $table->string('item_no3')->nullable();
            $table->string('desc3')->nullable();
            $table->string('qty3')->nullable();
            $table->string('unit3')->nullable();
            $table->string('purpose4')->nullable();
            $table->string('item_no4')->nullable();
            $table->string('desc4')->nullable();
            $table->string('qty4')->nullable();
            $table->string('unit4')->nullable();
            $table->string('purpose5')->nullable();
            $table->string('item_no5')->nullable();
            $table->string('desc5')->nullable();
            $table->string('qty5')->nullable();
            $table->string('unit5')->nullable();
            $table->integer('hrd')->default(0);
            $table->string('hrd_action')->nullable();
            $table->integer('status')->default(1);
            
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
        Schema::dropIfExists('requisitions');
    }
}
