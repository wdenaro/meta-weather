<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'weatherController@index')
    ->name('dash.index');
