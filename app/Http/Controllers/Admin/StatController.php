<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\View;
use App\Message;

class StatController extends Controller
{
    public function show($id){
        // seleziono tramite chiave esterna views e messaggi relativi all'appartamento selzionato
        $views = View::where('apartment_id', $id)->get();
        $messages = Message::where('apartment_id', $id)->get();
        return view('admin.stats', compact('views', 'messages'));
    }
}
