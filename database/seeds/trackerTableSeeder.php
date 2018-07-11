<?php

use Illuminate\Database\Seeder;
use App\Driver;
use App\Truck;
use App\Fillup;
use App\Rideable;
use App\Location;
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
        factory(Fillup::class, 15)->create();
        factory(Location::class, 10)->create();
        factory(Rideable::class, 10)->create();
        factory(Ride::class, 12)->create();

        $faker = Faker::create();
        $rideablesIds = Rideable::pluck('id')->all();
        // $locationsIds = Location::pluck('id')->all();
        $ridesIds = Ride::pluck('id')->all();

        // for($i=1; $i <= 10; $i++) {
        //     DB::table('location_rideable')->insert([
        //         'rideable_id' => $faker->randomElement($rideablesIds),
        //         'location_id' => $faker->randomElement($locationsIds),
        //         'created_at' => $faker->dateTimeBetween($startDate = '-3 hours', $endDate = 'now', $timezone = null)
        //     ]);
        // }

        for($i=1; $i <= 12; $i++) {
            DB::table('ride_rideable')->insert([
                'rideable_id' => $faker->randomElement($rideablesIds),
                'ride_id' => $faker->randomElement($ridesIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 hours', $endDate = 'now', $timezone = null)
            ]);
        }

    }
}
