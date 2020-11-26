<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentSponsor extends Model
{
    protected $table = 'apartment_sponsor';

    public function sponsorApartments(){
        return $this->hasOne('App\Apartment', 'id', 'apartment_id');
    }
}
