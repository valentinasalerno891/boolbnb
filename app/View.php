<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'created_at', 'apartment_id'
    ];
}
