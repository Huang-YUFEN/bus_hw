<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     /* number:公車車號 
        road:路程(0-去程，1-回程)
        PlateNumb:車牌號
        GPS_Time:時間
        X,Y:座標
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('number');
            $table->string('road');
            $table->string('PlateNumb')->default('沒有車喔!');
            $table->string('GPS_Time')->default('沒有車喔!');
            $table->string('X')->default('沒有車喔!');
            $table->string('Y')->default('沒有車喔!');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
}
