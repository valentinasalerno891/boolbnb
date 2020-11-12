<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;
    
    //Relazione uno a molti ( 1 categoria * appartamenti)  
    public function apartments(){
        return $this->hasMany('App\Apartment');
    }
}
