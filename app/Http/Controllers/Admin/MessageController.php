<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Illuminate\Support\Facades\Auth;
use App\Message;

class MessageController extends Controller
{
    public function index(){
        $apartments = Apartment::where('user_id', Auth::id())->get();
        return view('admin.messages.index', compact('apartments'));
    }

    public function show($id)
    {
        $message = Message::where('id',$id)->first();
        return view('admin.messages.show',compact('message'));
    }
}
