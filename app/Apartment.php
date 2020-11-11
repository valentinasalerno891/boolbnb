<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{

    protected $fillable = [
        'title', 'rooms', 'beds', 'bathrooms', 'square_meters', 'image', 'description', 'latitude', 'longitude', 'available', 'user_id'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function sponsors(){
        return $this->belongsToMany('App\Sponsor')->withPivot('start-date', 'end-date');
    }

    public function services(){
        return $this->belongsToMany('App\Service');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
