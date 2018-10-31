<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'Vafa', 'email' => 'goreyshi@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Abraham', 'email' => 'abrahamkha@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Ali', 'email' => 'ali@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Eddy', 'email' => 'eddyl@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Erika', 'email' => 'Erekav@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Joe', 'email' => 'joel@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Larry', 'email' => 'larryg@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        DB::table('users')->insert(['name' => 'Mandy', 'email' => 'mandy@'.env('APP_URL','gmail.com'), 'password' => bcrypt('123123'), 'remember_token' => str_random(10), ]);
        $this->call(trackerTableSeeder::class);
    }
}
