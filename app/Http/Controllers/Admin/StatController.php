<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Carbon\Carbon;
use App\Message;
use App\View;
use Auth;
use DB;

class StatController extends Controller
{
    public function show($id){
        $apartment = Apartment::where('id', $id)->first();
        if ($apartment->user_id == Auth::id()) {
            $db_views = DB::table('views')->where('apartment_id', $id)
                    ->select('created_at', DB::raw('count(*) as total'))
                    ->groupBy('created_at')->orderBy('created_at', 'DESC')->limit(24)
                    ->get();
            $temp_views = json_decode($db_views, true);
            $views = [];
            $currentHour = Carbon::now();
            for ($i=0; $i<24; $i++){
                $views[$i]['created_at'] = $currentHour->format('d-m H:00');
                $currentHour = $currentHour->subHours(1);
                if (!array_key_exists($i, $temp_views)){
                    $views[$i]['total'] = '0';
                } else {
                    $views[$i]['total'] = $temp_views[$i]['total'];
                }
            }
            $db_messages = DB::table('messages')
                    ->select('created_at', DB::raw('count(*) as total'))
                    ->groupBy('created_at')->orderBy('created_at', 'DESC')->limit(7)
                    ->get();
            $temp_messages = json_decode($db_messages, true);
            $messages = [];
            $currentDay = Carbon::now()->subDays(3);
            for ($i=0; $i<7; $i++){
                $messages[$i]['created_at'] = $currentDay->format('Y-m-d 00:00:00');
                $currentDay = $currentDay->subDays(1);

                
                $check = $this->isPresent($temp_messages, 'created_at', $messages[$i]['created_at']);
                if($check){
                    $messages[$i]['total'] = $temp_messages[$check]['total'];
                } else {
                    $messages[$i]['total'] = '0';
                }
                // if (!array_key_exists($i, $temp_messages)){
                //     $messages[$i]['total'] = '0';
                // } else {
                //     $messages[$i]['total'] = $temp_messages[$i]['total'];
                // }
            }
            // $messages = DB::table('messages')->groupBy('created_at');

            // $tot_mess = [];

            // return $messages;

            // return $messages[1]->created_at->format('d-m-yy');
            $views = json_encode($views, true);
            $messages = json_encode($messages, true);
            return view('admin.stats', compact('views', 'messages'));
        } else {
            abort(404);
        }
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
