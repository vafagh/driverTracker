<?php

use Faker\Generator as Faker;

$factory->define(App\Truck::class, function (Faker $faker) {
    return [
        'licensePlate'=>$faker->bothify('???-####'),
        'last4vin'=>$faker->randomNumber(4),
        'lable'=>$faker->unique()->randomNumber('1'),
    ];
});
