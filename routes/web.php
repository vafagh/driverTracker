<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/t', function(){
    return view('theme');
});
