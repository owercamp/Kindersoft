<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = "journeys";
    protected $fillable = [
        'id','jouJourney','jouDays','jouHourEntry','jouHourExit','jouValue'
    ];
    public $timestamps = false;
}
