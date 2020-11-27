<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Apartment;
use Carbon\Carbon;
use App\Service;
use App\ApartmentSponsor;

class ApartmentController extends Controller
{
    public function index(Request $request){
        // appartamenti filtrati per stanze, letti e disponibilità
        $apartments = Apartment::where([['rooms','>=', $request->rooms], ['beds','>=' , $request->beds], ['available', 1]])->get();
        $result = [];
        $requested_services = [];

        $temp_spon_apartments = ApartmentSponsor::select('*')->where([['start_date', '<=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')],['end_date', '>=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')]])->get();
        // $rands = [];
        // $apartments_spon = [];
        $rands = [];
        if (count($temp_spon_apartments)>3){
            $var = 3;
        } else {
            $var = count($temp_spon_apartments);
        }
        $i = 0;
        while ($i<$var){
            $rand = rand(0,count($temp_spon_apartments)-1);
            if (!in_array($rand, $rands)){
                array_push($rands, $rand);
                $temp_spon_apartments[$rand]->sponsorApartments['sponsored'] = '1';
                $temp_spon_apartments[$rand]->sponsorApartments['image'] = Storage::url($temp_spon_apartments[$rand]->sponsorApartments->image);
                array_push($result, $temp_spon_apartments[$rand]->sponsorApartments);
                $i++;
            }
        }


        $request->distance = ($request->distance > 200) ? 200 : $request->distance;
        $earthRadius = 6371;
        // convert from degrees to radians
        $latFrom = deg2rad($request->latitude);
        $lonFrom = deg2rad($request->longitude);
        // creo un array contente tutti gli ID dei servizi presenti sul DB
        $services_ids = Service::all()->pluck('id');
        // popolo l'array con gli ID dei servizi richiesti nella ricerca
        for ($i = 0; $i<count($services_ids); $i++){
            if ($request[$services_ids[$i]] == '1'){
                array_push($requested_services, $services_ids[$i]);
            }
        }

        for ($x = 0; $x<count($apartments); $x++){
            // creo array con gli ID dei servizi dell'appartamento in questione
            $temp_id = [];
            for ($i = 0; $i<count($apartments[$x]->services); $i++){
                array_push($temp_id, $apartments[$x]->services[$i]);
            }
            $apartments_services = array_column($temp_id, 'id');

            if ((array_intersect($requested_services, $apartments_services)) == $requested_services){ // controllo se l'appartamento in questione possiede tutti i servizi richiesti
                // salvo latitudine e longitudine dell'appartamento in questione
                $lat_app = $apartments[$x]->latitude;
                $lon_app = $apartments[$x]->longitude;

                // ============ METODO CON TOM TOM
                // // chiamata API per calcolare la distanza tra l'appartamento e la città cercata
                // $client = new Client([
                //     'base_uri' => 'https://api.tomtom.com/routing/1/calculateRoute/'.$lat_search.','.$lon_search.':'.$lat_app.','.$lon_app.'/json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ',
                // ]);
                // $response = $client->get('https://api.tomtom.com/routing/1/calculateRoute/'.$lat_search.','.$lon_search.':'.$lat_app.','.$lon_app.'/json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ');
                // $data = json_decode($response->getBody());
                // // converto la distanza (restuita in metri) in km
                // $km_distance = ($data->routes[0]->legs[0]->summary->lengthInMeters)/1000;
                // controllo che la distanza sia minore o uguale a quella impostata dall'utente


                // ======== METODO CALCOLANDO LA DISTANZA
                //convert from degrees to radians
                $latTo = deg2rad($lat_app);
                $lonTo = deg2rad($lon_app);

                $lonDelta = $lonTo - $lonFrom;
                $a = pow(cos($latTo) * sin($lonDelta), 2) +
                    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
                $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

                $angle = atan2(sqrt($a), $b);
                $distance = $angle * $earthRadius;



                 
                // ============ METODO CON TOM TOM
                // if ($km_distance<=$request->distance){
                //     $apartments[$x]['distance'] = round($km_distance,2);
                //     $apartments[$x]['route'] = route('apartments.show', $apartments[$x]->id);
                //     array_push($result, $apartments[$x]); // pusho l'appartamento nell'array result
                // }

                // ======== METODO CALCOLANDO LA DISTANZA
                if ($distance<=$request->distance && !$this->isPresent($result, 'id', $apartments[$x]['id'])){
                    $apartments[$x]['distance'] = round($distance,2);
                    $apartments[$x]['route'] = route('apartments.show', $apartments[$x]->id);

                    $apartments[$x]['image'] = Storage::url($apartments[$x]->image);

                    array_push($result, $apartments[$x]); // pusho l'appartamento nell'array result
                }
            }
        }
        usort($result,function($a,$b){
            return $a['distance']-$b['distance'];
        });

        return response()->json($result, 200);
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
