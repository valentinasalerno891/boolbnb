<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'email', 'title', 'body','apartment_id', 'created_at', 'hour'
    ];

    //Relazione molti a uno (* messaggi 1 appartamento) 
    public function apartment(){
        return $this->belongsTo('App\Apartment');
    }
}
