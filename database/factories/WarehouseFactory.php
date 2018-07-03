<?php

use Faker\Generator as Faker;

$factory->define(App\Warehouse::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'distance' => $faker->randomDigit,
        'address_id' => function(){
            return factory(App\Address::class)->create()->id;
        }
    ];
});
