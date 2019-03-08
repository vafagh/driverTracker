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
            $table->string('longName')->nullable();
            $table->string('person')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->string('distance')->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
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
            $table->string('invoice_number');
            $table->integer('qty')->nullable();
            $table->string('type');
            $table->string('status');
            $table->string('delivery_date')->nullable();
            $table->string('shift')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('location_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
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
            $table->boolean('working')->default(true);
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('truck_id')->nullable();
            $table->unique('fname','lname');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('truck_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('product')->nullable();
            $table->string('image')->nullable();
            $table->string('mileage')->nullable();
            $table->string('shop')->nullable();
            $table->string('shop_phone')->nullable();
            $table->string('voucher_number')->nullable();
            $table->float('total');
            $table->timestamps();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->softDeletes();
        });

        Schema::create('fillups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('truck_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->string('gas_card');
            $table->string('gallons');
            $table->string('product')->nullable();
            $table->string('image')->nullable();
            $table->float('price_per_gallon');
            $table->float('total');
            $table->string('mileage')->nullable();
            $table->timestamps();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->softDeletes();
        });

        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rideable_id')->nullable();
            $table->unsignedInteger('truck_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('shift')->nullable();
            $table->string('distance');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('set null');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
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
        Schema::dropIfExists('ride_rideable');
        Schema::dropIfExists('rides');
        Schema::dropIfExists('fillups');
        Schema::dropIfExists('services');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('trucks');
        Schema::dropIfExists('rideables');
        Schema::dropIfExists('locations');
    }
}
