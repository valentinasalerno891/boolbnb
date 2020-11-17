<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'email', 'title', 'body','apartment_id'
    ];

    //Relazione molti a uno (* messaggi 1 appartamento) 
    public function apartment(){
        return $this->belongsTo('App\Apartment');
    }
}
