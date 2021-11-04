<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = "providers";

    protected $fillable = [
    	'id',
    	'typedocument_id',
    	'numberdocument',
    	'numbercheck',
    	'namecompany',
    	'address',
    	'cityhome_id',
        'locationhome_id',
        'dictricthome_id',
    	'phoneone',
    	'phonetwo',
    	'whatsapp',
    	'emailone',
    	'emailtwo'
    ];

    public $timestamps = false;

}
