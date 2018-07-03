<?php

use Faker\Generator as Faker;

$factory->define(App\Ride::class, function (Faker $faker) {
    return [
        'driver_id' => App\Driver::all()->random()->id,
        'truck_id' => App\Truck::all()->random()->id
    ];
});
