<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class SearchController extends Controller
{
    public function index(){
        $services = Service::all();
        return view('search', compact('services'));
    }
}
