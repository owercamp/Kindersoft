<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Pay;
use App\Models\Grade;
use App\Models\Course;
use App\Models\Garden;
use App\Models\Wallet;
use App\Models\Concept;
use App\Models\Journey;
use App\Models\Student;
use App\Models\Attendant;
use App\Models\Authorized;
use App\Models\Listcourse;
use App\Models\Legalization;
use Illuminate\Http\Request;
use App\Models\DocumentEnroll;
use App\Models\ConsolidatedEnroll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class EnrollmentsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /* -- DOCUMENTOS/REQUISITOS DE MATRICULA -- */
  public function documentsEnrollmentTo()
  {
    $documentsEnrollment = DocumentEnroll::orderBy('dePosition', 'asc')->get();
    $documentsCount = DocumentEnroll::all()->count();
    return view('modules.enrollments.requirements', compact('documentsEnrollment', 'documentsCount'));
  }

  public function newDocumentsEnrollment(Request $request)
  {
    // dd($request->all());
    try {
      $validateDE = DocumentEnroll::where('deConcept', trim(ucfirst(mb_strtolower($request->deConceptNew))))->first();
      if ($validateDE == null) {
        // CREAR EL REQUISITO DE MATRICULA CON LA ULTIMA POSICION
        if (trim($request->deStatusNew) == 'INACTIVO') {
          DocumentEnroll::create([
            'deConcept' => trim(ucfirst(mb_strtolower($request->deConceptNew))),
            'deRequired' => 'NO',
            'deStatus' => 'INACTIVO',
            'dePosition' => null,
          ]);
        } else if (trim($request->deStatusNew) == 'ACTIVO') {
          // VALIDAR POSICION
          $validatePosition = DocumentEnroll::where('dePosition', trim($request->dePositionNew))->first();
          if ($validatePosition != null) {
            // SI EXISTE YA LA POSICION INDICADA, SE CONSULTA LA POSITION Y LAS QUE LE SIGUEN
            $documentForChangePosition = DocumentEnroll::where('dePosition', '>=', $validatePosition->dePosition)->where('deStatus', 'ACTIVO')->get();
            // SE RECORRE CADA REQUISITO Y SE LE AUMENTA LA POSICION
            foreach ($documentForChangePosition as $document) {
              $document->dePosition += 1;
              $document->save();
            }
          }
          // AHORA QUE SE HAN AUMENTADO LAS POSICIONES SE PROCEDE A GUARDAR EL NUEVO REQUISITO CON LA POSICION SELECCIONADA
          DocumentEnroll::create([
            'deConcept' => trim(ucfirst(mb_strtolower($request->deConceptNew))),
            'deRequired' => 'SI',
            'deStatus' => 'ACTIVO',
            'dePosition' => trim($request->dePositionNew)
          ]);

          $requirementsCount = DocumentEnroll::where('deStatus', 'ACTIVO')->count();
          $requirementsStatusActiveAll = DocumentEnroll::where('deStatus', 'ACTIVO')->get();
          //VALIDAR TODOS LOS REQUISITOS
          $consolidatedenrollments = ConsolidatedEnroll::all();
          foreach ($consolidatedenrollments as $delivered) {
            $separatedDelivered = explode(',', $delivered->conenRequirements);
            if (count($separatedDelivered) < $requirementsCount) {
              $delivered->conenStatus = 'PENDIENTE';
              $delivered->save();
            }
          }
        }
        return redirect()->route('documentsEnrollment')->with('SuccessNewDocumentsEnrollment', 'Requisito: ' . trim(ucfirst(mb_strtolower($request->deConceptNew))) . ', creado correctamente');
      } else {
        return redirect()->route('documentsEnrollment')->with('SecondaryNewDocumentsEnrollment', 'Ya existe un requisito con el mismo nombre');
      }
    } catch (Exception $ex) {
      return redirect()->route('documentsEnrollment')->with('SecondaryNewDocumentsEnrollment', 'No es posible crear el requisito de matricula');
    }
  }

  public function updateDocumentsEnrollment(Request $request)
  {
    try {
      $validateDE = DocumentEnroll::where('deConcept', trim(ucfirst(mb_strtolower($request->deConceptEdit))))
        ->where('deId', '!=', trim($request->deIdEdit))
        ->first();
      if ($validateDE == null) {

        $documentEnrollmentEdit = DocumentEnroll::find(trim($request->deIdEdit));

        if (trim($request->deStatusEdit) == 'ACTIVO') {
          if ($documentEnrollmentEdit->dePosition != trim($request->dePositionEdit)) {
            // SI ES HACIA UNA POSICION MAYOR
            if (trim($request->dePositionEdit) > $documentEnrollmentEdit->dePosition) {
              $documentEnrollmentChange = DocumentEnroll::where('dePosition', '>', $documentEnrollmentEdit->dePosition)->where('deStatus', 'ACTIVO')->get();
              foreach ($documentEnrollmentChange as $change) {
                $posNew = ($change->dePosition - 1);
                if ($posNew == trim($request->dePositionEdit)) {
                  break;
                } else {
                  $change->dePosition -= 1;
                  $change->save();
                }
              }
              $documentEnrollmentEdit->dePosition = trim($request->dePositionEdit);
            } else {
              $documentEnrollmentChange = DocumentEnroll::where('dePosition', '>=', trim($request->dePositionEdit))
                ->where('dePosition', '<', $documentEnrollmentEdit->dePosition)
                ->where('deStatus', 'ACTIVO')->get();
              foreach ($documentEnrollmentChange as $change) {
                $change->dePosition += 1;
                $change->save();
              }
              $documentEnrollmentEdit->dePosition = trim($request->dePositionEdit);
            }
          }
        } else {
          $nextPosition = ($documentEnrollmentEdit->dePosition + 1);
          $documentEnrollmentChange = DocumentEnroll::where('dePosition', '>=', $nextPosition)
            ->where('deStatus', 'ACTIVO')->get();
          foreach ($documentEnrollmentChange as $change) {
            $change->dePosition -= 1;
            $change->save();
          }
          $documentEnrollmentEdit->dePosition = null;
        }

        $documentOld = $documentEnrollmentEdit->deConcept;
        $documentNew = trim(ucfirst(strtolower($request->deConceptEdit)));
        $documentEnrollmentEdit->deConcept = trim(ucfirst(strtolower($request->deConceptEdit)));
        $documentEnrollmentEdit->deRequired = trim($request->deRequiredEdit);
        $documentEnrollmentEdit->deStatus = trim($request->deStatusEdit);
        $documentEnrollmentEdit->save();

        if (trim($request->deStatusEdit) == 'ACTIVO') {
          //VALIDAR TODOS LOS REQUISITOS PARA CAMBIAR EL NOMBRE IGUAL A LA MODIFICACION
          $consolidatedenrollments = ConsolidatedEnroll::all();
          foreach ($consolidatedenrollments as $consolidated) {
            $delivered = $consolidated->conenRequirements;
            $newRequirements = '';
            $separated = explode(',', $delivered);
            for ($i = 0; $i < count($separated); $i++) {

              if ($i == count($separated) - 1) {
                if ($separated[$i] == $documentOld . '-ENTREGADO') {
                  $newRequirements .= $documentNew . '-ENTREGADO';
                } else {
                  $newRequirements .= $separated[$i];
                }
              } else {
                if ($separated[$i] == $documentOld . '-ENTREGADO') {
                  $newRequirements .= $documentNew . '-ENTREGADO,';
                } else {
                  $newRequirements .= $separated[$i] . ',';
                }
              }
            }
            if ($newRequirements !== '') {
              $requirementsCount = DocumentEnroll::where('deStatus', 'ACTIVO')->count();
              $newRequirementsCount = count(explode(',', $newRequirements));
              if ($newRequirementsCount == $requirementsCount) {
                $consolidated->conenStatus = 'COMPLETADO';
              } else if ($newRequirementsCount < $requirementsCount) {
                $consolidated->conenStatus = 'PENDIENTE';
              }
              $consolidated->conenRequirements = $newRequirements;
            }
            $consolidated->save();
          }
        } else if (trim($request->deStatusEdit) == 'INACTIVO') {
          $consolidatedenrollments = ConsolidatedEnroll::all();
          foreach ($consolidatedenrollments as $consolidated) {
            $delivered = $consolidated->conenRequirements;
            $separated = explode(',', $delivered);
            for ($i = 0; $i < count($separated); $i++) {
              if ($separated[$i] == $documentOld . '-ENTREGADO') {
                unset($separated[$i]);
              }
            }
            $newRequirements = '';
            for ($i = 0; $i < count($separated); $i++) {
              if (isset($separated[$i])) {
                if ($i == count($separated) - 1) {
                  $newRequirements .= $separated[$i];
                } else {
                  $newRequirements .= $separated[$i] . ',';
                }
              }
            }
            if ($newRequirements !== '') {
              $consolidated->conenRequirements = $newRequirements;
              $consolidated->save();
            }
          }
        }
        return redirect()->route('documentsEnrollment')->with('PrimaryUpdateDocumentsEnrollment', 'Requisito: ' . trim(ucfirst(strtolower($request->deConceptEdit))) . ', actualizado correctamente');
      } else {
        return redirect()->route('documentsEnrollment')->with('SecondaryUpdateDocumentsEnrollment', 'Ya existe un requisito diferente con el mismo nombre');
      }
    } catch (Exception $ex) {
      return redirect()->route('documentsEnrollment')->with('SecondaryUpdateDocumentsEnrollment', 'Ya existe un requisito diferente con el mismo nombre');
    }
  }

  public function deleteDocumentsEnrollment(Request $request)
  {
    try {
      $documentEnrollmentDelete = DocumentEnroll::find(trim($request->deIdDelete));
      $documentEnrollmentName = $documentEnrollmentDelete->deConcept;
      // DISMINUIR POSICIONES A PARTIR DE LA QUE SE ELIMINARÁ
      if ($documentEnrollmentDelete->deStatus == 'ACTIVO') {
        $documentosPositions = DocumentEnroll::where('dePosition', '>=', trim($request->dePositionDelete))->where('deStatus', 'ACTIVO')->get();
        foreach ($documentosPositions as $document) {
          $document->dePosition -= 1;
          $document->save();
        }
      }
      $documentEnrollmentDelete->delete();

      //VALIDAR TODOS LOS REQUISITOS PARA CAMBIAR EL NOMBRE IGUAL A LA MODIFICACION
      $consolidatedenrollments = ConsolidatedEnroll::all();
      foreach ($consolidatedenrollments as $consolidated) {
        $delivered = $consolidated->conenRequirements;
        $separated = explode(',', $delivered);
        for ($i = 0; $i < count($separated); $i++) {
          if ($separated[$i] == $documentEnrollmentName . '-ENTREGADO') {
            unset($separated[$i]);
          }
        }
        $newRequirements = '';
        for ($i = 0; $i < count($separated); $i++) {
          if (isset($separated[$i])) {
            if ($i == count($separated) - 1) {
              $newRequirements .= $separated[$i];
            } else {
              $newRequirements .= $separated[$i] . ',';
            }
          }
        }
        //dd('ANTERIORES: ' . $delivered . ' NUEVOS: ' . $newRequirements);
        if ($newRequirements !== '') {
          $requirementsCount = DocumentEnroll::where('deStatus', 'ACTIVO')->count();
          $newRequirementsCount = count(explode(',', $newRequirements));
          if ($newRequirementsCount == $requirementsCount) {
            $consolidated->conenStatus = 'COMPLETADO';
          } else if ($newRequirementsCount < $requirementsCount) {
            $consolidated->conenStatus = 'PENDIENTE';
          }
          $consolidated->conenRequirements = $newRequirements;
          $consolidated->save();
        }
      }

      return redirect()->route('documentsEnrollment')->with('WarningDeleteDocumentsEnrollment', 'Requisito: ' . $documentEnrollmentName . ', eliminado correctamente');
    } catch (Exception $ex) {
      return redirect()->route('documentsEnrollment')->with('SecondaryDeleteDocumentsEnrollment', 'No es posible eliminar el requisito');
    }
  }
  /* # DOCUMENTOS/REQUISITOS DE MATRICULA # */

  /* -- CONSOLIDACION DE MATRICULAS -- */
  public function consolidatedEnrollmentTo()
  {
    $consolidatedenrollmentsAll = ConsolidatedEnroll::select('consolidatedenrollments.*', 'students.*')
      ->join('students', 'students.id', 'consolidatedenrollments.conenStudent_id')
      ->where('conenStatus', 'PENDIENTE')->orWhere('conenStatus', 'PENDIENTE DE DOCUMENTOS')
      ->get();
    $documentsActives = DocumentEnroll::where('deStatus', 'ACTIVO')->orderBy('dePosition', 'asc')->get();
    return view('modules.enrollments.consolidated', compact('consolidatedenrollmentsAll', 'documentsActives'));
  }

  public function newConsolidatedEnrollment()
  {
    $requirements = DocumentEnroll::where('deStatus', 'ACTIVO')->orderBy('dePosition', 'asc')->get();
    $students = Student::whereNotExists(function ($query) {
      $query->select(DB::raw(1))
        ->from('consolidatedenrollments')
        ->whereRaw('consolidatedenrollments.conenStudent_id = students.id');
    })->get();
    return view('modules.enrollments.newConsolidated', compact('students', 'requirements'));
  }

  public function updateConsolidatedEnrollmentWithoutDocuments(Request $request)
  {
    $object = ConsolidatedEnroll::find($request->idConsolidated_hidden);
    $object->conenStatus = 'PENDIENTE DE DOCUMENTOS';
    // $object->conenRequirements = $object->conenRequirements . ',SIN DOCUMENTOS-ENTREGADO';
    $object->save();
    $student = Student::find($object->conenStudent_id);
    return redirect()->route('consolidatedEnrollment')->with('PrimaryUpdateConsolidatedEnrollment', 'MATRICULA PARA EL NUEVO ALUMNO: ' . $student->firstname . ' ' . $student->threename . ', FINALIZADA CORRECTAMENTE');
  }
  /* # CONSOLIDACION DE MATRICULAS # */

  /* -- LEGALIZACION DE MATRICULAS -- */
  public function legalizationEnrollmentTo()
  {
    $attendants = Attendant::all();
    $authorizeds = Authorized::all();
    $grades = Grade::all();
    $journeys = Journey::all();
    $listcourse = Listcourse::select('listStudent_id')->get();
    $consolidatedStudentCompleted = ConsolidatedEnroll::select(
      'conenStudent_id',
      'students.firstname',
      'students.threename',
      'students.fourname'
    )->join('students', 'students.id', 'consolidatedenrollments.conenStudent_id')
      ->where('conenStatus', 'COMPLETADO')->orWhere('conenStatus', 'PENDIENTE DE DOCUMENTOS')
      ->get();

    $studentsUnique = array();
    foreach ($consolidatedStudentCompleted as $student) {
      $result = false;
      foreach ($listcourse as $list) {
        if ($student->conenStudent_id == $list->listStudent_id) {
          $result = true;
        }
      }
      //SI ES FALSO ES PORQUE NO HAY UN ESTUDIANTE CON EL ID EN EL LISTADO DE CURSOS Y SE PROCEDE A AGREGARLO EN EL ARRAY
      if (!$result) {
        array_push($studentsUnique, [
          $student->conenStudent_id,
          $student->firstname . ' ' . $student->threename . ' ' . $student->fourname
        ]);
      }
    }
    return view('modules.enrollments.legalization', compact('studentsUnique', 'attendants', 'authorizeds', 'grades', 'journeys'));
  }

  public function newlegalizationEnrollment(Request $request)
  {
    DB::beginTransaction();
    try {
      // dd($request->all());
      $validateLegalization = Legalization::where([
        ['legStudent_id', trim($request->legStudent_id)],
        ['legStatus', 'ACTIVO']
      ])->count();
      if ($validateLegalization == 0) {
        /*** SE CREA UNA NUEVA INSTANCIA DEL MODELO DE LEGALIZACION DE CONTRATO ***/
        $legalization = new Legalization;
        $legalization->legStudent_id = trim($request->legStudent_id);
        $legalization->legAttendantfather_id = (isset($request->legAttendantfather_id) ? trim($request->legAttendantfather_id) : null);
        $legalization->legAttendantmother_id = (isset($request->legAttendantmother_id) ? trim($request->legAttendantmother_id) : null);
        $legalization->legGrade_id = trim($request->legGrade_id);
        $legalization->legJourney_id = trim($request->legJourney_id);
        $legalization->legDateInitial = trim($request->infoLegalizationDateInitialStudent);
        $legalization->legDateFinal = trim($request->infoLegalizationDateFinalStudent);
        $legalization->legDateCreate = date('Y-m-d');
        $legalization->save();

        /*** SE CREA UNA NUEVA INSTANCIA DEL MODELO DE LISTADO DEL CURSO ***/
        $listCourse = new listcourse;
        $listCourse->listGrade_id = trim($request->legGrade_id);
        $listCourse->listCourse_id = null;
        $listCourse->listStudent_id = trim($request->legStudent_id);
        $listCourse->save();

        /*** SE CREA UNA NUEVA INSTANCIA DEL MODELO DE BILLETERA ***/
        $wallet = new Wallet;
        $wallet->waStudent_id = trim($request->legStudent_id);
        $wallet->save();

        if (trim($request->payValuemountContract) == 'Infinity') {
          $request->payValuemountContract = 0;
        }
        if (trim($request->payValuemountEnrollment) == 'Infinity') {
          $request->payValuemountEnrollment = 0;
        }

        /*** SE CREA UNA NUEVA INSTACION DE MODELO DE PAGO ***/
        $pay = new Pay;
        $pay->payValueContract  = trim($request->payValueContract);
        $pay->payDuesQuotationContract = trim($request->payDuesQuotationContract);
        $pay->payValuemountContract = trim($request->payValuemountContract);
        $pay->payDatepaidsContract = trim($request->payDatepaidsContract);
        $pay->payValueEnrollment = trim($request->payValueEnrollment);
        $pay->payDuesQuotationEnrollment = trim($request->payDuesQuotationEnrollment);
        $pay->payValuemountEnrollment = trim($request->payValuemountEnrollment);
        $pay->payDatepaidsEnrollment = trim($request->payDatepaidsEnrollment);
        $pay->payLegalization_id = $legalization->legId;
        $pay->save();


        //GUARDAR CADA FECHA DE PAGO EN LA TABLA DE CONCEPTOS
        $this->setConcepts(trim($request->payDatepaidsContract), trim($request->payDuesQuotationContract), trim($request->payValuemountContract), 'PENSION - CUOTA ', $legalization->legId);
        $this->setConcepts(trim($request->payDatepaidsEnrollment), trim($request->payDuesQuotationEnrollment), trim($request->payValuemountEnrollment), 'MATRICULA - CUOTA ', $legalization->legId);
        //GUARDA LA INFORMACION EN TABLAS LEGALIZACION, LISTA DE CURSO, CARTERA Y PAGOS
        DB::commit();
        return redirect()->route('legalizationEnrollment')->with('SuccessNewLegalizationEnrollment', 'Legalizacion registrada correctamente');
      } else {
        return redirect()->route('legalizationEnrollment')->with('SecondaryNewLegalizationEnrollment', 'Ya existe una legalizacion para el estudiante seleccionado');
      }
    } catch (Exception $ex) {
      DB::rollback();
      return redirect()->route('legalizationEnrollment.new')->with('SecondaryNewLegalizationEnrollment', 'No es posible crear la legalización');
    }
  }


  //FUNCION PARA GUARDAR LAS FECHAS Y CONCEPTOS DE CADA CUOTA QUE DEBA UN ACUDIENTE/CLIENTE
  function setConcepts($datePaids, $countQuotation, $valuemount, $concept, $legalization)
  {
    $date = Date('Y-m-d', strtotime($datePaids));
    if ($countQuotation >= 1) {
      for ($i = 1; $i <= $countQuotation; $i++) {
        if ($i == 1) {
          Concept::create([
            'conDate' => $date,
            'conConcept' => $concept . $i . '/' . $countQuotation,
            'conValue' => $valuemount,
            'conLegalization_id' => $legalization,
          ]);
        } else {
          $date = Date('Y-m-d', strtotime($date . '+ 1 month'));
          Concept::create([
            'conDate' => $date,
            'conConcept' => $concept . $i . '/' . $countQuotation,
            'conValue' => $valuemount,
            'conLegalization_id' => $legalization,
          ]);
        }
      }
    }
  }

  //GENERACION DE PDF DE DOCUMENTOS PENDIENTES POR ENTREGADO DE ESTUDIANTES MATRICULADOS
  public function documentsPendingPdf(Request $request)
  {
    $consolidated = ConsolidatedEnroll::find($request->conenId);
    $documents = DocumentEnroll::where('deStatus', 'ACTIVO')->get();
    if ($consolidated !== null) {
      $arrayDocuments = array();
      $count = 0;
      $send = 0;
      // mb_strtolower(trim($consolidated->conenRequirements)),  mb_strtolower(trim($document->deConcept))
      foreach ($documents as $document) {
        $same = strpos(trim($consolidated->conenRequirements),  trim($document->deConcept));
        if (strlen($same) <= 0) {
          array_push($arrayDocuments, [
            $document->deConcept,
            $document->deRequired,
            'PENDIENTE DE ENTREGA'
          ]);
        } else {
          array_push($arrayDocuments, [
            $document->deConcept,
            $document->deRequired,
            'ENTREGADO'
          ]);
          $send++;
        }
        $count++;
      }
      $datenow = trim($request->dateNow);
      $porcentage = ($send * 100) / $count;
      $student = Student::find($consolidated->conenStudent_id);
      $namefile = 'DOCUMENTOS_PENDIENTES_' . $student->firstname . '_' . $student->threename . '.pdf';
      $pdf = App::make('dompdf.wrapper');
      $pdf->loadView('modules.enrollments.documentsPendingPdf', compact('arrayDocuments', 'student', 'porcentage', 'datenow'));
      return $pdf->download($namefile);
    } else {
      return redirect()->route('consolidatedEnrollment')->with('PrimaryUpdateConsolidatedEnrollment', 'No fue posible generar PDF ahora, Comuniquese con el administrador');
    }
  }
  /* # LEGALIZACION DE MATRICULAS # */

  /* -- CONTRATOS DE LA LEGALIZACION -- */
  public function contractTo()
  {
    $legalizations = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'students.birthdate',
      'grades.name AS nameGrade' //,
      // 'courses.name AS nameCourse'
    )->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      // ->join('courses','courses.id','legalizations.legCourse_id')
      ->where('legStatus', 'ACTIVO')
      ->get();
    $arrayLegalizations = array();
    foreach ($legalizations as $legalization) {
      $father = Attendant::find($legalization->legAttendantfather_id);
      $mother = Attendant::find($legalization->legAttendantmother_id);
      if (isset($father) && isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $father->firstname . ' ' . $father->threename . ' (Acudiente 1) / ' . $mother->firstname . ' ' . $mother->threename . ' (Acudiente 2)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      } elseif (!isset($father) && isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $mother->firstname . ' ' . $mother->threename . ' (Acudiente 2)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      } elseif (isset($father) && !isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $father->firstname . ' ' . $father->threename . ' (Acudiente 1)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      }
    }
    return view('modules.enrollments.contract', compact('arrayLegalizations'));
    // return view('modules.enrollments.contract', compact('legalizations'));
  }

  public function contractPdf(Request $request)
  {
    /*** se debe validar el porque no descargar el pdf ***/
    if ($request->CodeContractForPDF) {
      $legalization = Legalization::find($request->CodeContractForPDF);

      if ($legalization->legAttendantfather_id !== null && $legalization->legAttendantmother_id !== null) {
        $attendantFather = Attendant::find($legalization->legAttendantfather_id);
        $attendantMother = Attendant::find($legalization->legAttendantmother_id);
      } elseif ($legalization->legAttendantfather_id !== null && $legalization->legAttendantmother_id === null) {
        $attendantFather = Attendant::find($legalization->legAttendantfather_id);
      } elseif ($legalization->legAttendantfather_id === null && $legalization->legAttendantmother_id !== null) {
        $attendantMother = Attendant::find($legalization->legAttendantmother_id);
      }
      $student = Student::find($legalization->legStudent_id);
      $grade = Grade::find($legalization->legGrade_id);
      $course = Course::find($legalization->legCourse_id);
      $garden = Garden::select(
        'garden.*',
        'citys.name AS garNameCity',
        'locations.name AS garNameLocation',
        'districts.name AS garNameDistrict'
      )
        ->join('citys', 'citys.id', 'garden.garCity_id')
        ->join('locations', 'locations.id', 'garden.garLocation_id')
        ->join('districts', 'districts.id', 'garden.garDistrict_id')
        ->first();

        $paid = Pay::where('payLegalization_id', $legalization->legId)->get();
        
        $count = $paid->count();
        
      /******************************************************************************************
       *  SE DEBE VALIDAR QUE PAID TRAIGA INFORMACIÓN DE LO CONTRARIO DEBE RETORNAR QUE FALLO   *
       ******************************************************************************************/
      if ($count > 0) {
        if ($legalization !== null && $student !== null && $garden !== null) {
          $namefile = 'CONTRATO_' . $student->firstname . '_' . $student->threename . '.pdf';
          $pdf = App::make('dompdf.wrapper');
          $pdf->loadView('modules.enrollments.contractPdf', compact('legalization', 'attendantFather', 'attendantMother', 'student', 'grade', 'course', 'garden', 'paid'));
          // return $pdf->stream($namefile);
          return $pdf->download($namefile);
        }
      } else {
        return redirect()->route('contracts')->with("SecondaryNewLegalizationEnrollment", "No se encuentra registrada la legalización de matricula");
      }
      return redirect()->route('contracts')->with('SuccessExportContract', 'Contrato generado correctamente');
    } else {
      return redirect()->route('contracts')->with("SecondaryNewLegalizationEnrollment", "Ha ocurrido un error");
    }
  }

  public function contractFinish(Request $request)
  {
    // dd($request->all());
    /*
            $request->argumentFinish
            $request->legId_finish
        */
    $validate = Legalization::find(trim($request->legId_finish));
    if ($validate != null) {
      // 1). Eliminar los conceptos (Estados de cuenta) que esten pendientes relacionados con el contrato
      $concepts = Concept::where('conLegalization_id', $validate->legId)->where('conStatus', 'PENDIENTE')->get();
      foreach ($concepts as $concept) {
        $concept->delete();
      }
      // 2). Eliminar el alumno del grado y curso selecciónado
      $listcourse = Listcourse::where('listStudent_id', $validate->legStudent_id)->first();
      if ($listcourse != null) {
        $listcourse->delete();
      }
      // 3). Eliminar el alumno del la cartera
      $wallet = Wallet::where('waStudent_id', $validate->legStudent_id)->first();
      if ($wallet != null) {
        $wallet->delete();
      }
      // 4). Eliminar el alumno del la tabla de información de pago
      $pay = Pay::where('payLegalization_id', $validate->legId)->first();
      if ($pay != null) {
        $pay->delete();
      }
      // 5). Cambiar de estado del contrato
      $validate->legStatus = 'INACTIVO';
      $validate->legArgument = $this->upper($request->argumentFinish);
      $validate->save();
      return redirect()->route('contracts')->with('SuccessContract', 'Contrato (' . trim($request->legId_finish) . '), finalizado');
    } else {
      return redirect()->route('contracts')->with('SecondaryContract', 'No se encuentra el contrato');
    }
  }
  /* # CONTRATOS DE LA LEGALIZACION # */

  /* -- CERTIFICADOS -- */
  public function certificatesTo()
  {
    $yearnow = Date('Y');
    $students = Legalization::select(
      'students.id AS studentId',
      'students.status',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->whereBetween('legDateInitial', [$yearnow . '-01-01', $yearnow . '-12-31'])
      ->where('legStatus',"ACTIVO")
      ->orderBy('nameStudent', 'asc')
      ->get();
    $garden = Garden::select(
      'garden.*',
      'citys.name AS garNameCity',
      'locations.name AS garNameLocation',
      'districts.name AS garNameDistrict'
    )
      ->join('citys', 'citys.id', 'garden.garCity_id')
      ->join('locations', 'locations.id', 'garden.garLocation_id')
      ->join('districts', 'districts.id', 'garden.garDistrict_id')
      ->first();
    return view('modules.enrollments.certificates', compact('students', 'garden'));
  }

  public function certificatesPdf(Request $request)
  {
    try {
      //dd($request->codeCertificatedPdf);
      if (isset($request->codeCertificatedPdf)) {
        // $listCourse = Listcourse::where('listStudent_id',$request->codeCertificatedPdf)->first();
        $legalization = Legalization::where([['legStudent_id', $request->codeCertificatedPdf],['legStatus',"ACTIVO"]])->first();
        $student = Student::find($legalization->legStudent_id);
        $attendant = Attendant::find($legalization->legAttendantfather_id);
        $birthdate = Carbon::parse($student->birthdate)->locale("es")->isoFormat("LL"); 
        $garden = Garden::select(
          'garden.*',
          'citys.name AS garNameCity',
          'locations.name AS garNameLocation',
          'districts.name AS garNameDistrict'
        )
          ->join('citys', 'citys.id', 'garden.garCity_id')
          ->join('locations', 'locations.id', 'garden.garLocation_id')
          ->join('districts', 'districts.id', 'garden.garDistrict_id')
          ->first();
        if ($legalization !== null && $attendant != null && $student !== null && $garden != null) {
          $namefile = $student->firstname . $student->threename . $student->fourname . '_CertificadoEscolar.pdf';
          $pdf = App::make('dompdf.wrapper');
          $pdf->loadView('modules.enrollments.certificatesPdf', compact('legalization', 'student', 'attendant', 'garden','birthdate'));
          // return $pdf->stream();
          return $pdf->download($namefile);
        }
        return redirect()->route('certificates')->with('SuccessExportCertificate', 'Certificado generado correctamente');
      } else {
      }
    } catch (Exception $ex) {
      return redirect()->route('certificates')->with('SecondaryExportCertificate', 'No fue posible exportar a PDF, comuniquese con el administrador');
    }
  }
  /* # CERTIFICADOS # */

  /* -- ARCHIVO DE CONTRATOS FINALIZADOS -- */
  public function legalizationsfinishedTo()
  {
    $legalizations = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'students.birthdate',
      'grades.name AS nameGrade' //,
      // 'courses.name AS nameCourse'
    )->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      // ->join('courses','courses.id','legalizations.legCourse_id')
      ->where('legStatus', 'INACTIVO')
      ->get();
    $arrayLegalizations = array();
    foreach ($legalizations as $legalization) {
      $father = Attendant::find($legalization->legAttendantfather_id);
      $mother = Attendant::find($legalization->legAttendantmother_id);
      if (isset($father) && isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $father->firstname . ' ' . $father->threename . ' (Acudiente 1) / ' . $mother->firstname . ' ' . $mother->threename . ' (Acudiente 2)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      } elseif (!isset($father) && isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $mother->firstname . ' ' . $mother->threename . ' (Acudiente 2)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      } elseif (isset($father) && !isset($mother)) {
        array_push($arrayLegalizations, [
          $legalization->legId,
          $legalization->nameStudent,
          $father->firstname . ' ' . $father->threename . ' (Acudiente 1)',
          $legalization->nameGrade,
          // $legalization->yearsold
          $legalization->birthdate
        ]);
      }
    }
    return view('modules.enrollments.legalizationsfinished', compact('arrayLegalizations'));
  }

  public function legalizationsfinishedPdf(Request $request)
  {
    // dd($request->all());
    if (isset($request->CodeContractForPDF)) {
      $legalization = Legalization::find($request->CodeContractForPDF);
      if ($legalization->legAttendantfather_id !== null && $legalization->legAttendantmother_id !== null) {
        $attendantFather = Attendant::find($legalization->legAttendantfather_id);
        $attendantMother = Attendant::find($legalization->legAttendantmother_id);
      } elseif ($legalization->legAttendantfather_id !== null && $legalization->legAttendantmother_id === null) {
        $attendantFather = Attendant::find($legalization->legAttendantfather_id);
      } elseif ($legalization->legAttendantfather_id === null && $legalization->legAttendantmother_id !== null) {
        $attendantMother = Attendant::find($legalization->legAttendantmother_id);
      }
      $student = Student::find($legalization->legStudent_id);
      $grade = Grade::find($legalization->legGrade_id);
      $course = Course::find($legalization->legCourse_id);
      $garden = Garden::select(
        'garden.*',
        'citys.name AS garNameCity',
        'locations.name AS garNameLocation',
        'districts.name AS garNameDistrict'
      )
        ->join('citys', 'citys.id', 'garden.garCity_id')
        ->join('locations', 'locations.id', 'garden.garLocation_id')
        ->join('districts', 'districts.id', 'garden.garDistrict_id')
        ->first();
      $paid = Pay::where('payLegalization_id', $legalization->legId)->first();
      //dd($paid);
      if ($legalization !== null && $student !== null && $garden !== null) {
        $namefile = 'CONTRATO_FINALIZADO_' . $student->firstname . '_' . $student->threename . '.pdf';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('modules.enrollments.contractPdf', compact('legalization', 'attendantFather', 'attendantMother', 'student', 'grade', 'course', 'garden', 'paid'));
        return $pdf->download($namefile);
      }
      return redirect()->route('legalizationsfinished')->with('SuccessFinished', 'Legalización de contrato finalizado, generado correctamente!');
    } else {
      return redirect()->route('legalizationsfinished')->with('SecondaryFinished', 'No fue posible exportar a PDF, comuniquese con el administrador');
    }
  }
  /* # ARCHIVO DE CONTRATOS FINALIZADOS # */

  /* CONSULTAS DE CONTRATOS Y MATRICULAS POR MESES */

  function getJanuaryEnrollment(Request $request)
  {
    if (isset($request->year)) {
      $year = $request->year;
    } else {
      $year = date('Y');
    }
    return response()->json($this->lastDay($year . '-01'));
    // $enrollments = ConsolidatedEnroll::whereBetween('legDateCreate', [$year . '-01-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)]);
  }

  function lastDay($month)
  {
    $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
    $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
    return $last_day;
  }

  /* # CONSULTAS DE CONTRATOS Y MATRICULAS POR MESES # */

  /* ===========================================================================================================
            FUNCIONES PARA CONVERTIR CADENAS DE TEXTO (Mayusculas/Minusculas/Solo primera en Mayuscula)
    =========================================================================================================== */

  function upper($string)
  {
    return mb_strtoupper(trim($string), 'UTF-8');
  }

  function lower($string)
  {
    return mb_strtolower(trim($string), 'UTF-8');
  }

  function fu($string)
  {
    return ucfirst(mb_strtolower(trim($string), 'UTF-8'));
  }
}
