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

// Rotte di collegamento fra le pagine
Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function () {
    Route::resource('apartments', 'ApartmentController',['only' => [ 'index', 'create', 'store', 'update', 'destroy', 'edit' ] ]);
    Route::get('stats/{id}', 'StatController@show')->name('stats.show');
    Route::get('payment/{id}', 'PaymentController@payment')->name('payment');
    Route::get('messages', 'MessageController@index')->name('messages.index');
    Route::get('messages/{id}', 'MessageController@show')->name('messages.show');
});

Route::post('messages/{apartment_id}', 'Admin\MessageController@store')->name('messages.store');
Route::get('apartments/{id}', 'Admin\ApartmentController@show')->name('apartments.show');
Route::get('search/', 'SearchController@index')->name('search.index');

Route::get('/', function () {
    return view('index')->name('homepage');
});

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('logout', 'Auth\LoginController@logout');
