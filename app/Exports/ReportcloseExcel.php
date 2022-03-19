<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Legalization;
use App\Models\Coststructure;
use App\Models\Costdescription;
use App\Models\Egress;
use App\Models\Annual;
use App\Models\Garden;

class ReportcloseExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $year; 

    function __construct($year){
    	$this->year = $year;
    }

    public function view(): View
    {
    	$report = array();
    	$coststructures = Coststructure::all();
		foreach ($coststructures as $structure) {
    		$costdescriptions = Costdescription::where('cdCoststructure_id',$structure->csId)->distinct('cdDescription')->get();
    		$dates = array(); // ARREGLO PARA CADA DESCRIPCION DE COSTO
    		foreach ($costdescriptions as $description) {
    			// VARIABLES DONDE GUARDAR LA INFORMACION EN CADA RECORRIDO
    			$valueTotalBudget = 0;
    			$valueTotalExecuted = 0;
    			$valueMountBudget = [0,0,0,0,0,0,0,0,0,0,0,0];
    			$valueMountExecuted = [0,0,0,0,0,0,0,0,0,0,0,0];
    			// CONSULTA DE PRESUPUESTO
    			$budget = Annual::where('aYear',$this->year)->where('aCostDescription_id',$description->cdId)->first();
    			// SI EXISTE UN PRESUPUESTO DEL AÑO
    			if($budget != null){
    				// ASIGNAR VARIABLE
    				$valueTotalBudget = $budget->aValue;
    				$separatedDetails = explode('-', $budget->aDetailsMount);
    				for ($i=0; $i < count($separatedDetails); $i++) { 
						$separated = explode(':', $separatedDetails[$i]);
    					$valueMountBudget[$i] = $separated[1];
						// COMPROBANTES DEL MES DEL PRESUPUESTO
    					$voucheregress = Egress::whereBetween('vegDate', [$this->year . '-' . $this->getMountNumber($separated[0]) . '-01' , $this->year . '-' . $this->getMountNumber($separated[0]) . '-' . $this->numberDaysOfmount($this->getMountNumber($separated[0]),$this->year)])->get();
    					$totalMountExecuted = 0;
    					foreach ($voucheregress as $voucher) {
    						$totalMountExecuted += $voucher->vegPay;
    					}
    					$valueMountExecuted[$i] = $totalMountExecuted;
    					// COMPROBANTES DE TODO EL AÑO
    					$voucheregress = Egress::whereBetween('vegDate', [$this->year . '-01-01' , $this->year . '-12-' . $this->numberDaysOfmount('12',$this->year)])->get();
    					foreach ($voucheregress as $voucher) {
    						$valueTotalExecuted +=  $voucher->vegPay;
    					}
					}
    			}
    			// LLENAR ARRAY DE RESULTADOS
    			array_push($dates,
    				[
    					$description->cdDescription,
    					$valueMountBudget, // PRESUPUESTO POR CADA MES DEL AÑO (Array)
    					$valueMountExecuted, // PRESUPUESTO EJECUTADO POR MES DEL AÑO (Array)
    					$valueTotalBudget, // PRESUPUESTO TOTAL DEL AÑO (Integer)
    					$valueTotalExecuted // PRESUPUESTO EJECUTADO TOTAL DEL AÑO (Integer)
					]
				);
    		}
    		// LLENAR ARREGLO DE REPORTE
    		array_push($report,[$structure->csDescription,$dates]);
    	}
    	// dd($report);
    	$yearReport = $this->year;
    	$garden = Garden::select('garden.*','citys.name as nameCity','locations.name as nameLocation')
                        ->join('citys','citys.id','garden.garCity_id')
                        ->join('locations','locations.id','garden.garLocation_id')
                        ->first();
    	return view('modules.analysis.reportExcel', compact('report','garden','yearReport'));


        // return view('modules.analysis.reportExcel', [
        //     'report' => Legalization::select(
        // 		'students.id',
        //         DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        // 		'students.numberdocument',
        // 		'students.birthdate',
        // 		'students.yearsold',
        //         'grades.name as nameGrade'
        //     )
        //     ->join('students','students.id','legalizations.legStudent_id')
        //     ->join('grades','grades.id','legalizations.legGrade_id')
        //     ->where('legStudent_id',$this->year)
        //     ->orderBy('students.firstname','asc')
        //     ->get()
        // ]);
    }

    function getMountNumber($mount){
    	switch ($mount) {
    		case 'ENERO': return '01'; 
    		case 'FEBRERO': return '02'; 
    		case 'MARZO': return '03'; 
    		case 'ABRIL': return '04'; 
    		case 'MAYO': return '05'; 
    		case 'JUNIO': return '06'; 
    		case 'JULIO': return '07'; 
    		case 'AGOSTO': return '08'; 
    		case 'SEPTIEMBRE': return '09'; 
    		case 'OCTUBRE': return '10'; 
    		case 'NOVIEMBRE': return '11'; 
    		case 'DICIEMBRE': return '12'; 
    	}
    }

    function numberDaysOfmount($mount,$year){
		$days = date("t", strtotime($year . '-' . $mount . '-15'));
		return $days;
		//dd(cal_days_in_month(CAL_GREGORIAN,$mount,$year));
		//return cal_days_in_month(CAL_GREGORIAN,$mount,$year);
	}
}
