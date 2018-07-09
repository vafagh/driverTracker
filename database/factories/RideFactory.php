<?php

use Faker\Generator as Faker;

$factory->define(App\Ride::class, function (Faker $faker) {
    return [
        'ridable_id' => App\Ridable::all()->random()->id,
        'driver_id' => App\Driver::all()->random()->id,
        'truck_id' => App\Truck::all()->random()->id,
        'distance' => $faker->randomNumber(2)
    ];
});
