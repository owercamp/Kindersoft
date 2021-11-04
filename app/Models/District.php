<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "districts";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','location_id'
    ];

    public $timestamps = false;

    // CADA BARRIO PERTENECE A UNA LOCALIDAD
    public function location(){
        return $this->belongsTo(location::class,'location_id');
    }
}
