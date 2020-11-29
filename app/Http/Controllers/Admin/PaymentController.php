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

     // funzione che resituisce la view con l'elenco degli appartamenti quando nell'URL non viene specificato un ID
     public function paymentNoId(){
          //creazione gateway pagamento
          $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
          ]);
        // creazione token
        $token = $gateway->ClientToken()->generate();
        $sponsors = Sponsor::all();
        $apartments = Apartment::where('user_id', Auth::id())->get();

        return view('admin.hosted', ['token' => $token], compact('sponsors', 'apartments'));
     }

     // funzione che resituisce la view con il titolo dell'appartamento con ID indicato nell'URL
     public function paymentWithId($id){
          if (Apartment::where('id', $id)->exists()){ // controllo che l'appartamento esista nel DB
            if (Apartment::where('id', $id)->first()->user_id != Auth::id()){ // controllo che l'appartamento appartenga all'utente loggato
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

          return view('admin.hosted', ['token' => $token], compact('sponsors', 'apartment'));
     }

     public function checkout(Request $request){
          // controllo che l'ID dello sponsor passato nella richiesta esista nel DB e l'ID dell'appartamento passato appartenga all'utente loggato e sia disponibile
          if ((!Sponsor::where('id', $request->amount)->exists()) || (!Apartment::where([['id',$request->apartment],['user_id',Auth::id()]])->exists())) {
            return back()->withErrors('Errore nel pagamento');
        }
        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);
        $amount = Sponsor::where('id', $request->amount)->get('price'); // prendo il prezzo che devo pagare
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
        if ($result->success) { // controllo che la transazione venga effettuata
            $transaction = $result->transaction;

            // prendo le ore di sponsor per cui ho pagato
            $temp_hours = Sponsor::where('id', $request->amount)->get('duration');
            $hours = $temp_hours[0]->duration;

            $apartment = Apartment::where('id', $request->apartment)->get(); // prendo l'appartamento con l'ID della richiesta

            if ($apartment[0]->available == 0) {
                $data['available'] = 1;
                $apartment[0]->update($data);
            }

            if ($apartment[0]->sponsors()->exists()){ // controllo se l'appartamento esiste già nella tabella sponsor
                $last_sponsor = Carbon::parse($apartment[0]->sponsors()->orderBy('pivot_end_date', 'desc')->first()->pivot->end_date); // data e ora di fine dell'ultima sponsorizzazione dell'appartamento in questione
                if($last_sponsor->gt(Carbon::now()->timezone('Europe/Rome'))){ // controllo se $last_sponsor è piu avanti nel tempo di now();
                    // creo un record di sponsorizzazione con data di inizio = $last_sponsor e data di fine = $last_sponsor + ore di sponsors pagate
                    $apartment[0]->sponsors()->attach($request->amount, ['start_date' => $last_sponsor, 'end_date' => Carbon::parse($last_sponsor)->timezone('Europe/Rome')->addHours($hours)]);
                } else {
                    // creo un record di sponsorizzazione con data di inizio = now() e data di fine = now() + ore di sponsors pagate
                    $apartment[0]->sponsors()->attach($request->amount, ['start_date' => Carbon::now(), 'end_date' => Carbon::now()->timezone('Europe/Rome')->addHours($hours)]);
                }
            } else {
               // creo un record di sponsorizzazione con data di inizio = now() e data di fine = now() + ore di sponsors pagate
               $apartment[0]->sponsors()->attach($request->amount, ['start_date' => Carbon::now(), 'end_date' => Carbon::now()->timezone('Europe/Rome')->addHours($hours)]);
            }
            return back()->with('success_message', 'Pagamento effettuato. Sono state aggiunte '.$hours.' ore di sponsorizzazione all\'appartamento "'.$apartment[0]->title.'"');
        } else {
            $errorString = "";
            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            return back()->withErrors('Errore nel pagamento'.$result->message);
        }
     }
}
