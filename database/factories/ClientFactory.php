<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'distance' => $faker->randomDigit,
        'payType'=>$faker->randomElement(['Cash', 'Credit']),
        'address_id' => function(){
            return factory(App\Address::class)->create()->id;
        }
    ];
});
