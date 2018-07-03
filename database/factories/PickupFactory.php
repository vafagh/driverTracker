<?php

use Faker\Generator as Faker;

$factory->define(App\Pickup::class, function (Faker $faker) {
    return [
        'eagle_number'=>$faker->bothify('?######'),
        'status'=>$faker->randomElement(['On The Way', 'Picked-up','Waiting For Driver', 'Canceled','Waiting for Warehouse']),
        'description'=>$faker->sentence($faker->randomNumber(1)),
        'ride_id' => function(){
            return factory(App\Ride::class)->create()->id;
        },
        'client_id' => App\Client::all()->random()->id,
        'warehouse_id'  => App\Warehouse::all()->random()->id,
        'created_at' => $faker->dateTimeBetween('-6 hours', 'now'),
    ];
});
