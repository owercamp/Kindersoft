<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    protected $table = "garden";
    protected $primaryKey = "garId";
    protected $fillable = [
                'garReasonsocial',
                'garNamecomercial',
                'garNit',
                'garCity_id',
                'garLocation_id',
                'garDistrict_id',
                'garAddress',
                'garPhone',
                'garPhoneone',
                'garPhonetwo',
                'garPhonethree',
                'garWhatsapp',
                'garWebsite',
                'garMailone',
                'garMailtwo',
                'garNamelogo',
                'garCode', //defaultcode.png
                'garNamerepresentative',
                'garCardrepresentative',
                'garFirm',
                'garNamewitness',
                'garCardwitness',
                'garFirmwitness'
            ];
    public $timestamps = false;

    public function getUrlPathLogo(){
        return \Storage::url($this->garNamelogo);
    }
}

