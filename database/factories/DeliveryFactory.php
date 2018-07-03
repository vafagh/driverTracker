<?php

use Faker\Generator as Faker;

$factory->define(App\Delivery::class, function (Faker $faker) {
    return [
        'invoice_number'=>$faker->bothify('######'),
        'status'=>$faker->randomElement(['On The Way', 'Delivered','Waiting For Driver', 'Canceled','Waiting for Pickup']),
        'description'=>$faker->sentence($faker->randomNumber(1)),
        'ride_id' => function(){
            return factory(App\Ride::class)->create()->id;
        },
        'client_id' => App\Client::all()->random()->id,
        'created_at' => $faker->dateTimeBetween('-5 hours', 'now'),
    ];
});
