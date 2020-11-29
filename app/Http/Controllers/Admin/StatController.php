<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Carbon\Carbon;
use App\Message;
use App\View;
use Auth;
use DB;

class StatController extends Controller
{
    public function show($id){
        //selezioni appartamento
        $apartment = Apartment::where('id', $id)->first();
        //controllo che appartenga all'utente loggato
        if ($apartment->user_id == Auth::id()) {
            //seleziona dati views dal db
            $db_views = DB::table('views')->where('apartment_id', $id)
                    ->select('created_at', DB::raw('count(*) as total'))
                    ->groupBy('created_at')->orderBy('created_at', 'DESC')->limit(24)
                    ->get();
            $temp_views = json_decode($db_views, true);
            //array con statistiche delle ultime 24 ore
            $views = [];
            $currentHour = Carbon::now()->timezone('Europe/Rome')->format('d-M-Y H:00:00');

            for ($i=0; $i<24; $i++){
                //creo nell'array views un elemento con data di creazione= a current hour
                $views[$i]['created_at'] = Carbon::parse($currentHour)->format('d-M-Y H:00:00');
                $currentHour = Carbon::parse($currentHour)->subHours(1);
                //controllo se l'ora dell'elemento è presente nel db
                $check = $this->isPresent($temp_views, 'created_at', Carbon::parse($views[$i]['created_at'])->format('d-M-Y H:00:00'));

                if($check !== false){
                    $views[$i]['total'] = $temp_views[$check]['total']; //se è presente gli assegno il valore di views restituito dal db
                } else {
                    $views[$i]['total'] = '0'; //altrimenti assegno 0
                }
            }
            //stessa procedura per i messaggi, ma vengono considerati gli ultimi 7 giorni anzichè le 24 ore
            $db_messages = DB::table('messages')->where('apartment_id', $id)
                    ->select('created_at', DB::raw('count(*) as total'))
                    ->groupBy('created_at')->orderBy('created_at', 'DESC')->limit(7)
                    ->get();
            $temp_messages = json_decode($db_messages, true);
            $messages = [];
            $currentDay = Carbon::now()->timezone('Europe/Rome');
            $check_list = [];
            for ($i=0; $i<7; $i++){
                $messages[$i]['created_at'] = $currentDay->format('d-M-Y');
                $currentDay = $currentDay->subDays(1);
                $check = $this->isPresent($temp_messages, 'created_at', $messages[$i]['created_at']);
                array_push($check_list, $check);
                if($check !== false){
                    $messages[$i]['total'] = $temp_messages[$check]['total'];
                } else {
                    $messages[$i]['total'] = '0';
                }

            }
            $views = json_encode($views, true);
            $messages = json_encode($messages, true);
            return view('admin.stats', compact('views', 'messages', 'apartment'));
        } else {
            abort(404);
        }
    }

    function isPresent($array, $keys, $val) {
        foreach ($array as $key => $item){
            if (isset($item[$keys]) && $item[$keys] == $val){
                return $key;
            }
        }
        return false;
    }
}
