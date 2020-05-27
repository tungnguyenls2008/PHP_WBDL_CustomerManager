<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

//tao group route customers
Route::group(['prefix' => 'customers'], function () {
    Route::get('/','CustomerController@index')->name('customers.index');
    Route::get('/create','CustomerController@create')->name('customers.create');
    Route::post('/create','CustomerController@store')->name('customers.store');
    Route::get('/{id}/edit','CustomerController@edit')->name('customers.edit');
    Route::post('/{id}/edit','CustomerController@update')->name('customers.update');
    Route::get('/{id}/destroy','CustomerController@destroy')->name('customers.destroy');
});
