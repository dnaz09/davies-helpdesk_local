<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode');
            $table->string('item_name');
            $table->text('remarks');
            $table->boolean('io');
            $table->integer('holder');
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
        Schema::dropIfExists('asset_trackings');
    }
}
