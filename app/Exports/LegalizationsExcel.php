<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Legalization;
use App\Models\Attendant;

class LegalizationsExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$legalizations = Legalization::select(
	            'legalizations.*',
	            DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
	            'documents.type as typeDocument',
	            'students.numberdocument as numberdocumentStudent',
	            'students.birthdate',
	            'students.yearsold',
	            'students.address',
	            'citys.name as nameCity',
	            'locations.name as nameLocation',
	            'districts.name as nameDistrict',
	            DB::raw("CONCAT(bloodtypes.group,' ',bloodtypes.type) AS nameBloodtype"),
	            'students.gender AS genderStudent',
	            DB::raw("CONCAT(healths.entity,' ',healths.type) AS nameHealth"),
	            'students.additionalHealt',
	            'students.additionalHealtDescription',
	            'grades.name AS nameGrade'
	        )
	        ->join('students','students.id','legalizations.legStudent_id')
	        // ->join('attendants','attendants.id','legalizations.legAttendantfather_id')
	        ->join('grades','grades.id','legalizations.legGrade_id')
	        ->join('documents','documents.id','students.typedocument_id')
	        ->join('citys','citys.id','students.cityhome_id')
	        ->join('locations','locations.id','students.locationhome_id')
	        ->join('districts','districts.id','students.dictricthome_id')
	        ->join('bloodtypes','bloodtypes.id','students.bloodtype_id')
	        ->join('healths','healths.id','students.health_id')
					->where('legStatus',"ACTIVO")
	        ->get();

	    $contract = array();
	    foreach ($legalizations as $legalization) {
	    	$father = 'SIN REGISTRO';
	    	$mother = 'SIN REGISTRO';
	     	if($legalization->legAttendantmother_id != null){
	     		$mother = Attendant::find($legalization->legAttendantmother_id);
	     	}
	     	if($legalization->legAttendantfather_id != null){
     			$father = Attendant::find($legalization->legAttendantfather_id);
     		}
     		if($mother != 'SIN REGISTRO' && $father != 'SIN REGISTRO'){
     			array_push($contract,[
     				$legalization->nameStudent,
     				$legalization->yearsold,
     				$legalization->birthdate,
     				$legalization->typeDocument,
     				$legalization->numberdocumentStudent,
     				$legalization->genderStudent,
     				$legalization->nameBloodtype,
     				$legalization->nameHealth,
     				$legalization->additionalHealt,
     				$legalization->additionalHealtDescription,
     				$legalization->nameCity,
     				$legalization->nameLocation,
     				$legalization->nameDistrict,
     				$legalization->address,
     				$legalization->nameGrade,
     				$father->firstname . ' ' . $father->threename,
     				$father->numberdocument,
                         $father->emailone,
     				$father->phoneone,
     				$mother->firstname . ' ' . $mother->threename,
     				$mother->numberdocument,
                         $mother->emailone,
     				$mother->phoneone,
     				$legalization->legDateInitial,
     				$legalization->legDateFinal
     			]);
     		}else if($mother != 'SIN REGISTRO' && $father == 'SIN REGISTRO'){
     			array_push($contract,[
     				$legalization->nameStudent,
     				$legalization->yearsold,
     				$legalization->birthdate,
     				$legalization->typeDocument,
     				$legalization->numberdocumentStudent,
     				$legalization->genderStudent,
     				$legalization->nameBloodtype,
     				$legalization->nameHealth,
     				$legalization->additionalHealt,
     				$legalization->additionalHealtDescription,
     				$legalization->nameCity,
     				$legalization->nameLocation,
     				$legalization->nameDistrict,
     				$legalization->address,
     				$legalization->nameGrade,
     				'N/A',
     				'N/A',
     				'N/A',
                         'N/A',
     				$mother->firstname . ' ' . $mother->threename,
     				$mother->numberdocument,
                         $mother->emailone,
     				$mother->phoneone,
     				$legalization->legDateInitial,
     				$legalization->legDateFinal
     			]);
     		}else if($mother == 'SIN REGISTRO' && $father != 'SIN REGISTRO'){
     			array_push($contract,[
     				$legalization->nameStudent,
     				$legalization->yearsold,
     				$legalization->birthdate,
     				$legalization->typeDocument,
     				$legalization->numberdocumentStudent,
     				$legalization->genderStudent,
     				$legalization->nameBloodtype,
     				$legalization->nameHealth,
     				$legalization->additionalHealt,
     				$legalization->additionalHealtDescription,
     				$legalization->nameCity,
     				$legalization->nameLocation,
     				$legalization->nameDistrict,
     				$legalization->address,
     				$legalization->nameGrade,
     				$father->firstname . ' ' . $father->threename,
     				$father->numberdocument,
                         $father->emailone,
     				$father->phoneone,
     				'N/A',
     				'N/A',
     				'N/A',
                         'N/A',
     				$legalization->legDateInitial,
     				$legalization->legDateFinal
     			]);
     		}else if($mother == 'SIN REGISTRO' && $father == 'SIN REGISTRO'){
     			array_push($contract,[
     				$legalization->nameStudent,
     				$legalization->yearsold,
     				$legalization->birthdate,
     				$legalization->typeDocument,
     				$legalization->numberdocumentStudent,
     				$legalization->genderStudent,
     				$legalization->nameBloodtype,
     				$legalization->nameHealth,
     				$legalization->additionalHealt,
     				$legalization->additionalHealtDescription,
     				$legalization->nameCity,
     				$legalization->nameLocation,
     				$legalization->nameDistrict,
     				$legalization->address,
     				$legalization->nameGrade,
     				'N/A',
     				'N/A',
     				'N/A',
     				'N/A',
                         'N/A',
                         'N/A',
     				'N/A',
     				'N/A',
     				$legalization->legDateInitial,
     				$legalization->legDateFinal
     			]);
     		}
	    }
        return view('modules.reports.settingReportExcel', [
            'contract' => $contract
        ]);
    }
}
