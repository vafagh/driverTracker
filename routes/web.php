<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/drivers', 'DriverController@index')->name('drivers');
Route::get('/drivers/add', 'DriverController@add')->name('add.driver');
Route::get('/trucks', 'TruckController@index')->name('trucks');
Route::get('/trucks/add', 'TruckController@add')->name('add.truck');
Route::get('/clients', 'LocationController@index')->name('clients');
Route::get('/clients/add', 'LocationController@add')->name('add.client');
Route::get('/warehouses', 'LocationController@index')->name('warehouses');
Route::get('/warehouses/add', 'LocationController@add')->name('add.warehouses');
Route::get('/fillups', 'FillupController@index')->name('fillups');
Route::get('/fillups/add', 'FillupController@add')->name('add.fillups');
Route::get('/t', function(){
    return view('theme');
});
