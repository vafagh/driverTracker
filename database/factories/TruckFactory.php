<?php

use Faker\Generator as Faker;

$factory->define(App\Truck::class, function (Faker $faker) {
    return [
        'license_plate'=>$faker->bothify('???-####'),
        'last4vin'=>$faker->randomNumber(4),
        'tank_capacity'=>$faker->numberBetween(15,25),
        'gas_card'=>$faker->creditCardNumber(),
        'lable'=>$faker->unique()->randomNumber('1'),
    ];
});
