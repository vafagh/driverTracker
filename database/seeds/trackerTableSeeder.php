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
        factory(Driver::class, 5)->create();
        factory(Location::class, 40)->create();
        factory(Rideable::class, 10)->create();
        factory(Ride::class, 11)->create();
        $faker = Faker::create();
        $rideablesID = Rideable::pluck('id')->all();
        $locationsID = Location::pluck('id')->all();

        for($i=1; $i <= 30; $i++) {

            DB::table('location_rideable')->insert([
                'Rideable_id' => $faker->randomElement($rideablesID),
                'location_id' => $faker->randomElement($locationsID)
            ]);


        }

    }
}
