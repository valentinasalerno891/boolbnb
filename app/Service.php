<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
    ];

    //Evitare l'errore per inserimento voci timestamps 'created_at' e 'updated_at'
    public $timestamps = false;

    //Relazione molti a molti (* servizi * appartamento)
    public function apartments(){
        return $this->belongsToMany('App\Apartment');
    }
}
