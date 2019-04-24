<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

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

        view()->composer(['home','layouts.menu','map','layouts.components.create.service','layouts.components.create.fillup'], function ($view)
        {
            $activeDrivers = \App\Driver::with('rides','rides.truck')
                    ->where('truck_id','!=',null)
                    ->get();

            $view->with(compact('activeDrivers'));
        });

        // DB::listen(function ($query) {
        //     var_dump([
        //         $query->sql,
        //         // $query->bindings,
        //         $query->time
        //     ]);
        // });

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
