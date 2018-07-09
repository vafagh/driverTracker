<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->float('distance');
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('driver_id');
            $table->unsignedInteger('truck_id');
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->primary(['rideable_id','driver_id','truck_id']);
            $table->timestamps();
        });

    }
    // public function up()
    // {
    //     Schema::create('rides', function (Blueprint $table) {
    //         $table->increments('id');
    //         $table->float('distance');
    //         $table->timestamps();
    //     });
    //
    //     Schema::create('rideable_ride', function (Blueprint $table) {
    //         $table->unsignedInteger('ride_id');
    //         $table->unsignedInteger('Rideable_id');
    //         $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
    //         $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    //     Schema::create('driver_ride', function (Blueprint $table) {
    //         $table->unsignedInteger('ride_id');
    //         $table->unsignedInteger('driver_id');
    //         $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
    //         $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    //     Schema::create('ride_truck', function (Blueprint $table) {
    //         $table->unsignedInteger('ride_id');
    //         $table->unsignedInteger('truck_id');
    //         $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
    //         $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    //
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rides');
        Schema::dropIfExists('rideable_ride');
    }
}
