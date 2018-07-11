<?php

use Faker\Generator as Faker;

$factory->define(App\Ride::class, function (Faker $faker) {
    return [
        'driver_id' => App\Driver::all()->random()->id,
        'rideable_id' => App\Rideable::all()->random()->id,
        'truck_id' => App\Truck::all()->random()->id,
        'distance' => App\Location::all()->random()->distance,
        'created_at' => $faker->dateTimeBetween('-1 hours', 'now'),
    ];
});
