<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    protected $table = "attendants";

    protected $fillable = [
    	'id',
    	'typedocument_id',
    	'numberdocument',
    	'firstname',
    	'threename',
    	'fourname',
    	'address',
    	'cityhome_id',
        'locationhome_id',
        'dictricthome_id',
    	'phoneone',
    	'phonetwo',
    	'whatsapp',
    	'emailone',
    	'emailtwo',
    	'bloodtype_id',
    	'gender',
    	'profession_id',
    	'company',
    	'position',
    	'antiquity',
    	'addresscompany',
    	'citycompany_id',
    	'locationcompany_id',
    	'dictrictcompany_id',
    ];

    public $timestamps = false;
}
