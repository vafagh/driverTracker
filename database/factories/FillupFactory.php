<?php

use Faker\Generator as Faker;

$factory->define(App\Fillup::class, function (Faker $faker) {
    $truck = App\Truck::all()->random();
    return [
        'driver_id' => App\Driver::all()->random()->id,
        'truck_id' => $truck->id,
        'gas_card' =>$truck->gas_card,
        'mileage' => $faker->randomNumber(5),
        'price_per_gallon' => $price_per_gallon = $faker->randomFloat(2, $min = 2.10, 3.10),
        'gallons' => ($gallons = ($truck->tank_capacity - $faker->randomNumber(1))),
        'total' => ($price_per_gallon*$gallons*1.0825),
        'product'=>$faker->randomElement(['Unleaded','Super','Mid']),
        'created_at' => $faker->dateTimeBetween('-1 hours', 'now'),
    ];
});
