<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExcel;
use App\Exports\LegalizationsExcel;

use App\Models\Course;
use App\Models\Assistance;
use App\Models\Legalization;
use App\Models\Attendant;
use App\Models\Student;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listEnrollmentTo(){
        $courses = Course::all();
        return view('modules.reports.listEnrollments',compact('courses'));
    }

    public function listExcel(Request $request){
            $idStudent = substr(trim($request->idsExcel),0,-1); // QUITAR EL ULTIMO CARACTER QUE SOBRA
            $separatedIds = explode(':', $idStudent);
            $datenow = Date('Y-m-d h:m:s');
            return Excel::download(new StudentsExcel($separatedIds), 'Listado_' . $datenow . '.xlsx');
            // return (new StudentsExcel($separatedIds))->download('invoices.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function settingReportTo(){
        $courses = Course::all();
        $tables = DB::select('SHOW TABLES');
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
            'grades.name AS nameGrade',
            DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendantone")
        )
        ->join('students','students.id','legalizations.legStudent_id')
        ->join('attendants','attendants.id','legalizations.legAttendantfather_id')
        ->join('grades','grades.id','legalizations.legGrade_id')
        ->join('documents','documents.id','students.typedocument_id')
        ->join('citys','citys.id','students.cityhome_id')
        ->join('locations','locations.id','students.locationhome_id')
        ->join('districts','districts.id','students.dictricthome_id')
        ->join('bloodtypes','bloodtypes.id','students.bloodtype_id')
        ->join('healths','healths.id','students.health_id')
        ->where('legStatus',"ACTIVO")
        ->get();
        return view('modules.reports.settingReport',compact('tables','legalizations'));
    }

    public function reportAttendantTo(){
        $legalizations = Legalization::select(
            'legalizations.legId',
            'legalizations.legAttendantfather_id',
            'legalizations.legAttendantmother_id',
            DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
        )
        ->join('students','students.id','legalizations.legStudent_id')
        ->where('legStatus','ACTIVO')
        ->orderBy('nameStudent','asc')
        ->get();
        $dates = array();
        foreach ($legalizations as $legalization) {
            if($legalization->legAttendantfather_id != null && $legalization->legAttendantmother_id != null){
                $father = Attendant::find($legalization->legAttendantfather_id);
                $mother = Attendant::find($legalization->legAttendantmother_id);
                if($father != null && $mother != null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        $father->firstname . ' ' . $father->threename,
                        $father->phoneone,
                        $father->phonetwo,
                        $father->whatsapp,
                        $father->emailone,
                        $father->emailtwo,
                        $mother->firstname . ' ' . $mother->threename,
                        $mother->phoneone,
                        $mother->phonetwo,
                        $mother->whatsapp,
                        $mother->emailone,
                        $mother->emailtwo
                    ]);
                }else if($father != null && $mother == null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        $father->firstname . ' ' . $father->threename,
                        $father->phoneone,
                        $father->phonetwo,
                        $father->whatsapp,
                        $father->emailone,
                        $father->emailtwo,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR'
                    ]);
                }else if($father == null && $mother != null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        $mother->firstname . ' ' . $mother->threename,
                        $mother->phoneone,
                        $mother->phonetwo,
                        $mother->whatsapp,
                        $mother->emailone,
                        $mother->emailtwo
                    ]);
                }else if($father == null && $mother == null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR'
                    ]);
                }                
            }else if($legalization->legAttendantfather_id == null && $legalization->legAttendantmother_id != null){
                $mother = Attendant::find($legalization->legAttendantmother_id);
                if($mother != null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        $mother->firstname . ' ' . $mother->threename,
                        $mother->phoneone,
                        $mother->phonetwo,
                        $mother->whatsapp,
                        $mother->emailone,
                        $mother->emailtwo
                    ]);
                }else{
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR'
                    ]);
                }
            }else if($legalization->legAttendantfather_id != null && $legalization->legAttendantmother_id == null){
                $father = Attendant::find($legalization->legAttendantfather_id);
                if($father != null){
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        $father->firstname . ' ' . $father->threename,
                        $father->phoneone,
                        $father->phonetwo,
                        $father->whatsapp,
                        $father->emailone,
                        $father->emailtwo,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR'
                    ]);
                }else{
                    array_push($dates,[
                        $legalization->legId,
                        $legalization->nameStudent,
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR',
                        'SIN REGISTRAR'
                    ]);
                }
            }else{
                array_push($dates,[
                    $legalization->legId,
                    $legalization->nameStudent,
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR',
                    'SIN REGISTRAR'
                ]);
            }
        }
        return view('modules.reports.attendantsfilter',compact('dates'));
    }

    public function legalizationExcel(){
        return Excel::download(new LegalizationsExcel(), 'Contratos.xlsx');
    }

    public function statisticAssistancesTo(){
        $courses = Course::all();
        return view('modules.reports.statisticAssistances', compact('courses'));        
    }

    public function statisticIncreaseTo(){
        return view('modules.reports.statisticIncrease');
    }

    public function createLicenseCollaborator(){
        return view('modules.reports.collaboratorLicense');
    }

    public function createLicenseStudent(){
        return view('modules.reports.studentLicense');
    }

    public function createStatistic(Request $request){
        // dd($request->all());
        $separatedDates = explode(':',$request->period);
        $start = strtotime($separatedDates[0]);
        $end = strtotime($separatedDates[1]);
        $totalPresentfull = 0;
        $totalPresentfall = 0;
        $totalAbsentout = 0;
        $totalNotresult = 0;
        $countDay = 0;
        $businnesDay = 0;
        $additionalDay = 0;
        $next = 86400;
        $result = array();
        $days = Legalization::select('jouDays')->join('journeys','journeys.id','legalizations.legJourney_id')
                            // ->where('legCourse_id',$request->course)
                            ->where('legStudent_id',$request->student)->first();
        for ($i=$start; $i <= $end; $i+=$next) {
            $presentfull = 0;
            $presentfall = 0;
            $absentout = 0;
            $message = '';
            // $assistance = null;
            $day = date('Y-m-d',$i);
            $daynow = getStringDay(date('w',$i));

            if($daynow == 'LUNES' || $daynow == 'MARTES' || $daynow == 'MIERCOLES' || $daynow == 'JUEVES' || $daynow == 'VIERNES'){
                $businnesDay++;
            }
            $assistance = Assistance::where('assCourse_id',$request->course)->where('assDate',$day)->first();
            if($assistance != null){
                $findDay = strpos($days, $daynow);
                if(!$findDay){
                    $additionalDay++;
                }
                $studentAbsent = strpos($assistance->assAbsent, $request->student);
                if($studentAbsent){
                    $absentout++;
                    $totalAbsentout++;
                }else{
                    $allStudentPresent = explode('%',$assistance->assPresents);
                    $validate = false;
                    for ($s=0; $s < count($allStudentPresent); $s++) { 
                        $student = substr($allStudentPresent[$s],0,strlen($request->student));
                        if($student == $request->student){
                            // $absentout = 0;
                            $message = '';
                            $validate = true;
                            $separatedInfo = explode('/', $allStudentPresent[$s]);
                            $message = $separatedInfo[count($separatedInfo)-1]; // TOMA EL ULTIMO ELEMENTO DEL ARRAY
                            $time = strpos($message, 'LLEGADA A TIEMPO');
                            if($time >= 0){
                                // $presentfull++;
                                $totalPresentfull++;
                                // $presentfall = 0;
                            }else{
                                // $presentfall++;
                                $totalPresentfall++;
                                // $presentfull = 0;
                            }
                            // if($this->getStringDate($day) == '27 de febrero'){
                            //     dd('MENSAJE: ' . $message . ', COMPLETO: ' . $presentfull . ', INCOMPLETO: ' . $presentfall);
                            // }
                        }else{
                            if(!$validate){ // SI NO SE CUMPLE ES PORQUE YA SE ENCONTRO AL ALUMNO EN UNA ITERACION ANTERIOR
                                // $absentout++;
                                $totalAbsentout++;
                            }
                        }
                    }
                }
                // if($absentout == 1){
                //     array_push($result, [
                //         $this->getStringDate($day),
                //         100,
                //         $message,
                //         'AUSENTE'
                //     ]);   
                // }else if($presentfull == 1){
                //     array_push($result, [
                //         $this->getStringDate($day),
                //         100,
                //         $message,
                //         'LLEGADA A TIEMPO'
                //     ]); 
                // }else if($presentfall == 1){
                //     array_push($result, [
                //         $this->getStringDate($day),
                //         100,
                //         $message,
                //         'LLEGADA TARDE'
                //     ]); 
                // }
            }else{
                $totalNotresult++;
                // array_push($result, [
                //     $this->getStringDate($day),
                //     100,
                //     'NO HAY INFORMACION DE LA FECHA',
                //     'SIN REGISTRO',
                // ]);
            }
            $countDay++;
        }
        // dd($totalAbsentout);
        // $percentagePresentfull = ($totalPresentfull*100)/$countDay;
        // $percentagePresentfall = ($totalPresentfall*100)/$countDay;
        // $percentageAbsentout = ($totalAbsentout*100)/$countDay;
        // dd('ASISTENCIA A TIEMPO: ' . round($percentagePresentfull) . ', ASISTENCIA TARDE: ' . round($percentagePresentfall) . ', AUSENCIA: ' . round($percentageAbsentout) . ', SIN REGISTROS: ' . round($totalNotresult));
        // array_push($result, [
        //     round($percentagePresentfull),
        //     round($percentagePresentfall),
        //     round($percentageAbsentout),
        //     round($totalNotresult)
        // ]);

        $porcentageLate = round((($totalPresentfall + $totalAbsentout) *100)/$businnesDay,2);
        // dd('(' . $totalPresentfall . ' * 100)/' . $businnesDay);

        array_push($result,$separatedDates[0]);
        array_push($result,$separatedDates[1]);
        array_push($result,$businnesDay);
        array_push($result,$additionalDay);
        array_push($result,$totalPresentfull);
        array_push($result,$totalPresentfall);
        array_push($result,$totalAbsentout);
        array_push($result,$porcentageLate);
        
        // dd($result);
        return response()->json($result);
    }

    function getStringDate($d){
        $separated = explode('-', $d);
        switch ($separated[1]) {
            case '01': return $separated[2] . ' de enero'; 
            case '02': return $separated[2] . ' de febrero'; 
            case '03': return $separated[2] . ' de marzo'; 
            case '04': return $separated[2] . ' de abril'; 
            case '05': return $separated[2] . ' de mayo'; 
            case '06': return $separated[2] . ' de junio'; 
            case '07': return $separated[2] . ' de julio'; 
            case '08': return $separated[2] . ' de agosto'; 
            case '09': return $separated[2] . ' de septiembre'; 
            case '10': return $separated[2] . ' de octubre'; 
            case '11': return $separated[2] . ' de noviembre'; 
            case '12': return $separated[2] . ' de diciembre'; 
        }
    }

    function getStringDay($day){
        switch ($day) {
            case '0': return 'DOMINGO'; 
            case '1': return 'LUNES'; 
            case '2': return 'MARTES'; 
            case '3': return 'MIERCOLES'; 
            case '4': return 'JUEVES'; 
            case '5': return 'VIERNES'; 
            case '6': return 'SABADO'; 
        }
    }

    // FUNCIONES DE CONCILIACION DE SALDOS
    public function balancesTo(){
        return view('modules.balances.index');
    }
}
