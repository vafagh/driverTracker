<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
$n = $faker->randomElement(['Vafagh','Abrahamkha', 'Ali', 'Chris', 'Enrique', 'Eddy', 'Erika', 'Joe', 'Larry', 'Mandy', 'Mike', 'Patricia']);
    return [
        'name' => $n,
        'email' => $n.'@'.env('APP_URL'),
        'role_id' => '3',
        'password' => bcrypt('123123'),
        'remember_token' => str_random(10),
    ];
});
