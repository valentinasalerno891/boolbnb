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

    Route::get('/payments', function () {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->ClientToken()->generate();
    $sponsors = Sponsor::all();
    $apartments = Apartment::where([['user_id',Auth::id()], ['available', 1]])->get();
    return view('admin.checkout', [
        'token' => $token
    ], compact('sponsors', 'apartments'));
});

Route::post('/checkout', function (Request $request) {
    if ((!Sponsor::where('id', $request->amount)->exists()) || (!Apartment::where([['id',$request->apartment],['user_id',Auth::id()], ['available', 1]])->exists())) {
        abort(404);
    }
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $amount = Sponsor::where('id', $request->amount)->get('price');
    $nonce = $request->payment_method_nonce;

    $result = $gateway->transaction()->sale([
        'amount' => $amount[0]->price,
        'paymentMethodNonce' => $nonce,
        // 'customer' => [
        //     'firstName' => 'Tony',
        //     'lastName' => 'Stark',
        //     'email' => 'tony@avengers.com',
        // ],
        'options' => [
            'submitForSettlement' => true
        ]
    ]);

    if ($result->success) {
        $transaction = $result->transaction;
        // $user->parks()->attach($park->id, ['weather' => $weather->id]);
        $temp_hours = Sponsor::where('id', $request->amount)->get('duration');
        $hours = $temp_hours[0]->duration;
        $apartment = Apartment::where('id', $request->apartment)->get();
        if ($apartment[0]->sponsors()->exists()){
            // $apartment = $apartment[0]->load(['sponsors' => function ($q) {
            //     $q->orderBy('apartment_sponsor.id','desc');
            // }]);
            $apartment = $apartment[0]->sponsors()->orderBy('pivot_end-date', 'desc')->get();
            dd($apartment);
        } else {
            $apartment[0]->sponsors()->attach($request->amount, ['start-date' => Carbon::now(), 'end-date' => Carbon::now()->addHours($hours)]);
        }
        // header("Location: transaction.php?id=" . $transaction->id);

        return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
    } else {
        $errorString = "";

        foreach ($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        // $_SESSION["errors"] = $errorString;
        // header("Location: index.php");
        return back()->withErrors('An error occurred with the message: '.$result->message);
    }
});

Route::get('/hosted', function () {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->ClientToken()->generate();

    return view('hosted', [
        'token' => $token
    ]);
});
});

Route::post('messages/{apartment_id}', 'Admin\MessageController@store')->name('messages.store');
Route::get('apartments/{id}', 'Admin\ApartmentController@show')->name('apartments.show');
Route::get('search/', 'SearchController@index')->name('search.index');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('home');
});


// Route::get('logout', 'Auth\LoginController@logout');
