<?php

use Illuminate\Database\Seeder;
use App\Address;
use App\Client;
use App\Driver;
use App\Delivery;
use App\Pickup;
use App\Ride;
use App\Truck;
use App\User;
use App\Warehouse;

class trackerTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Truck::class, 7)->create();
        factory(App\Driver::class, 7)->create();
        factory(App\Client::class, 20)->create();
        factory(App\Warehouse::class, 8)->create();
        factory(App\Delivery::class, 300)->create();
        factory(App\Pickup::class, 10)->create();
    }
}
