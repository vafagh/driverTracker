<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('image')->nullable();
            $table->unique('fname','lname');
            $table->timestamps();
        });
        // 
        // Schema::create('driver_truck', function (Blueprint $table) {
        //     $table->unsignedInteger('truck_id');
        //     $table->unsignedInteger('driver_id');
        //     $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
        //     $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        //     $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        //     $table->timestamp('updated_at')->nullable();
        //     $table->primary(['driver_id', 'created_at']);
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_truck');
        Schema::dropIfExists('drivers');
    }
}
