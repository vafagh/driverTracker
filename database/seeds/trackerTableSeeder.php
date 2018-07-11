<?php

use Illuminate\Database\Seeder;
use App\Driver;
use App\Rideable;
use App\Location;
use App\Truck;
use App\Ride;
use Faker\Factory as Faker;

class trackerTableSeeder extends Seeder
{
    /**
    * Auto generated seed file.
    *
    * @return void
    */
    public function run()
    {
        factory(App\User::class, 1)->create();
        factory(Truck::class, 7)->create();
        factory(Driver::class, 7)->create();
        factory(Location::class, 40)->create();
        factory(Rideable::class, 20)->create();

        $faker = Faker::create();
        $rideablesIds = Rideable::pluck('id')->all();
        $locationsIds = Location::pluck('id')->all();
        $trucksIds = Truck::pluck('id')->all();
        $driversIds = Driver::pluck('id')->all();

        for($i=1; $i <= 50; $i++) {
            DB::table('location_rideable')->insert([
                'rideable_id' => $faker->randomElement($rideablesIds),
                'location_id' => $faker->randomElement($locationsIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 hours', $endDate = 'now', $timezone = null)
            ]);
        }

        for($i=1; $i <= 20; $i++) {
            DB::table('rideable_truck')->insert([
                'rideable_id' => $faker->randomElement($rideablesIds),
                'truck_id' => $faker->randomElement($trucksIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 hours', $endDate = 'now', $timezone = null)
            ]);
        }

        for($i=1; $i <= 10; $i++) {
            DB::table('driver_truck')->insert([
                'driver_id' => $faker->randomElement($driversIds),
                'truck_id' => $faker->randomElement($trucksIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 hours', $endDate = 'now', $timezone = null)
            ]);
        }

    }
}
