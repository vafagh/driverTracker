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
            $table->string('phone')->unique();
            $table->string('distance')->nullable();
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->timestamps();
        });

        Schema::create('rideables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number')->unique();
            $table->string('status');
            $table->string('type');
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create('location_rideable', function (Blueprint $table) {
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
            $table->primary(['location_id','rideable_id']);
            $table->timestamps();
        });

        Schema::create('rideable_truck', function (Blueprint $table) {
            $table->unsignedInteger('rideable_id');
            $table->unsignedInteger('truck_id');
            $table->foreign('rideable_id')->references('id')->on('rideables')->onDelete('cascade');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->primary(['rideable_id','truck_id','created_at']);
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
        Schema::dropIfExists('rideable_truck');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('rideables');
    }
}
