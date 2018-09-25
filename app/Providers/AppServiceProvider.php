<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(['home','layouts.navs.accordion','map'], function ($view)
        {
            // get all rideable who dosnt have ride yet.
            $activeDrivers = \App\Driver::where('truck_id','!=',null)->get();
            $view->with(compact('activeDrivers'));
            // dd($activeDrivers);
            // dd($activeDrivers->count());
        });

    }

    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        //
    }
}
