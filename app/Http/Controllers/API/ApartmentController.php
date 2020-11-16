<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Apartment;
use App\Service;

class ApartmentController extends Controller
{
    public function index(Request $request){
        $apartments = Apartment::where([['rooms','>=', $request->rooms], ['beds','>=' , $request->beds], ['available', 1]])->get();
        $result = [];
        $services_ids = Service::all()->pluck('id');
        $requested_services = [];
        $lat_search = $request->latitude;
        $lon_search = $request->longitude;
        for ($i = 0; $i<count($services_ids); $i++){
            if ($request[$services_ids[$i]] == '1'){
                array_push($requested_services, $services_ids[$i]);
            }
        }
        for ($x = 0; $x<count($apartments); $x++){
            $temp_id = [];
            for ($i = 0; $i<count($apartments[$x]->services); $i++){
                array_push($temp_id, $apartments[$x]->services[$i]);
            }
            $apartments_services = array_column($temp_id, 'id');
            if ((array_intersect($requested_services, $apartments_services)) == $requested_services){
                $lat_app = $apartments[$x]->latitude;
                $lon_app = $apartments[$x]->longitude;
                $client = new Client([
                    'base_uri' => 'https://api.tomtom.com/routing/1/calculateRoute/'.$lat_search.','.$lon_search.':'.$lat_app.','.$lon_app.'/json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ',
                ]);
                $response = $client->get('https://api.tomtom.com/routing/1/calculateRoute/'.$lat_search.','.$lon_search.':'.$lat_app.','.$lon_app.'/json?key=wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ');
                $data = json_decode($response->getBody());
                $km_distance = ($data->routes[0]->legs[0]->summary->lengthInMeters)/1000;
                if ($km_distance<=$request->distance){
                    array_push($result, $apartments[$x]);
                }
                
            }
        }
        return response()->json($result, 200);
    }
}
