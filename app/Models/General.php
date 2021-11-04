<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $table = "facturaciongeneral";
	protected $primaryKey = "fgId";
    protected $fillable = [
    	'fgRegime',
    	'fgTaxpayer',
    	'fgAutoretainer',
    	'fgActivityOne',
    	'fgActivityTwo',
    	'fgActivityThree',
    	'fgActivityFour',
    	'fgResolution',
    	'fgDateresolution',
    	'fgMountactive',
    	'fgDatefallresolution',
    	'fgPrefix',
    	'fgNumerationsince',
    	'fgNumerationuntil',
    	'fgBank',
    	'fgAccounttype',
    	'fgNumberaccount',
    	'fgNotes'
    ];
	public $timestamps = false;
}
