<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->catchPhrase,
        'person' => $faker->name,
        'type' => $faker->randomElement(['Warehouse', 'Client']),
        'phone' => $faker->phoneNumber,
        'distance' => $faker->randomNumber(2),
        'line1' => $faker->streetAddress,
        'line2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
    ];
});
