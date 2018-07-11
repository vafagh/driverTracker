<?php

use Faker\Generator as Faker;

$factory->define(App\Rideable::class, function (Faker $faker) {
    return [
        'invoice_number'=>$faker->bothify('######'),
        'status'=>$faker->randomElement(['On The Way', 'Delivered','Waiting For Driver', 'Canceled','Waiting for Pickup']),
        'description'=>$faker->sentence($faker->randomNumber(1)),
        'type' => (App\Location::all()->random()->type == 'Client') ? 'Delivery' : 'Pickup',
        'user_id' => App\User::all()->random()->id,
        'location_id' => App\Location::all()->random()->id,
        'created_at' => $faker->dateTimeBetween('-5 hours', 'now'),
    ];
});
// 'location_id' => App\Location::all()->random()->id,
