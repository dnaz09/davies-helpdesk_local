<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_authorizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('ot_from');
            $table->string('ot_to');
            $table->string('not_exceed_to');
            $table->text('reason');
            $table->string('requested_by');
            $table->integer('superior')->nullable();
            $table->integer('superior_action')->default(1);    
            $table->integer('hrd')->nullable();
            $table->integer('hrd_action')->default(1);
            $table->integer('security')->nullable();
            $table->string('time_out')->nullable();
            $table->integer('level')->default(1);
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
        Schema::dropIfExists('work_authorizations');
    }
}
