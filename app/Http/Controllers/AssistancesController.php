<?php

namespace App\Http\Controllers;

use App\Mail\AbsenceMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Course;
use App\Models\Assistance;
use App\Models\Student;
use App\Models\Journey;
use App\Models\Concept;
use App\Models\Formadmission;
use App\Models\Garden;
use App\Models\Grade;
use App\Models\Legalization;
use App\Models\Presence;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Psy\Exception\Exception;

class AssistancesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  function assistancesTo()
  {
    $datenow = Date('Y-m-d');
    $courses = Course::all();
    return view('modules.assistances.index', compact('datenow', 'courses'));
  }

  function checkinAssistences()
  {
    $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
    $day = Carbon::today('America/Bogota')->locale('es')->dayName;
    $grades = Grade::all();
    return view('modules.assistances.indexCheckIn', compact('date', 'day', 'grades'));
  }

  function savecheckinAssistences(Request $request)
  {
    $student = Student::find($request->student);

    if ($request->hour != null && $request->min != null) {
      $TempArrival = ($request->temp != null) ? $request->temp : "37.1";
      $status = "presente";
    }
    else {
      $TempArrival = ($request->temp != null) ? $request->temp : "37.1";
      $status = "ausente";
    }

    Presence::create([
      'pre_date' => $request->date,
      'pre_student' => $request->student,
      'pre_course' => $request->course,
      'pre_harrival' => $request->hour . ":" . $request->min,
      'pre_tarrival' => $TempArrival,
      'pre_obsa' => $request->obs,
      'pre_status' => $status
    ]);
    $msg = ($status == "presente") ? "asistencia" : "ausencia";
    return back()->with('Success', ucfirst($msg) . " del alumno " . strtoupper($student->firstname . " " . $student->threename . " " . $student->fourname) . " registrada con exito");
  }

  function checkoutAssistences()
  {
    $registers = Presence::select('presences.*', 'students.*', 'courses.*')
      ->join('students', 'students.id', 'presences.pre_student')
      ->join('courses', 'courses.id', 'presences.pre_course')->get();
    // return $registers;
    return view('modules.assistances.indexCheckOut', compact('registers'));
  }

  function savecheckoutAssistences(Request $request)
  {
    $searchMessages = Presence::where("pre_id", $request->pre_id)
      ->join('students', 'students.id', 'presences.pre_student')
      ->join('courses', 'courses.id', 'presences.pre_course')->get();
    $search = Presence::find($request->pre_id);
    if (!$search) {
      return back()->with("Error", "Registro no Encontrado");
    }
    $search->pre_hexit = $request->hour . ":" . $request->min;
    $search->pre_texit = ($request->tExit != null) ? $request->tExit : "37.1";
    $search->pre_obse = $request->obse;
    $search->save();
    return back()->with("Success", "Se registro la salida del alumno " . strtoupper($searchMessages[0]['firstname'] . " " . $searchMessages[0]['threename'] . " " . $searchMessages[0]['fourname']));
  }

  function registerAssistences()
  {
    $grades = Grade::all();
    return view('modules.assistances.indexAttendanceRecord', compact('grades'));
  }

  public function registerAssistencesIndex(Request $request)
  {
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '-1');

    $dates = Carbon::now()->locale('es')->isoFormat('LL');
    $day = Carbon::now()->locale('es')->dayName;
    $dateSearch = ucfirst($day) . " " . $dates;

    /** COLUMNAS PARA DATATABLE **/
    $columns = array(
      0 => 'date',
      1 => 'student',
      2 => 'course',
      3 => 'harrival',
      4 => 'hexit'
    );

    $consulta = DB::table('presences')
      ->join('students', 'students.id', 'presences.pre_student')
      ->join('courses', 'courses.id', 'presences.pre_course')
      ->select('presences.pre_date AS date', 'students.firstname AS student', 'students.threename AS threename', 'students.fourname AS fourname', 'courses.name AS course', 'presences.pre_harrival AS harrival', 'presences.pre_hexit AS hexit');

    /** VALORES PARA DATATABLE **/
    $totalData = $consulta->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $clausulas = $consulta->where("presences.pre_date",$dateSearch);
      $totalFiltered = $clausulas->count();
      $posts = $clausulas->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }else {
      $search = $request->input('search.value');
      $clausulas = $consulta->where("presences.pre_date", "like", "%{$search}%");
      $clausulas = $consulta->orwhere("students.firstname", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("students.threename", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("students.fourname", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("courses.name", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("presences.pre_harrival", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("presences.pre_hexit", "like", "%{$search}%");

      $totalFiltered = $clausulas->count();
      $posts = $clausulas->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }

    $data = array();
    if ($posts) {
      foreach ($posts as $presence) {
        $nestedData['date'] = $presence->date;
        $nestedData['student'] = $presence->student." ".$presence->threename." ".$presence->fourname;
        $nestedData['course'] = $presence->course;
        $nestedData['harrival'] = $presence->harrival;
        $nestedData['hexit'] = $presence->hexit;
        $data[] = $nestedData;
      }
    }
    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );

    return json_encode($json_data);

  }

  function pdfAssistences(Request $request)
  {
    /*** SE VALIDA QUE EL CURSO Y EL GRADO VENGAN SELECCIONADOS ***/
    if (($request->Grades != null || $request->Grades = "") && ($request->course == null || $request->course == "")) {
      $grade = Grade::find($request->Grades);
      return back()->with('Error',"No se ha selecionado un curso del Grado: ".$grade->name);
    }

    $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
    $day = Carbon::today('America/Bogota')->locale('es')->dayName;
    $dateNow = $day . " " . $date;
    $registers = Presence::select('presences.*', 'students.*', 'courses.*')
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')
    ->where('pre_status', 'PRESENTE');
    
    /*** SE FILTRAN LOS REGISTROS ENCONTRADOS SI HAY UN A FECHA SELECCIONADA ***/
    if ($request->searchDate != null || $request->searchDate != '') {
      $infoDate = explode('-', $request->searchDate);
      $date = Carbon::createFromDate($infoDate[0], $infoDate[1], $infoDate[2], 'America/Bogota')->locale('es')->isoFormat('LL');
      $day = Carbon::createFromDate($infoDate[0], $infoDate[1], $infoDate[2], 'America/Bogota')->locale('es')->dayName;
      $dateNow = $day . " " . $date;
      $registers = $registers->where('pre_date', $dateNow);
    }

    /*** SE FILTRA LOS REGITROS ENCONTRADOS POR EL CURSO SELECCIONADO ***/
    if ($request->course != null || $request->course != "") {
      $registers = $registers->where('pre_course',$request->course);
    }

    /*** SE FILTRA LOS REGISTROS ENCONTRADOS POR EL ESTUDIANTE QUE FUE SELECIONADO ***/
    if ($request->student != null || $request->student != "") {
      $registers = $registers->where('pre_student',$request->student);
    }
    
    $registers = $registers->get();

    $pdf = App::make('dompdf.wrapper');
    $name = "Asistencia del " . $dateNow;
    $pdf = PDF::loadview('modules.assistances.PDFAssistances', compact('dateNow', 'registers'));
    return $pdf->download($name . ".pdf");
  }

  function absenceAssistences()
  {
    $grades = Grade::all();
    return view('modules.assistances.indexAbsenceRecord', compact("grades"));
  }

  function pdfAbsences()
  {
    $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
    $day = Carbon::today('America/Bogota')->locale('es')->dayName;
    $dateNow = $day . " " . $date;
    $registers = Presence::select('presences.*', 'students.*', 'courses.*')
      ->join('students', 'students.id', 'presences.pre_student')
      ->join('courses', 'courses.id', 'presences.pre_course')
      ->where('pre_status', 'AUSENTE')->get();
    $pdf = App::make('dompdf.wrapper');
    $name = "Asistencia del " . $dateNow;
    $pdf = PDF::loadview('modules.assistances.PDFAbsences', compact('dateNow', 'registers'));
    return $pdf->download($name . ".pdf");
  }

  function EmailAssitences(Request $request)
  {
    $search = Presence::where("pre_id", $request->data)
      ->join('students', 'students.id', 'presences.pre_student')
      ->join('courses', 'courses.id', 'presences.pre_course')->get();

    $mail = Formadmission::where("numerodocumento", $search[0]['numberdocument'])->get();

    $garden = Garden::all();

    $nameFather = ucwords($mail[0]['nombreacudiente1']);
    $nameMother = ucwords($mail[0]['nombreacudiente2']);
    $nameStudent = ucwords($mail[0]['nombres'] . " " . $mail[0]['apellidos']);
    $nameGarden = $garden[0]['garReasonsocial'];

    // $sendMail = [$mail[0]['correoacudiente1'], $mail[0]['correoacudiente2']];

    $sendMail = ["kigan38997@wii999.com"];

    Mail::to($sendMail)->send(new AbsenceMailer($nameFather, $nameMother, $nameStudent, $nameGarden));

    $updated = Presence::find($request->data);
    $updated->pre_status_mail = "ENVIADO";
    $updated->save();

    return $sendMail;
  }

  function graphicsAssistences()
  {
    $grades = Grade::all();
    return view('modules.assistances.indexGraphics', compact('grades'));
  }


  // rutina anterior
  function getAssistances(Request $request)
  {
    try {
      $assistances = Assistance::where('assDate', $request->dateSelected)->distinct('assCourse_id')->get();
      $assistancesResult = array();
      foreach ($assistances as $assistance) {
        $course = Course::find($assistance->assCourse_id);
        if ($course != null) {
          if ($assistance->assAbsents == 'N/A') {
            $countAbsent = 0;
          }
          else {
            $countAbsent = count(explode('-', $assistance->assAbsents));
          }
          $countPresent = explode('%', $assistance->assPresents);
          array_push($assistancesResult, [
            $assistance->assId,
            $course->name,
            $countAbsent,
            count($countPresent),
            $assistance->assDate,
            $assistance->assAbsents,
            $assistance->assPresents,
            $assistance->assStatus
          ]);
        }
      }

      return response()->json($assistancesResult);
    }
    catch (Exception $ex) {
    // Code exception ...
    }
  }

  function newAssistances(Request $request)
  {
    // dd($request->all());
    try {
      $assistanceValidate = Assistance::where('assCourse_id', trim($request->course))->where('assDate', trim($request->date))->first();
      if ($assistanceValidate == null) {
        $presentStudent = ''; //CAPTURAR INFO DE ESTUDIANTES PRESENTES SEPARADO POR COMA (,) EN UNA CADENA DE TEXTO
        for ($i = 0; $i < count($request->present); $i++) {
          // $request->present[$i][0] = ID DE ESTUDIANTE
          // $request->present[$i][8] = TEMPERATURA DE LLEGADA
          if ($i == (count($request->present) - 1)) {
            $presentStudent .= $request->present[$i][0] . '/' . $request->present[$i][1] . '/=°=/' . $request->present[$i][2] . '/=°=/' . $request->present[$i][8] . '/=°=';
          }
          else {
            $presentStudent .= $request->present[$i][0] . '/' . $request->present[$i][1] . '/=°=/' . $request->present[$i][2] . '/=°=/' . $request->present[$i][8] . '/=°=%';
          }
          $legalization = Legalization::select('legId')->where('legStudent_id', $request->present[$i][0])->first();
          if ($request->present[$i][4] != 'SKIP') {
            Concept::create([
              'conDate' => date('Y-m-d', strtotime($request->date . '+ 1 month')),
              'conConcept' => 'DIA ADICIONAL',
              'conValue' => $request->present[$i][5],
              'conLegalization_id' => $legalization->legId
            ]);
          }
        // $findOut = strpos($request->present[$i][6], 'TARDE');
        // if($findOut){
        // $separatedMinutes = explode('..', $request->present[$i][6]);

        // SEGMENTO COMENTADO PARA NO GENERAR COBROS DE LOS MINUTOS ADICIONALES EN LAS SALIDA TARDE DE LOS ALUMNOS
        // $totalValue = $request->present[$i][7] * $separatedMinutes[1];
        // Concept::create([
        //     'conDate' => date('Y-m-d', strtotime($request->date . '+ 1 month')),
        //     'conConcept' => $separatedMinutes[1] . ' MINUTO/S ADICIONAL/ES',
        //     'conValue' => $totalValue,
        //     'conLegalization_id' => $legalization->legId
        // ]);
        // }
        }
        $absentStudent = ''; //CAPTURAR IDs DE ESTUDIANTES AUSENTES
        if ($request->absent != null && count($request->absent) > 0) {
          for ($i = 0; $i < count($request->absent); $i++) {
            $journey = Legalization::select('jouDays')
              ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
              ->where('legStudent_id', $request->absent[$i])->first();
            $dayAssistance = $this->getDayWeek(trim($request->date));
            $findDay = strpos($journey->jouDays, $dayAssistance);
            if (strlen($findDay) > 0) {
              if ($i == (count($request->absent) - 1)) {
                $absentStudent .= $request->absent[$i];
              }
              else {
                $absentStudent .= $request->absent[$i] . '-';
              }
            }
            else {
              if ($i == (count($request->absent) - 1)) {
                $absentStudent .= $request->absent[$i] . 'A';
              }
              else {
                $absentStudent .= $request->absent[$i] . 'A-';
              }
            }
          }
        }
        if ($absentStudent != '') {
          Assistance::create([
            'assCourse_id' => $request->course,
            'assDate' => $request->date,
            'assPresents' => $presentStudent,
            'assAbsents' => $absentStudent
          ]);
        }
        else {
          Assistance::create([
            'assCourse_id' => $request->course,
            'assDate' => $request->date,
            'assPresents' => $presentStudent,
            'assAbsents' => 'N/A'
          ]);
        }
        return response()->json('LISTADO DE presente PROCESADO CORRECTAMENTE');
      }
      else {
        return response()->json('YA EXISTE UN LISTADO DE presente PARA EL CURSO CON LA FECHA INDICADA, VALIDE EN REPORTE DIARIO');
      }
    //return redirect()->route('assistances')->with('SuccessSaveAssitances', 'presente procesada correctamente');
    }
    catch (Exception $ex) {
    //return redirect()->route('assistances')->with('SecondarySaveAssitances', 'No es posible procesar la presente ahora, Comuniquese con el administrador');
    }
  }

  function saveFinalAssistance(Request $request)
  {
    try {
      /*
       $request->presentStudents,
       $request->absentStudent
       $request->dayAdditionalStudent
       $request->assId
       $request->date
       $request->valuedayAdditional
       $request->valueMinutes
       $request->countMinutes
       */
      // 1. BUSCAR LA presente A MODIFICAR

      // dd($request->all());

      $assistance = Assistance::find(trim($request->assId));
      if ($assistance != '') {
        $assistance->assPresents = trim($request->presentStudents);
        if (trim($request->absentStudent) != '') {
          $assistance->assAbsents = trim($request->absentStudent);
        }
        else {
          $assistance->assAbsents = 'N/A';
        }
        // VALIDAR Y GUARDAR LOS ESTUDIANTES QUE TENGAN DIA ADICIONAL
        if (trim($request->dayAdditionalStudent) != null && trim($request->dayAdditionalStudent) != '') {
          $separatedStudentAdditional = explode('-', trim($request->dayAdditionalStudent));
          for ($i = 0; $i < count($separatedStudentAdditional); $i++) {
            $separatedStudent = explode('=>', $separatedStudentAdditional[$i]);
            $legalization = Legalization::select('legId')->where('legStudent_id', $separatedStudent[0])->first();
            if ($legalization != null) {
              Concept::create([
                'conDate' => date('Y-m-d', strtotime(trim($request->date) . '+ 1 month')),
                'conConcept' => 'DIA ADICIONAL',
                'conValue' => trim($request->valuedayAdditional),
                'conLegalization_id' => $legalization->legId
              ]);
            }
          }
        }
        // VALIDAR Y GUARDAR LOS ESTUDIANTES QUE TENGAN MINUTOS ADICIONALES
        // if(trim($request->countMinutes) != null && trim($request->countMinutes) != ''){
        // $separatedStudentMinutes = explode('-', trim($request->countMinutes));
        // for ($i=0; $i < count($separatedStudentMinutes); $i++) { 
        // $separatedStudent = explode('=>', $separatedStudentMinutes[$i]);
        // SEGMENTO COMENTADO PARA NO GENERAR COBROS DE LOS MINUTOS ADICIONALES EN LAS SALIDA TARDE DE LOS ALUMNOS
        // $legalization = Legalization::where('legStudent_id',$separatedStudent[0])->first();
        // if($legalization != null){
        // $valueTotal =  $separatedStudent[1] * trim($request->valueMinutes); // Cantidad minutos * Valor minutos
        // Concept::create([
        //     'conDate' => date('Y-m-d', strtotime(trim($request->date) . '+ 1 month')),
        //     'conConcept' => $separatedStudent[1] . ' MINUTO/S ADICIONAL/ES',
        //     'conValue' => $valueTotal,
        //     'conLegalization_id' => $legalization->legId
        // ]);
        // }
        // }
        // }
        $dateAssistance = $assistance->assDate;
        $assistance->assStatus = 1;
        $assistance->save();
        return response()->json("presente CON FECHA " . $dateAssistance . ", ACTUALIZADA CORRECTAMENTE");
      }
      else {
        return response()->json('presente NO ENCONTRADA');
      }
    }
    catch (Exception $ex) {
    // Code exception ...
    }
  }

  function pdfAssistances(Request $request)
  {
    try {
      if ($request->optionFilterPdf == 'group') {
        $assistance = Assistance::select(
          'assistances.*',
          'courses.name AS nameCourse'
        )
          ->join('courses', 'courses.id', 'assistances.assCourse_id')
          ->where('assCourse_id', $request->pdfCourseGroup)->where('assDate', $request->pdfDateGroup)->first();
        if ($assistance != null) {
          $date = $this->getDateFormat($assistance->assDate);
          $course = $assistance->nameCourse;
          $namefile = 'presente_' . $date . '_' . $course . '.pdf';

          $separatedStudentPresent = explode('%', $assistance->assPresents);


          //$separatedDatesEachStudentPresent = explode('/',$separatedStudentPresent);

          $datesStudentPresent = array();
          for ($i = 0; $i < count($separatedStudentPresent); $i++) {
            $separatedDatesEachStudentPresent = explode('/', $separatedStudentPresent[$i]);
            $id = $separatedDatesEachStudentPresent[0];
            $separatedRangeHour = explode(' - ', $separatedDatesEachStudentPresent[1]);
            $hourInitial = $separatedRangeHour[0];
            $hourFinal = $separatedRangeHour[1];
            $observationArrive = $separatedDatesEachStudentPresent[2];
            $observationExit = $separatedDatesEachStudentPresent[3];
            $journey = Journey::find($separatedDatesEachStudentPresent[4]);
            $student = Student::find($id);
            array_push($datesStudentPresent, [
              $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
              $student->numberdocument,
              $student->yearsold,
              $student->birthdate,
              $hourInitial,
              $hourFinal,
              $observationArrive,
              $observationExit,
              $journey->jouJourney
            ]);
          }

          if ($assistance->assAbsents != 'N/A') {
            $separatedStudentAbsent = explode('%', $assistance->assAbsents);
            $datesStudentAbsent = array();
            for ($i = 0; $i < count($separatedStudentAbsent); $i++) {
              $student = Student::find($separatedStudentAbsent[$i]);
              $legalization = Legalization::select('journeys.jouJourney')
                ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
                ->where('legStudent_id', $student->id)->first();
              array_push($datesStudentAbsent, [
                $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
                $student->numberdocument,
                $student->yearsold,
                $student->birthdate,
                $legalization->jouJourney,
              ]);
            }
          }
          else {
            $datesStudentAbsent = array();
          }
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadView('modules.assistances.assistancesPdf', compact('date', 'course', 'datesStudentPresent', 'datesStudentAbsent'));
          //$pdf->setPaper("A6", "landscape");
          return $pdf->download($namefile);
        }
        else {
          $course = Course::find($request->pdfCourseGroup);
          return redirect()->route('assistances')->with('SecondarySaveAssitances', 'No existen listados para la busqueda de curso ' . $course->name . ' en la fecha ' . $request->pdfDateGroup);
        }
      }
      else if ($request->optionFilterPdf == 'unique') {
        /*
         $request->pdfCourseUnique;
         $request->pdfStudentUnique;
         */
        $idStudent = 0;
        $findStudent = array();
        $assistances = Assistance::where('assCourse_id', $request->pdfCourseUnique)->get();
        //dd($assistances);
        $idStudent = 0;
        foreach ($assistances as $assistance) {
          $separatedStudentPresent = explode('%', $assistance->assPresents);
          for ($i = 0; $i < count($separatedStudentPresent); $i++) {
            $separatedDatesEachStudentPresent = explode('/', $separatedStudentPresent[$i]);
            if ($request->pdfStudentUnique == $separatedDatesEachStudentPresent[0]) {
              $idStudent = $separatedDatesEachStudentPresent[0];
              array_push($findStudent, [
                'PRESENTE',
                $assistance->assDate, //Fecha
                $separatedDatesEachStudentPresent[1], //Rango de horas
                $separatedDatesEachStudentPresent[2], //Observacion de llegada
                $separatedDatesEachStudentPresent[3], //Observacion de salida
                $separatedDatesEachStudentPresent[4] //Jornada
              ]);
            }
          }
          //SI SIGUE SIENDO FALSO ES PORQUE NO SE HA ENCONTRADO ESTUDIANTE PRESENTE EN LA FECHA EVALUADA Y SE PROCEDE A EVALUAR SI EL ESTUDIANTE ES AUSENTE EN ESE FECHA
          if ($assistance->assAbsents != 'N/A') {
            $separatedStudentAbsent = explode('%', $assistance->assAbsents);
            for ($i = 0; $i < count($separatedStudentAbsent); $i++) {
              if ($request->pdfStudentUnique == $separatedStudentAbsent[$i]) {
                $student = $separatedStudentAbsent[$i];
                array_push($findStudent, [
                  'AUSENTE',
                  $assistance->assDate,
                  'N/A',
                  'N/A',
                  'N/A'
                ]);
              }
            }
          }
        }
        if ($idStudent > 0) {
          $student = Student::find($idStudent);
          $course = Course::find($request->pdfCourseUnique);
          //dd($course);
          $dateInitial = $request->pdfDateInitialUnique;
          $dateFinal = $request->pdfDateFinalUnique;
          $namefile = 'INFORME_INDIVIDUAL_' . $student->firstname . ' ' . $student->secondname . ' ' . $student->threename . ' ' . $student->fourname . '_' . $course->name . '.pdf';
          $pdf = \App::make('dompdf.wrapper');
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadView('modules.assistances.assistancesUniquePdf', compact('student', 'course', 'findStudent', 'dateInitial', 'dateFinal'));
          //$pdf->setPaper("A6", "landscape");
          return $pdf->download($namefile);
        }
        else {
          return redirect()->route('assistances')->with('SecondarySaveAssitances', 'No existen registros en el rango seleccionado');
        }
      }
    }
    catch (Exception $ex) {
    //Code...
    }
  }

  function getDateFormat($date)
  {
    $separated = explode('-', $date);
    switch ($separated[1]) {
      case '01':
        return $separated[2] . ' DE ENERO DEL ' . $separated[0];
      case '02':
        return $separated[2] . ' DE FEBRERO DEL ' . $separated[0];
      case '03':
        return $separated[2] . ' DE MARZO DEL ' . $separated[0];
      case '04':
        return $separated[2] . ' DE ABRIL DEL ' . $separated[0];
      case '05':
        return $separated[2] . ' DE MAYO DEL ' . $separated[0];
      case '06':
        return $separated[2] . ' DE JUNIO DEL ' . $separated[0];
      case '07':
        return $separated[2] . ' DE JULIO DEL ' . $separated[0];
      case '08':
        return $separated[2] . ' DE AGOSTO DEL ' . $separated[0];
      case '09':
        return $separated[2] . ' DE SEPTIEMBRE DEL ' . $separated[0];
      case '10':
        return $separated[2] . ' DE OCTUBRE DEL ' . $separated[0];
      case '11':
        return $separated[2] . ' DE NOVIEMBRE DEL ' . $separated[0];
      case '12':
        return $separated[2] . ' DE DICIEMBRE DEL ' . $separated[0];
    }
  //Filtrar por alumno en un rango de fechas
  }

  function getDayWeek($date)
  {
    $days = array('DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO');
    $result = $days[date('N', strtotime($date))];
    return $result;
  }

  function getAssistancesDinamics($date)
  {
    $assistances = Assistance::where('assDate', $date)->distinct('assCourse_id')->get();
    foreach ($assistances as $assistance) {
      $present = $assistance->assPresents;
    }
  }
}
