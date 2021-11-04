<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";
    
    protected $fillable = [
        'id','name', 'city_id'
    ];

    public $timestamps = false;

    // CADA LOCALIDAD PERTENECE A UNA CIUDAD
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
}
