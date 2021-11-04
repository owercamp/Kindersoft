<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturation extends Model
{
    protected $table = "facturations";
    protected $primaryKey = "facId";
    protected $fillable = [
            'facCode',
            'facDateInitial',
            'facDateFinal',
            'facValue',
            'facValueCopy',
            'facCountVoucher',
            'facLegalization_id',
            'facConcepts',
            'facPorcentageIva',
            'facValuediscount',
            'facValueIva',
            'facStatus',
            'facArgument'
        ];
    public $timestamps = false;
}
