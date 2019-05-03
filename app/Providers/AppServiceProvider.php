<?php

namespace App\Providers;

use Carbon\Carbon;
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

            $today = new Carbon();
            $tomorrow = new Carbon('tomorrow');
            $dates = array(
                'today' => $today->format('Y-m-d'),
                'tomorrow' => $tomorrow->format('Y-m-d'),
                'firstDayOfWeek' => Carbon::now()->startOfWeek()->format('Y-m-d'),
                'firstDayOfMonth' => Carbon::now()->startOfMonth()->format('Y-m-d')
            );
            $view->with(compact('activeDrivers','dates'));
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
