<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Entry;

class VoucherentryExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // use Exportable;
    protected $dateInitial; 
    protected $dateFinal; 

    function __construct($dateInitial,$dateFinal){
    	$this->dateInitial = $dateInitial;
    	$this->dateFinal = $dateFinal;
    }

    public function view(): View
    {
        return view('modules.vouchers.entryExcel', [
        	'vouchers' => Entry::select(
	            	'voucherentrys.*',
	                DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
	        		'documents.type as typeDocument',
	        		'students.numberdocument as documentStudent',
	        		DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
	        		'attendants.numberdocument as documentAttendant',
	        		'facturations.facCode'
	            )
	            ->join('students','students.id','voucherentrys.venStudent_id')
	            ->join('documents','documents.id','students.typedocument_id')
	            ->join('facturations','facturations.facId','voucherentrys.venFacturation_id')
	            ->join('legalizations','legalizations.legId','facturations.facLegalization_id')
	            ->join('attendants','attendants.id','legalizations.legAttendantfather_id')
	            ->whereBetween('venDate',[$this->dateInitial,$this->dateFinal])
	            ->orderBy('students.firstname','asc')
	            ->get()
        ]);
    }
}
