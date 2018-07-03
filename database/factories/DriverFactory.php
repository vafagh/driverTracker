<?php

use Faker\Generator as Faker;

$factory->define(App\Driver::class, function (Faker $faker) {
    return [
        'fname'=>$faker->FirstName,
        'lname'=>$faker->lastName,
        'phone'=>$faker->phoneNumber,
    ];
});
