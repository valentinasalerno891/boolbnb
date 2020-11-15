<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Service;

class ApartmentController extends Controller
{
    public function index(Request $request){
        $apartments = Apartment::where([['rooms','>=', $request->rooms], ['beds','>=' , $request->beds]])->get();
        $result = [];
        $services_ids = Service::all()->pluck('id');
        $requested_services = [];
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
                array_push($result, $apartments[$x]);
            }
        }
        return response()->json($result, 200);
    }
}
