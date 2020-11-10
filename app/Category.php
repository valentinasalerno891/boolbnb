<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function apartments(){
        return $this->hasMany('App\Apartment');
    }
}
