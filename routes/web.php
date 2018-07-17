<?php

Auth::routes();

Route::GET('/', 'RideableController@home')->name('home');
Route::GET('/drivers', 'DriverController@index')->name('drivers');
Route::POST('/driver/store', 'DriverController@store')->name('add.driver');
Route::POST('/driver/save', 'DriverController@update')->name('save.driver');
Route::GET('/trucks', 'TruckController@index')->name('trucks');
Route::POST('/truck/store', 'TruckController@store')->name('add.truck');
Route::POST('/truck/save', 'TruckController@update')->name('save.truck');
Route::GET('/ride/create/{rideable}', 'RideController@create');
Route::POST('/ride/attach/', 'RideController@attach')->name('attachRide');
Route::GET('/ride/detach/{ride}/{rideable}', 'RideController@detach')->name('detachRide');
Route::POST('/rideable/store', 'RideableController@store')->name('add.rideable');
Route::GET('/rideable/{rideable}/{status}', 'RideableController@status')->name('status');
Route::GET('/location', 'LocationController@index')->name('clients');
Route::GET('/fillups', 'FillupController@index')->name('fillups');
Route::GET('/t', function(){
    return view('theme');
});
Route::GET('/{type}', 'RideableController@list');
