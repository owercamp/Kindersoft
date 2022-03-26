<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\Exportable;

use App\Models\Legalization;
use App\Models\Attendant;

class StudentsExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // use Exportable;
    protected $ids; 

    function __construct($ids){
    	$this->ids = $ids;
    }

    public function view(): View
    {
        $legalizations = Legalization::select(
                'legalizations.legAttendantmother_id',
                'legalizations.legAttendantfather_id',
                'students.id',
                DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
                'students.numberdocument',
                'students.birthdate',
                'students.yearsold',
                'grades.name as nameGrade'
            )
            ->join('students','students.id','legalizations.legStudent_id')
            ->join('grades','grades.id','legalizations.legGrade_id')
            ->whereIn('legStudent_id',$this->ids)
            ->orderBy('students.firstname','asc')
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
                    $legalization->numberdocument,
                    $legalization->birthdate,
                    $legalization->nameGrade,
                    $father->emailone,
                    $mother->emailone
                ]);
            }else if($mother != 'SIN REGISTRO' && $father == 'SIN REGISTRO'){
                array_push($contract,[
                    $legalization->nameStudent,
                    $legalization->numberdocument,
                    $legalization->birthdate,
                    $legalization->nameGrade,
                    'N/A',
                    $mother->emailone
                ]);
            }else if($mother == 'SIN REGISTRO' && $father != 'SIN REGISTRO'){
                array_push($contract,[
                    $legalization->nameStudent,
                    $legalization->numberdocument,
                    $legalization->birthdate,
                    $legalization->nameGrade,
                    $father->emailone,
                    'N/A'
                ]);
            }else if($mother == 'SIN REGISTRO' && $father == 'SIN REGISTRO'){
                array_push($contract,[
                    $legalization->nameStudent,
                    $legalization->numberdocument,
                    $legalization->birthdate,
                    $legalization->nameGrade,
                    'N/A',
                    'N/A'
                ]);
            }
        }
        return view('modules.reports.listStudentExcel', [
            'students' => $contract
        ]);

        // ALternativo sin correos de acudientes, solo información de alumnos
        // return view('modules.reports.listStudentExcel', [
        //     'students' => Legalization::select(
        // 		'students.id',
        //         DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        // 		'students.numberdocument',
        // 		'students.birthdate',
        // 		'students.yearsold',
        //         'grades.name as nameGrade'
        //     )
        //     ->join('students','students.id','legalizations.legStudent_id')
        //     ->join('grades','grades.id','legalizations.legGrade_id')
        //     ->whereIn('legStudent_id',$this->ids)
        //     ->orderBy('students.firstname','asc')
        //     ->get()
        // ]);
    }

    // public function collection()
    // {
    //     return Legalization::select(
    //     		'students.id',
    //             DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    //     		'students.numberdocument',
    //     		'students.birthdate',
    //     		'students.yearsold',
    //             'grades.name as nameGrade'
    //         )
    //         ->join('students','students.id','legalizations.legStudent_id')
    //         ->join('grades','grades.id','legalizations.legGrade_id')
    //         ->whereIn('legStudent_id',$this->ids)
    //         ->orderBy('students.firstname','asc')
    //         ->get();
    //         // ->toArray();
    //     // array_unshift($legalizations,array(
    //     // 	['NOMBRE', 'DOCUMENTO', 'FECHA DE NACIMIENTO','EDAD', 'GRADO']
    //     // ));
    //     // return $legalizations;
    // }
}
