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
            $activeDrivers = \App\Driver::with('rides','rides.rideable','rides.truck')
                    ->where('truck_id','!=',null)
                    ->get();
                    
            $view->with(compact('activeDrivers'));
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
