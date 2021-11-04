<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Legalization;
use App\Models\Concept;
use App\Models\Facturation;

class FacturationTramitedExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $year;
    protected $mount;

    function __construct($year,$mount){
    	$this->year = $year;
    	$this->mount = $mount;
    }

    public function view(): View
    {
    	$tramited = Facturation::select(
    					'facturations.*',
    					'legalizations.legId',
    					DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    				)
    				->join('legalizations','legalizations.legId','facturations.facLegalization_id')
    				->join('students','students.id','legalizations.legStudent_id')
            		->whereBetween('facDateInitial',[$this->year . "-" . $this->mount . "-01",$this->year . "-" . $this->mount . "-" . date('t', strtotime($this->year . '-' . $this->mount . '-15'))])
            		->where('facStatus','PAGADO')
    				->orderBy('facDateInitial','asc')->get();
    	return view('modules.accounts.facturationTramitedExcel', compact('tramited'));
    }

    function numberDaysOfmount($mount,$year){
		$days = date("t", strtotime($year . '-' . $mount . '-15'));
		return $days;
		//dd(cal_days_in_month(CAL_GREGORIAN,$mount,$year));
		//return cal_days_in_month(CAL_GREGORIAN,$mount,$year);
	}
}
