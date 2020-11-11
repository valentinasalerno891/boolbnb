<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Auth::routes();


Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function () {
    Route::resource('apartments', 'ApartmentController');
    Route::get('stats/{id}', 'StatController@show')->name('stats.show');
    Route::get('payment/{id}', 'PaymentController@payment')->name('payment');
    Route::get('messages', 'MessageController@index')->name('messages.index');
    Route::get('messages/{id}', 'MessageController@show')->name('message.show');
});


Route::get('/', function () {
    return view('index')->name('homepage');
});

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('logout', 'Auth\LoginController@logout');


