<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Sponsor;
use App\Apartment;
use Carbon\Carbon;
// use Auth;

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
    Route::get('apartments/{id}/stats', 'StatController@show')->name('stats.show');
    // Route::get('payments', 'PaymentController@checkout')->name('payment');
    // Route::post('payments', 'PaymentController@checkout')->name('payment');
    Route::get('messages', 'MessageController@index')->name('messages.index');
    Route::get('messages/{id}', 'MessageController@show')->name('messages.show');

    //elenco appartamenti
    Route::get('/payments', 'PaymentController@paymentNoId')->name('paymentNoId');
    //appartamento specifico
    Route::get('/payments/{id}', 'PaymentController@paymentWithId')->name('paymentWithId');

    Route::post('/checkout', 'PaymentController@checkout')->name('checkout');

    // Route::get('/hosted', 'PaymentController@paymentNoId');
    // Route::get('/hosted/{id}', 'PaymentController@paymentWithId');
});

Route::post('messages/{apartment_id}', 'Admin\MessageController@store')->name('messages.store');
Route::get('apartments/{id}', 'Admin\ApartmentController@show')->name('apartments.show');
Route::get('search/', 'SearchController@index')->name('search.index');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');


// Route::get('logout', 'Auth\LoginController@logout');
