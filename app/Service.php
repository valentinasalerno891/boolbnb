<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //Relazione molti a molti (* servizi * appartamento)
    public function apartments(){
        return $this->belongsToMany('App\Apartment');
    }
}
