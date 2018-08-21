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

        view()->composer('layouts.app', function ($view)
        {
            // get all rideable who dosnt have ride yet.
            $unasignedRideable = \App\Rideable::where('status','Created')
                    ->doesntHave('rides')
                    ->where('type', '!=', 'DropOff')->get();
                    // ->whereHas('location',function($q){
                    //     $q->where('type', 'Client');
                    // });
            $view->with(compact('unasignedRideable'));
            // dd($unasignedRideable);
            // dd($unasignedRideable->count());
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
