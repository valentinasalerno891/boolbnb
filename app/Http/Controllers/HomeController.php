<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApartmentSponsor;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //con join unisce i dati delle tabelle specificate e seleziona i dati in base alle clausole del where per prendere gli appartamenti sponsorizzati e visibili
        $temp_apartments = ApartmentSponsor::select('*')->join('apartments', 'apartments.id', '=', 'apartment_sponsor.apartment_id')->where([['available', 1],['start_date', '<=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')],['end_date', '>=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')]])->get();

        $apartments = [];
        $rands = [];

        //ne vogliamo prendere max 6
        if (count($temp_apartments)>6){
            $var = 6;
        } else {
            $var = count($temp_apartments);
        }
        //li prendiamo senza che si ripetano e in modo randomico
        while (count($apartments) < $var){
            $rand = rand(0,count($temp_apartments)-1);
            if (!in_array($rand, $rands)){
                array_push($rands, $rand);
                $temp_apartments[$rand]->description = substr($temp_apartments[$rand]->description, 0, 100)."...";
                array_push($apartments, $temp_apartments[$rand]);
            }
        }
        return view('home', compact('apartments'));
    }
}
