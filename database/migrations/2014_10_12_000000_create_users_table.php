<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('last_name');
            $table->string('username');            
            $table->string('position');
            $table->string('employee_number');
            $table->string('email');
            $table->string('password');            
            $table->string('active')->default(1);
            $table->string('super_admin')->default(0);
            $table->integer('dept_id');            
            $table->integer('role_id');
            $table->string('image');
            $table->string('mystatus');
            $table->string('email_pass')->nullable();
            $table->string('cellno');
            $table->string('localno');
            $table->boolean('online')->default(0);            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
