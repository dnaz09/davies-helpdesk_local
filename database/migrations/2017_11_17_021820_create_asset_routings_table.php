<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetRoutingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_routings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id');
            $table->string('barcode');
            $table->integer('holder');
            $table->text('remarks');
            $table->text('remarks2');
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
        Schema::dropIfExists('asset_routings');
    }
}
