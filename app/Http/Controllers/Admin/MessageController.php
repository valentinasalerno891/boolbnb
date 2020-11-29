<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Message;

class MessageController extends Controller
{
    //Ritorna la view con la lista dei messaggi dello user loggato
    public function index(){
        $apartments = Apartment::where('user_id', Auth::id())->get();
        return view('admin.messages.index', compact('apartments'));
    }

    //Ritorna la view con i dettagli del messaggio selezionato
    public function show($id)
    {
        $message = Message::where('id',$id)->first();
        return view('admin.messages.show',compact('message'));
    }

    //Invio messaggio al proprietario dell'appartamento
    public function store(Request $request, $apartment_id)
    {
        $data = $request->all();
        $request->validate([
            'email' =>  'required',
            'title' =>  'required|min:5|max:50',
            'body' =>  'required|min:20|max:2000',
        ]);
        //salvataggio dati sul db:
        $data['apartment_id']=$apartment_id;

        $data['created_at']= Carbon::now()->format('d-M-Y');
        $data['hour']= Carbon::now()->timezone('Europe/Rome')->format('h:i:s');

        $message = new Message();

        $message->fill($data);

        $message->save();
        
        return redirect()->route('apartments.show',$apartment_id)->with('status', 'Messaggio inviato correttamente.');
    }
}
