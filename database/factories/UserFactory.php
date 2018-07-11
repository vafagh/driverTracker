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

$factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Vafa', 'email' => 'goreyshi@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Abraham', 'email' => 'abrahamkha@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Ali', 'email' => 'ali@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Chris', 'email' => 'christ@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Enrique', 'email' => 'enriqueg@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Eddy', 'email' => 'eddyl@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Erika', 'email' => 'Erekav@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Joe', 'email' => 'joel@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Larry', 'email' => 'larryg@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Mandy', 'email' => 'mandy@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Mike', 'email' => 'miker@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
// $factory->define(App\User::class, function (Faker $faker) { return ['name' => 'Patricia', 'email' => 'patriciar@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ];});
