<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Message;
use App\View;
use Auth;
use DB;

class StatController extends Controller
{
    public function show($id){
        $apartment = Apartment::where('id', $id)->first();
        if ($apartment->user_id == Auth::id()) {
            $views = View::where('apartment_id', $id)->get();
            $messages = DB::table('messages')
                    ->select('created_at', DB::raw('count(*) as total'))
                    ->groupBy('created_at')->orderBy('created_at', 'ASC')->limit(7)
                    ->get();
            // $messages = DB::table('messages')->groupBy('created_at');

            // $tot_mess = [];

            // return $messages;

            // return $messages[1]->created_at->format('d-m-yy');
            return view('admin.stats', compact('views', 'messages'));
        } else {
            abort(404);
        }
    }
}
