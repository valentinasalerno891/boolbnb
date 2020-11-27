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
        $temp_apartments = ApartmentSponsor::select('*')->where([['start_date', '<=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')],['end_date', '>=' ,Carbon::now()->timezone('Europe/Rome')->format('Y-m-d H:i:s')]])->get();
        // $rands = [];
        $apartments = [];
        $rands = [];
        if (count($temp_apartments)>6){
            $var = 6;
        } else {
            $var = count($temp_apartments);
        }
        while (count($apartments)<$var){
            $rand = rand(0,count($temp_apartments)-1);
            if (!in_array($rand, $rands)){
                array_push($rands, $rand);
                array_push($apartments, $temp_apartments[$rand]);
            }
        }
        return view('home', compact('apartments'));
    }
}
