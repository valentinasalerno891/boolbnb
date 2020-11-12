<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Apartment extends Model
{

    protected $fillable = [
        'title', 'rooms', 'beds', 'bathrooms', 'square_meters', 'image', 'description', 'latitude', 'longitude', 'available', 'user_id', 'category_id'
    ];

    //Relazione molti a uno (* appartamenti 1 user )
    public function user(){
        return $this->belongsTo('App\User');
    }

    //Relazione uno a molti (1 appartamento * messaggi)
    public function messages(){
        return $this->hasMany('App\Message');
    }

     //Relazione molti a molti (* appartamento * sponsor)
    public function sponsors(){
        return $this->belongsToMany('App\Sponsor')->withPivot('start-date', 'end-date');
    }

    //Relazione molti a molti (* appartamento * servizi)
    public function services(){
        return $this->belongsToMany('App\Service');
    }

    //Relazione molti a uno (* appartamenti 1 categoria )
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
