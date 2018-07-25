<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRideablesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('name')->unique();
            $table->string('longName');
            $table->string('person');
            $table->string('phone')->unique();
            $table->string('distance')->nullable();
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rideables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->string('invoice_number');
            $table->string('type');
            $table->string('status');
            $table->longText('description')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->softDeletes();
        });

        Schema::create('location_rideable', function (Blueprint $table) {
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('location_id');
            $table->timestamps();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
            $table->primary(['location_id','rideable_id']);
            $table->softDeletes();
        });


        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('license_plate')->unique();
            $table->string('gas_card')->unique();
            $table->string('mileage');
            $table->string('tank_capacity');
            $table->string('last4vin')->nullable()->unique();
            $table->string('lable')->nullable()->unique();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->unique('fname','lname');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('fillups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('truck_id');
            $table->unsignedInteger('driver_id');
            $table->string('gas_card');
            $table->string('gallons');
            $table->string('product')->nullable();
            $table->string('image')->nullable();
            $table->float('price_per_gallon');
            $table->float('total');
            $table->string('mileage')->nullable();
            $table->timestamps();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->softDeletes();
        });


        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('truck_id');
            $table->unsignedInteger('driver_id');
            $table->string('distance');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('set null');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->softDeletes();
        });


        Schema::create('ride_rideable', function (Blueprint $table) {
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('ride_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->primary(['rideable_id','ride_id']);
            $table->softDeletes();
        });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        // $table->dropForeign('posts_user_id_foreign');
        Schema::dropIfExists('location_rideable');
        Schema::dropIfExists('rideable_ride');
        Schema::dropIfExists('rides');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('trucks');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('rideables');
    }
}
