<?php

use Faker\Generator as Faker;

$factory->define(App\Ride::class, function (Faker $faker) {
    return [
        'rideable_id' => App\Rideable::all()->random()->id,
        'driver_id' => App\Driver::all()->random()->id,
        'truck_id' => App\Truck::all()->random()->id,
        'distance' => $faker->randomNumber(2)
    ];
});
