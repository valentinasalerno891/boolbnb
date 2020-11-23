<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sponsor;
use App\Apartment;
use Carbon\Carbon;
use Auth;

class PaymentController extends Controller
{
     public function paymentNoId(){
          $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $token = $gateway->ClientToken()->generate();
        $sponsors = Sponsor::all();
        $apartments = Apartment::where([['user_id',Auth::id()], ['available', 1]])->get();
     //    return view('admin.checkout', [
     //        'token' => $token
     //    ], compact('sponsors', 'apartments'));
        return view('admin.hosted', [
            'token' => $token
        ], compact('sponsors', 'apartments'));
     }

     public function paymentWithId($id){
          if (Apartment::where('id', $id)->exists()){
            if (Apartment::where('id', $id)->first()->user_id != Auth::id()){
            abort(404);
            }
          } else {
               abort(404);
          }
          $gateway = new \Braintree\Gateway([
               'environment' => config('services.braintree.environment'),
               'merchantId' => config('services.braintree.merchantId'),
               'publicKey' => config('services.braintree.publicKey'),
               'privateKey' => config('services.braintree.privateKey')
          ]);

          $token = $gateway->ClientToken()->generate();
          $sponsors = Sponsor::all();
          $apartment = Apartment::where('id',$id)->first();
          // return view('admin.checkout', [
          //      'token' => $token
          // ], compact('sponsors', 'apartment'));
          return view('admin.hosted', [
            'token' => $token
        ], compact('sponsors', 'apartment'));
     }

     public function checkout(Request $request){
          if ((!Sponsor::where('id', $request->amount)->exists()) || (!Apartment::where([['id',$request->apartment],['user_id',Auth::id()], ['available', 1]])->exists())) {
            return back()->withErrors('Errore nel pagamento');
        }
        $gateway = new \Braintree\Gateway([
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
            'customer' => [
                'firstName' => Auth::user()->name ? Auth::user()->name : '',
                'lastName' => Auth::user()->lastname ? Auth::user()->lastname : '',
                'email' => Auth::user()->email,
            ],
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
                $last_sponsor = Carbon::parse($apartment[0]->sponsors()->orderBy('pivot_end_date', 'desc')->first()->pivot->end_date);
                if($last_sponsor->gt(Carbon::now())){
                    $apartment[0]->sponsors()->attach($request->amount, ['start_date' => $last_sponsor, 'end_date' => Carbon::parse($last_sponsor)->addHours($hours)]);
                } else {
                    $apartment[0]->sponsors()->attach($request->amount, ['start_date' => Carbon::now(), 'end_date' => Carbon::now()->addHours($hours)]);
                }
            } else {
                $apartment[0]->sponsors()->attach($request->amount, ['start_date' => Carbon::now(), 'end_date' => Carbon::now()->addHours($hours)]);
            }
            // header("Location: transaction.php?id=" . $transaction->id);

            return back()->with('success_message', 'Pagamento effettuato. Sono state aggiunte '.$hours.' ore di sponsorizzazione all\'appartamento "'.$apartment[0]->title.'"');
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }

            // $_SESSION["errors"] = $errorString;
            // header("Location: index.php");
            return back()->withErrors('Errore nel pagamento'.$result->message);
        }
     }
}
