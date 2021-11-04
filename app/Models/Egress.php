<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $table = "voucheregress";
	protected $primaryKey = "vegId";
    protected $fillable = [
    	'vegCode',
    	'vegProvider_id',
    	'vegConcept',
    	'vegDate',
    	'vegSubpay',
    	'vegIva',
    	'vegValueiva',
    	'vegRetention',
    	'vegValueretention',
        'vegReteica',
        'vegValuereteica',
    	'vegPay',
        'vegCoststructure_id',
        'vegCostdescription_id'
    ];
	public $timestamps = false;
}
