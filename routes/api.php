<?php

use App\Models\Attendant;
use App\Models\Bloodtype;
use App\Models\Course;
use App\Models\Entry;
use App\Models\Formadmission;
use App\Models\Health;
use App\Models\InfoDaily;
use App\Models\Listcourse;
use App\Models\Presence;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('sublocation', function (Request $request) {
  if (isset($request->cityhome_id)) {
    $location_from_city = App\Models\Location::where('city_id', '=', $request->cityhome_id)->get();
    return Response::json($location_from_city);
  }
})->name('edit.sublocation');

Route::get('subdistrict', function (Request $request) {
  if (isset($request->locationhome_id)) {
    $district_from_location = App\Models\District::where('location_id', '=', $request->locationhome_id)->get();
    return Response::json($district_from_location);
  }
})->name('edit.subdistrict');

Route::get('subcustomer', function (Request $request) {
  if (isset($request->customer_id)) {
    $customer = App\Models\Customer::where('id', '=', $request->customer_id)->first();
    return Response::json($customer);
  }
})->name('subcustomer');

Route::get('allscheduling', function (Request $request) {
  if (isset($request->scheduling)) {
    $schedulingCustomer = App\Models\Scheduling::where('schedulings.id', $request->scheduling)
      ->select('schedulings.id as schId', 'schedulings.schDateVisit', 'schedulings.schDayVisit', 'schedulings.schHourVisit', 'schedulings.schStatusVisit', 'schedulings.schResultVisit', 'customers.*')
      ->join('customers', 'customers.id', 'schedulings.schCustomer_id')
      ->first();
    return Response::json($schedulingCustomer);
  }
})->name('allscheduling');

Route::get('confirmScheduling', function (Request $request) {
  $result = 'Proceso sin confirmar';
  if (isset($request->schId)) {
    //dd($request->schId);
    $scheduling = App\Models\Scheduling::find($request->schId);
    $dateScheduling = $scheduling->schDateVisit;
    $scheduling->schStatusVisit = 'INACTIVO';
    $scheduling->schResultVisit = 'ASISTIDO';
    $scheduling->schColor = '#a4b068'; //VERDE
    $scheduling->save();
    //return redirect()->route('programming')->with('SuccessConfirmScheduling', 'CITA DE ' . $dateScheduling . ' CONFIRMADA, HA QUEDADO ASISTIDA');
  } else {
    //return redirect()->route('programming')->with('SecondaryConfirmScheduling', 'No es posible confirmar la cita');
  }
  return Response::json($result);
})->name('confirmScheduling');

Route::get('cancelScheduling', function (Request $request) {
  if (isset($request->schId)) {
    //dd($request->schId);
    $scheduling = App\Models\Scheduling::find($request->schId);
    $dateScheduling = $scheduling->schDateVisit;
    $scheduling->schStatusVisit = 'INACTIVO';
    $scheduling->schResultVisit = 'INASISTIDO';
    $scheduling->schColor = '#fd8701'; //NARANJA
    $scheduling->save();
    //return redirect()->route('programming')->with('WarningCancelScheduling', 'CITA DE ' . $dateScheduling . ' CANCELADA, HA QUEDADO INASISTIDA');
  } else {
    //return redirect()->route('programming')->with('SecondaryCancelScheduling', 'No es posible cambiar la cita');
  }
})->name('cancelScheduling');

Route::get('reschedule', function (Request $request) {
  if (isset($request->schId) && isset($request->newDate)) {
    $scheduling = App\Models\Scheduling::find($request->schId);

    //VALIDAR SI CLIENTE YA TIENE UNA CITA PENDIENTE
    $schedulingValidateCustomer = App\Models\Scheduling::where('schCustomer_id', $scheduling->schCustomer_id)
      ->where('schResultVisit', 'PENDIENTE')
      ->where('schedulings.id', '!=', $scheduling->id)->first();
    //dd($schedulingValidateCustomer);
    if ($schedulingValidateCustomer == null) { //CLIENTE NO TIENE CITAS PENDIENTES
      //VALIDAR SI LA CITA A REPROGRAMAR ESTA PENDIENTE O INASISTIDO, SI ESTA ASISTIDA NO ES POSIBLE CAMBIARLA
      if ($scheduling->schResultVisit == 'PENDIENTE' || $scheduling->schResultVisit == 'INASISTIDO') {
        $changeScheduling = 'DE ' . $scheduling->schDateVisit . ' REPROGRAMADA PARA ' . $request->newDate;
        $scheduling->schDateVisit = $request->newDate;
        $scheduling->schStatusVisit = 'ACTIVO';
        $scheduling->schResultVisit = 'PENDIENTE';
        $scheduling->schDayVisit = getDay(strtotime($request->newDate));
        $scheduling->schHourVisit = $request->newHour;
        $scheduling->schColor = '#0086f9'; //AZUL
        $scheduling->save();
        return response()->json('CITA ' . $changeScheduling . ' CORRECTAMENTE');
      } else if ($scheduling->schResultVisit == 'ASISTIDO') {
        //dd($scheduling->schResultVisit);
        return response()->json('CITA ASISTIDA, NO ES POSIBLE REPROGRAMAR, CREE UNA NUEVA CITA PARA EL CLIENTE');
      }
    } else { //CLIENTE YA TIENE UNA CITA PENDIENTE
      $customerWithScheduling = App\Models\Customer::find($schedulingValidateCustomer->schCustomer_id);
      return response()->json('NO ES POSIBLE REPROGRAMAR LA CITA, CLIENTE ' . $customerWithScheduling->cusFirstname . ' ' . $customerWithScheduling->cusLastname . ', Ya cuenta con una cita PENDIENTE');
    }
  }
})->name('reschedule');

function getDay($value)
{ //OBTENER EL NOMBRE DEL DIA EN BASE A UNA FECHA
  switch (date('w', $value)) {
    case 0:
      return 'Domingo';
    case 1:
      return "Lunes";
    case 2:
      return "Martes";
    case 3:
      return "Miercoles";
    case 4:
      return "Jueves";
    case 5:
      return "Viernes";
    case 6:
      return "Sabado";
  }
}

Route::get('selectedCustomerForQuotation', function (Request $request) {
  if (isset($request->customerSelected)) {
    $customer = App\Models\Customer::find($request->customerSelected);
    return response()->json($customer);
  }
})->name('selectedCustomerForQuotation');

Route::get('schedulingActiveFromCustomer', function (Request $request) {
  if (isset($request->customerSelected)) {
    $scheduling = App\Models\Scheduling::where('schedulings.schCustomer_id', $request->customerSelected)
      ->where('schedulings.schStatusVisit', 'INACTIVO')
      ->where('schedulings.schResultVisit', 'ASISTIDO')
      ->where('schedulings.schQuoted', null)
      ->first();
    return response()->json($scheduling);
  }
})->name('schedulingActiveFromCustomer');


/* CONSULTAS DE LOS CONCEPTOS SELECCIONADOS EN LA COTIZACION */

//GRADO SELECCIONADO
Route::get('selectedGradeQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $grade = App\Models\Grade::where('id', $request->selectedConcept)->first();
    return response()->json($grade);
  }
})->name('selectedGradeQuotation');

//ADMISION SELECCIONADA
Route::get('selectedAdmissionQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $admission = App\Models\Admission::where('id', $request->selectedConcept)->first();
    return response()->json($admission);
  }
})->name('selectedAdmissionQuotation');

//JORNADA SELECCIONADA
Route::get('selectedJourneyQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $journey = App\Models\Journey::where('id', $request->selectedConcept)->first();
    return response()->json($journey);
  }
})->name('selectedJourneyQuotation');

//ALIMENTACION SELECCIONADA
Route::get('selectedFeedingQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $feeding = App\Models\Feeding::where('id', $request->selectedConcept)->first();
    return response()->json($feeding);
  }
})->name('selectedFeedingQuotation');

//UNIFORME SELECCIONADO
Route::get('selectedUniformQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $uniform = App\Models\Uniform::where('id', $request->selectedConcept)->first();
    return response()->json($uniform);
  }
})->name('selectedUniformQuotation');

//MATERIAL ESCOLAR SELECCIONADO
Route::get('selectedSupplieQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $supplie = App\Models\Supplie::where('id', $request->selectedConcept)->first();
    return response()->json($supplie);
  }
})->name('selectedSupplieQuotation');

//TRANSPORTE SELECCIONADO
Route::get('selectedExtratimeQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $extratime = App\Models\Extratime::where('id', $request->selectedConcept)->first();
    return response()->json($extratime);
  }
})->name('selectedExtratimeQuotation');

//TRANSPORTE SELECCIONADO
Route::get('selectedTransportQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $transport = App\Models\Transport::where('id', $request->selectedConcept)->first();
    return response()->json($transport);
  }
})->name('selectedTransportQuotation');

//TIEMPO EXTRA SELECCIONADO
Route::get('selectedExtratimeQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $extratime = App\Models\Extratime::where('id', $request->selectedConcept)->first();
    return response()->json($extratime);
  }
})->name('selectedExtratimeQuotation');

//EXTRACURRICULAR SELECCIONADO
Route::get('selectedExtracurricularQuotation', function (Request $request) {
  if (isset($request->selectedConcept)) {
    $extracurricular = App\Models\Extracurricular::where('id', $request->selectedConcept)->first();
    return response()->json($extracurricular);
  }
})->name('selectedExtracurricularQuotation');

//CONSULTAR INFORMACION TOTAL DE LA PROPUESTA PARA MOSTRAR EN VENTANA MODAL PARA EXPORTAR A PDF
Route::get('importAllProposal', function (Request $request) {
  if (isset($request->proposalSelected)) {
    $arrayProposal = array();
    $consolidatedProposal = App\Models\Proposal::find($request->proposalSelected);

    $customer = App\Models\Customer::find($consolidatedProposal->proCustomer_id);
    $grade = App\Models\Grade::find($consolidatedProposal->proGrade_id);

    array_push($arrayProposal, [
      $consolidatedProposal->proDateQuotation,
      $consolidatedProposal->proStatus,
      $consolidatedProposal->proResult,
      $consolidatedProposal->proValueQuotation,
      $customer->cusFirstname . ' ' . $customer->cusLastname,
      $customer->cusPhone,
      $customer->cusMail,
      $customer->cusChild,
      $customer->cusChildYearsold,
      $customer->cusNotes,
      $consolidatedProposal->proScheduling_id,
      $grade->name
    ]);

    if ($consolidatedProposal->proAdmission_id != null && strlen($consolidatedProposal->proAdmission_id) > 0) {
      $separatedAdmission = explode(':', $consolidatedProposal->proAdmission_id);
      for ($i = 0; $i < count($separatedAdmission); $i++) {
        $admission = App\Models\Admission::find($separatedAdmission[$i]);
        if ($admission != null) {
          array_push($arrayProposal, [
            'ADMISION',
            $admission->admConcept,
            $admission->admValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proJourney_id != null && strlen($consolidatedProposal->proJourney_id) > 0) {
      $separatedJourney = explode(':', $consolidatedProposal->proJourney_id);
      for ($i = 0; $i < count($separatedJourney); $i++) {
        $journey = App\Models\Journey::find($separatedJourney[$i]);
        if ($journey != null) {
          array_push($arrayProposal, [
            'JORNADA',
            $journey->jouJourney,
            $journey->jouDays,
            $journey->jouHourEntry,
            $journey->jouHourExit,
            $journey->jouValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proFeeding_id != null && strlen($consolidatedProposal->proFeeding_id) > 0) {
      $separatedFeeding = explode(':', $consolidatedProposal->proFeeding_id);
      for ($i = 0; $i < count($separatedFeeding); $i++) {
        $feeding = App\Models\Feeding::find($separatedFeeding[$i]);
        if ($feeding != null) {
          array_push($arrayProposal, [
            'ALIMENTACION',
            $feeding->feeConcept,
            $feeding->feeValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proUniform_id != null && strlen($consolidatedProposal->proUniform_id) > 0) {
      $separatedUniform = explode(':', $consolidatedProposal->proUniform_id);
      for ($i = 0; $i < count($separatedUniform); $i++) {
        $uniform = App\Models\Uniform::find($separatedUniform[$i]);
        if ($uniform != null) {
          array_push($arrayProposal, [
            'UNIFORME',
            $uniform->uniConcept,
            $uniform->uniValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proSupplie_id != null && strlen($consolidatedProposal->proSupplie_id) > 0) {
      $separatedSupplie = explode(':', $consolidatedProposal->proSupplie_id);
      for ($i = 0; $i < count($separatedSupplie); $i++) {
        $supplie = App\Models\Supplie::find($separatedSupplie[$i]);
        if ($supplie != null) {
          array_push($arrayProposal, [
            'MATERIAL ESCOLAR',
            $supplie->supConcept,
            $supplie->supValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proTransport_id != null && strlen($consolidatedProposal->proTransport_id) > 0) {
      $separatedTransport = explode(':', $consolidatedProposal->proTransport_id);
      for ($i = 0; $i < count($separatedTransport); $i++) {
        $transport = App\Models\Transport::find($separatedTransport[$i]);
        if ($transport != null) {
          array_push($arrayProposal, [
            'TRANSPORTE',
            $transport->traConcept,
            $transport->traValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proExtratime_id != null  && strlen($consolidatedProposal->proExtratime_id) > 0) {
      $separatedExtratime = explode(':', $consolidatedProposal->proExtratime_id);
      for ($i = 0; $i < count($separatedExtratime); $i++) {
        $extratime = App\Models\Extratime::find($separatedExtratime[$i]);
        if ($extratime != null) {
          array_push($arrayProposal, [
            'TIEMPO EXTRA',
            $extratime->extTConcept,
            $extratime->extTValue
          ]);
        }
      }
    }
    if ($consolidatedProposal->proExtracurricular_id != null && strlen($consolidatedProposal->proExtracurricular_id) > 0) {
      $separatedExtracurricular = explode(':', $consolidatedProposal->proExtracurricular_id);
      for ($i = 0; $i < count($separatedExtracurricular); $i++) {
        $extracurricular = App\Models\Extracurricular::find($separatedExtracurricular[$i]);
        if ($extracurricular != null) {
          array_push($arrayProposal, [
            'EXTRACURRICULAR',
            $extracurricular->extConcept,
            $extracurricular->extIntensity,
            $extracurricular->extValue
          ]);
        }
      }
    }
    return response()->json($arrayProposal);
  }
})->name('importAllProposal');



/* RUTAS DE DOCUMENTOS PARA MATRICULAS  */

//BUSCAR ESTUDIANTE SELECCIONADO EN LA MATRICULA NUEVA
Route::get('conenStudentSelected', function (Request $request) {
  $student = App\Models\Student::select(
    'students.*',
    'documents.type',
    'bloodtypes.group as groupBlood',
    'bloodtypes.type as typeBlood',
    'healths.entity as entityHealth',
    'healths.type as typeHealth',
    'citys.name as nameCity',
    'locations.name as nameLocation',
    'districts.name as nameDistrict'
  )
    ->join('documents', 'documents.id', 'students.typedocument_id')
    ->join('bloodtypes', 'bloodtypes.id', 'students.bloodtype_id')
    ->join('healths', 'healths.id', 'students.health_id')
    ->join('citys', 'citys.id', 'students.cityhome_id')
    ->join('locations', 'locations.id', 'students.locationhome_id')
    ->join('districts', 'districts.id', 'students.dictricthome_id')
    ->where('students.id', $request->selectedStudent)->first();
  //dd($student);
  return response()->json($student);
})->name('conenStudentSelected');

//BUSCAR ESTUDIANTE SELECCIONADO EN LA MATRICULA NUEVA
Route::post('saveConsolidatedEnrollment', function (Request $request) {
  $values = json_decode($request->jsonItems);
  //dd($values);
  $checkItems = '';
  $checkStudent = 0;
  $checkStatus = '';
  $add = 0;
  foreach ($values as $value) {

    if ($add < 2) {
      if ($add == 0) {
        $checkStudent = $value;
      } else if ($add == 1) {
        $checkStatus = $value;
      }
    } else if ($add >= 2) {
      if ($value == end($values)) {
        $checkItems .= $value;
      } else {
        $checkItems .= $value . ',';
      }
    }
    $add++;
  }
  $validateConsolidated = App\Models\ConsolidatedEnroll::where('conenStudent_id', $checkStudent)->first();
  if ($validateConsolidated === null) {
    App\Models\ConsolidatedEnroll::create([
      'conenStudent_id' => $checkStudent,
      'conenStatus' => $checkStatus,
      'conenRequirements' => $checkItems,
    ]);
    return response()->json('MATRICULA CREADA CORRECTAMENTE');
  } else {
    return response()->json('YA EXISTE EL ESTUDIANTE SELECCIONADO CON MATRICULA EN ESTADO: ' . $validateConsolidated->conenStatus);
  }
})->name('saveConsolidatedEnrollment');


//ACTUALIZAR REQUISITOS DE MATRICULA
Route::post('updateConsolidatedEnrollment', function (Request $request) {
  $values = json_decode($request->jsonItems);
  //dd($values);
  $checkItems = '';
  $checkConsolidated = 0;
  $checkStudent = 0;
  $checkStatus = '';
  $add = 0;
  foreach ($values as $value) {

    if ($add < 3) {
      if ($add == 0) {
        $checkConsolidated = $value;
      } else if ($add == 1) {
        $checkStudent = $value;
      } else if ($add == 2) {
        $checkStatus = $value;
      }
    } else if ($add >= 3) {
      if ($value == end($values)) {
        $checkItems .= $value;
      } else {
        $checkItems .= $value . ',';
      }
    }
    $add++;
  }

  $objectConsolidatedUpdate = App\Models\ConsolidatedEnroll::where('conenId', $checkConsolidated)->where('conenStudent_id', $checkStudent)->first();

  if ($objectConsolidatedUpdate !== null) {
    $objectConsolidatedUpdate->conenStatus = $checkStatus;
    $objectConsolidatedUpdate->conenRequirements = $checkItems;
    $objectConsolidatedUpdate->save();
    //return redirect()->route('consolidatedEnrollment')->with('PrimaryUpdateConsolidatedEnrollment', 'MATRICULA CON ID ' . $checkConsolidated . ' ACTUALIZADA CORRECTAMENTE');
    return response()->json('MATRICULA CON ID ' . $checkConsolidated . ' ACTUALIZADA CORRECTAMENTE');
  } else {
    return response()->json('NO SE HA ENCONTRADO LA MATRICULA CON EL ID INDICADO');
  }
})->name('updateConsolidatedEnrollment');

/* CONSULTAS PARA EDICION O CONTINUACION DE MATRICULA MODAL DE CONSOLIDATED.BLADE.PHP */

//TIPO DE DOCUMENTO DE ESTUDIANTE
Route::get('getTypeDocument', function (Request $request) {
  $document = App\Models\Document::select('type')->where('id', $request->id)->first();
  return response()->json($document);
})->name('getTypeDocument');

//TIPO DE SANGRE DE ESTUDIANTE
Route::get('getTypeBlood', function (Request $request) {
  $bloodtype = App\Models\Bloodtype::select(DB::raw("CONCAT(bloodtypes.group,' ',bloodtypes.type) AS bloodtypeStudent"))->where('id', $request->id)->first();
  return response()->json($bloodtype);
})->name('getTypeBlood');

//CIUDAD DE ESTUDIANTE
Route::get('getCity', function (Request $request) {
  $city = App\Models\City::select('name')->where('id', $request->id)->first();
  return response()->json($city);
})->name('getCity');

//LOCALIDAD DE ESTUDIANTE
Route::get('getLocation', function (Request $request) {
  $location = App\Models\Location::select('name')->where('id', $request->id)->first();
  return response()->json($location);
})->name('getLocation');

//BARRIO DE ESTUDIANTE
Route::get('getDistrict', function (Request $request) {
  $district = App\Models\District::select('name')->where('id', $request->id)->first();
  return response()->json($district);
})->name('getDistrict');

//CENTRO DE SALUD DE ESTUDIANTE
Route::get('getHealth', function (Request $request) {
  $health = App\Models\Health::select(DB::raw("CONCAT(healths.entity,'-',healths.type) AS healthStudent"))->where('id', $request->id)->first();
  return response()->json($health);
})->name('getHealth');



//SELECCIONAR ESTUDIANTE PARA LEGALIZACION DE MATRICULA
Route::post('legStudentSelected', function (Request $request) {
  $arreglo = [];
  $student = App\Models\Student::select(
    'students.*',
    'documents.type'
  )
    ->join('documents', 'documents.id', 'students.typedocument_id')
    ->where('students.id', $request->selectedStudent)->first();
  $data = Formadmission::where('numerodocumento', $student->numberdocument)->first();
  $acudiente1 = Attendant::where('numberdocument', $data->documentoacudiente1)->join('documents', 'documents.id', 'typedocument_id')->select('attendants.id', 'documents.type', 'attendants.numberdocument', 'attendants.firstname', 'attendants.firstname', 'threename')->first();
  $acudiente2 = Attendant::where('numberdocument', $data->documentoacudiente2)->join('documents', 'documents.id', 'typedocument_id')->select('attendants.id', 'documents.type', 'attendants.numberdocument', 'attendants.firstname', 'attendants.firstname', 'threename')->first();
  $arreglo[0] = $student;
  $arreglo[1] = $acudiente1;
  $arreglo[2] = $acudiente2;

  return response()->json($arreglo);
})->name('legStudentSelected');

//SELECCIONAR CURSO DE GRADO SELECCIONADO PARA LEGALIZACION DE MATRICULA
Route::get('legGradeSelected', function (Request $request) {
  $courses = App\Models\Course::where('grade_id', $request->selectedGrade)->get();
  return response()->json($courses);
})->name('legGradeSelected');

//BUSCAR LA LISTA COMPLETA DEL GRADO Y CURSO SELECCIONADO PARA MOSTRAR TABLA EN LEGALIZACION DE MATRICULA
Route::get('legCourseSelectedForList', function (Request $request) {
  $listCourse = App\Models\Listcourse::select(
    'students.*'
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listGrade_id', $request->selectedGrade)
    ->where('listCourse_id', $request->selectedCourse)->get();
  //dd($listCourse);
  return response()->json($listCourse);
})->name('legCourseSelectedForList');

//SELECCIONAR ACUDIENTE PARA LEGALIZACION DE MATRICULA
Route::get('legAttendantSelected', function (Request $request) {
  $attendant = App\Models\Attendant::select(
    'attendants.*',
    'documents.type'
  )
    ->join('documents', 'documents.id', 'attendants.typedocument_id')
    ->where('attendants.id', $request->selectedAttendant)->first();
  return response()->json($attendant);
})->name('legAttendantSelected');

//SELECCIONAR ACUDIENTE PARA LEGALIZACION DE MATRICULA
Route::get('legAuthorizedSelected', function (Request $request) {
  $authorized = App\Models\Authorized::select(
    'authorized.*',
    'documents.type'
  )
    ->join('documents', 'documents.id', 'authorized.autDocument_id')
    ->where('authorized.autId', $request->selectedAuthorized)->first();
  return response()->json($authorized);
})->name('legAuthorizedSelected');

//BUSCAR DATOS DE ACUERDO AL ID DEL ESTUDIANTE PARA VER DETALLES DEL CERTIFICADO ESCOLAR
Route::get('getDatesCertificate', function (Request $request) {
  $legalization = App\Models\Legalization::select(
    'students.*',
    'legalizations.legId',
    'legalizations.legDateInitial',
    'legalizations.legDateFinal',
    DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
    'attendants.numberdocument as numberAttendant'
  )
    ->join('students', 'students.id', 'legalizations.legStudent_id')
    ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
    ->where("legStatus", "ACTIVO")
    ->where('legStudent_id', $request->selectedStudent)->first();

  return response()->json($legalization);
})->name('getDatesCertificate');



//TOTAL DE ALUMNOS MATRICULADOS DEL CURSO SELECCIONADO PARA ASIGNAR UN DIRECTOR DE GRUPO EN TABLA
Route::get('getCountStudent', function (Request $request) {
  $countStudent = App\Models\Listcourse::where('listCourse_id', $request->selectedCourse)->count();
  return response()->json($countStudent);
})->name('getCountStudent');

//INFORMACION DE CURSO
Route::get('getInfoCourseConsolidated', function (Request $request) {
  $infoCourse = App\Models\CourseConsolidated::select(
    'coursesconsolidated.*',
    'grades.name AS nameGrade',
    'collaborators.id AS idCollaborator',
    DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator")
  )
    ->join('grades', 'grades.id', 'coursesconsolidated.ccGrade_id')
    ->join('collaborators', 'collaborators.id', 'coursesconsolidated.ccCollaborator_id')
    ->where('ccCourse_id', $request->courseSelected)->first();
  return response()->json($infoCourse);
})->name('getInfoCourseConsolidated');


//GUARDAR CADA ACTIVIDAD EN EL HORARIO SEMANAL
Route::get('saveHourweek', function (Request $request) {
  // dd($request->all());

  //$nuevafecha = strtotime($request->dateInitial)
  //$dayYearRound = date('z',strtotime($request->date));
  //dd('DIA: ' .  $request->date . ' DIA DE LA SEMANA: ' . $dayWeekRound . ' DIA DEL AÑO: ' . $dayYearRound);
  $date = date($request->date);
  $dateInitial = date($request->dateInitial);
  $dateFinal = date($request->dateFinal);
  /*
	$request->dateInitial
	$request->dateFinal
	$request->date
	$request->hourInitial
	$request->hourFinal
	$request->day
	$request->class
	$request->space
	$request->collaborator
	$request->course
	$request->allDays

	checkdate($dia,$mes,$año);
	*/
  $occupied = 0;
  $countDays = 0;
  //dd($request->allDays);
  if ($date >= $dateInitial && $date <= $dateFinal) {
    if ($request->allDays == 'SI') {
      //SI EL USUARIO SELECCIONA GUARDAR HORARIO PARA TODOS LOS DIAS DEL SELECCIONADO DENTRO DEL RANGO DE FECHAS
      $initial = strtotime($dateInitial);
      $final = strtotime($dateFinal);
      for ($i = $initial; $i <= $final; $i += 86400) {
        $day = date('w', $i);
        if ($day == $request->day) {
          $newDate = date('Y-m-j', $i);
          //dd(formatDate($newDate));
          $hourWeekValidate = App\Models\Hourweek::where('hwDate', trim($newDate))
            ->where('hwHourInitial', $request->hourInitial)
            ->where('hwActivitySpace_id', $request->space)
            ->first();
          if ($hourWeekValidate == null) {
            App\Models\Hourweek::create([
              'hwDate' => trim($newDate),
              'hwHourInitial' => $request->hourInitial,
              'hwHourFinal' => $request->hourFinal,
              'hwDay' => $request->day,
              'hwActivityClass_id' => $request->class,
              'hwActivitySpace_id' => $request->space,
              'hwCollaborator_id' => $request->collaborator,
              'hwCourse_id' => $request->course
            ]);
            $countDays++;
          } else {
            $occupied++;
            /*$collaborator = App\Models\Collaborator::find($hourWeekValidate->hwCollaborator_id);
			    		$space = App\Models\ActivitySpace::find($hourWeekValidate->hwActivitySpace_id);
			    		$course = App\Models\Course::find($hourWeekValidate->hwCourse_id);
			    		return response()->json('EL ESPACIO YA ESTA PROGRAMADO PARA EL CURSO ' . $course->name . ' CON EL PROFESOR ' . $collaborator->firstname . ' ' . $collaborator->threename);*/
          }
        }
      }
      if ($occupied > 0) {
        if ($occupied == 1) {
          if ($countDays == 1) {
            return response()->json('PROGRAMADO PARA ' . $countDays . ' DIA ENTRE EL RANGO DE FECHAS DEL CURSO, SIN EMBARGO UN DIA A PROGRAMAR TENIA EL ESPACIO OCUPADO POR LO QUE SE OMITIÓ');
          } else if ($countDays > 1) {
            return response()->json('PROGRAMADO PARA ' . $countDays . ' DIAs ENTRE EL RANGO DE FECHAS DEL CURSO, SIN EMBARGO UN DIA A PROGRAMAR TENIA EL ESPACIO OCUPADO POR LO QUE SE OMITIÓ');
          }
        } else if ($occupied > 1) {
          if ($countDays == 1) {
            return response()->json('PROGRAMADO PARA ' . $countDays . ' DIA ENTRE EL RANGO DE FECHAS DEL CURSO, SIN EMBARGO ' . $occupied . ' DIAS A PROGRAMAR TENIA EL ESPACIO OCUPADO POR LO QUE SE OMITIERON');
          } else if ($countDays > 1) {
            return response()->json('PROGRAMADO PARA ' . $countDays . ' DIAS ENTRE EL RANGO DE FECHAS DEL CURSO, SIN EMBARGO ' . $occupied . ' DIAS A PROGRAMAR TENIA EL ESPACIO OCUPADO POR LO QUE SE OMITIERON');
          }
        }
      } else {
        if ($countDays == 1) {
          return response()->json('PROGRAMADO PARA ' . $countDays . ' DIA ENTRE EL RANGO DE FECHAS DEL CURSO');
        } else if ($countDays > 1) {
          return response()->json('PROGRAMADO PARA ' . $countDays . ' DIAs ENTRE EL RANGO DE FECHAS DEL CURSO');
        }
      }
    } else if ($request->allDays == 'NO') {
      //SI EL USUARIO SELECCIONA GUARDAR HORARIO SOLO PARA EL DIA SELECCIONADO
      $hourWeekValidate = App\Models\Hourweek::where('hwDate', trim($date))
        ->where('hwHourInitial', $request->hourInitial)
        ->where('hwActivitySpace_id', $request->space)
        ->first();
      if ($hourWeekValidate == null) {
        App\Models\Hourweek::create([
          'hwDate' => trim($date),
          'hwHourInitial' => $request->hourInitial,
          'hwHourFinal' => $request->hourFinal,
          'hwDay' => $request->day,
          'hwActivityClass_id' => $request->class,
          'hwActivitySpace_id' => $request->space,
          'hwCollaborator_id' => $request->collaborator,
          'hwCourse_id' => $request->course
        ]);
        return response()->json('ESPACIO PROGRAMADO CORRECTAMENTE PARA EL ' . trim($date) . ', ACTUALICE LA PAGINA');
      } else {
        $collaborator = App\Models\Collaborator::find($hourWeekValidate->hwCollaborator_id);
        $space = App\Models\ActivitySpace::find($hourWeekValidate->hwActivitySpace_id);
        $course = App\Models\Course::find($hourWeekValidate->hwCourse_id);
        return response()->json('EL ESPACIO YA ESTA PROGRAMADO PARA EL CURSO ' . $course->name . ' CON EL PROFESOR ' . $collaborator->firstname . ' ' . $collaborator->threename);
      }
    }
  } else {
    return response()->json('FUERA DEL RANGO INICIAL ==> ' . $dateInitial . ' FECHA DE HORARIO ==> ' . $date . ' FINAL ==> ' . $dateFinal);
  }

  //return response()->json($infoCourse);
})->name('saveHourweek');

function formatDate($value)
{
  $separated = explode("-", $value);

  $dateFormated = $separated[0] . '-' . $separated[1] . '-';

  if ($separated[2] < 10) {
    $dateFormated .= '0' . $separated[2];
  } else {
    $dateFormated .= $separated[2];
  }
  return $dateFormated;
}

function ramdonColor($pos)
{
  $colors = ['#ff5500', '#627700', '#0086f9', '#fd8701', '#a4b068', '#85c4f9'];
  return $colors[$pos];
}

Route::get('getAllHourWeek', function (Request $request) {
  $infoHourWeek = App\Models\Hourweek::select(
    'hoursweek.hwId AS id',
    // 'hoursweek.hwDate AS start',
    DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
    DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
    'hoursweek.hwHourInitial',
    'hoursweek.hwHourFinal',
    DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
    DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
  )
    ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
    ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
    ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')->get();
  return response()->json($infoHourWeek);
})->name('getAllHourWeek');

Route::get('getDetailsHourweek', function (Request $request) {
  //$infoHourWeek = App\Models\Hourweek::find($request->hwId);
  $infoHourWeek = App\Models\Hourweek::select(
    'hoursweek.*',
    'activityclass.*',
    'activityspaces.*',
    'collaborators.*',
    'courses.*'
  )
    ->join('activityclass', 'activityclass.acId', 'hoursweek.hwActivityClass_id')
    ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
    ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
    ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
    ->where('hwId', $request->hwId)->first();
  return response()->json($infoHourWeek);
})->name('getDetailsHourweek');

// FILTRO DE HORARIO SEMANAL GENERAL
Route::get('getFilterHourWeek', function (Request $request) {
  switch ($request->type) {
    case 'SPACE':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwActivitySpace_id', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
    case 'ACTIVITY':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwActivityClass_id', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
    case 'COURSE':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwCourse_id', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
    case 'COLLABORATOR':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwCollaborator_id', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
    case 'HOUR':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwHourInitial', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
    case 'DAY':
      $hourweeks = App\Models\Hourweek::select(
        'hoursweek.hwId AS id',
        // 'hoursweek.hwDate AS start',
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourInitial) AS start"),
        DB::raw("CONCAT(hoursweek.hwDate,' ',hoursweek.hwHourFinal)"),
        'hoursweek.hwHourInitial',
        'hoursweek.hwHourFinal',
        DB::raw("CONCAT(collaborators.firstname,'  ',collaborators.fourname) AS nameCollaborator"),
        DB::raw("CONCAT(courses.name,' - ',collaborators.firstname,'  ',collaborators.fourname,' - ',activityspaces.asSpace) AS title")
      )
        ->join('collaborators', 'collaborators.id', 'hoursweek.hwCollaborator_id')
        ->join('courses', 'courses.id', 'hoursweek.hwCourse_id')
        ->join('activityspaces', 'activityspaces.asId', 'hoursweek.hwActivitySpace_id')
        ->where('hwDate', trim($request->filter))
        ->get();
      return response()->json($hourweeks);
  }
})->name('getFilterHourWeek');



//OBTENER LOS PERIODODS ACADEMICOS DEL CURSO SELECCIONADO EN LA PLANEACION CRONOLOGICA
Route::get('getAcademicPeriodsCourse', function (Request $request) {
  $periods = App\Models\Academicperiod::select('apId', 'apNameperiod')->where('apCourse_id', $request->courseSelected)->get();
  return response()->json($periods);
})->name('getAcademicPeriodsCourse');

//OBTENER LA FECHA DE INICIO Y TERMINACION DE ACUERDO AL PERIODO SELECCIONADO EN LA PLANEACION CRONOLOGICA
Route::get('getRangePeriod', function (Request $request) {
  $range = App\Models\Academicperiod::select('apDateInitial', 'apDateFinal')->where('apId', $request->periodSelected)->first();
  return response()->json($range);
})->name('getRangePeriod');

//OBTENER LA DESCRIPCION DE LA INTELLIGENCIA SELECCIONADA EN LA PLANEACION CRONOLOGICA
Route::get('getDescriptionIntelligence', function (Request $request) {
  $description = App\Models\Intelligence::select('description')->where('id', $request->intelligenceSelected)->first();
  return response()->json($description);
})->name('getDescriptionIntelligence');

//OBTENER LAS BASES DE ACTIVIDAD DE LA INTELLIGENCIA SELECCIONADA EN LA PLANEACION CRONOLOGICA
Route::get('getBasesFromIntelligence', function (Request $request) {
  $bases = App\Models\Baseactivity::where('baIntelligence_id', $request->intelligenceSelected)->get();
  return response()->json($bases);
})->name('getBasesFromIntelligence');

//OBTENER LAS SEMANAS DEL RANGO DEL PERIODO SELECCIONADO PARA EL SEGUIMIENTO SEMANAL DEL ALUMNO
Route::get('getRangeWeek', function (Request $request) {
  $weeks = App\Models\Chronological::where('chAcademicperiod_id', trim($request->periodSelected))
    ->where('chCourse_id', trim($request->courseSelected))
    ->get();
  $repeatWeek = '';
  $allWeeks = array();
  foreach ($weeks as $week) {
    $findWeek = strpos($repeatWeek, (string)$week->chNumberWeek);
    if ($findWeek === false) {
      array_push($allWeeks, [$week->chNumberWeek, $week->chRangeWeek]);
      $repeatWeek .= $week->chNumberWeek . ',';
    }
  }
  return response()->json($allWeeks);
})->name('getRangeWeek');

//OBTENER LOS LOGROS DE LA INTELIGENCIA SELECIONADA EN EL SEGUIMIENTO SEMANAL DEL ALUMNO
Route::get('getAchievement', function (Request $request) {
  $achievements = App\Models\Achievement::select('id', 'name')->where('intelligence_id', trim($request->intelligenceSelected))
    ->get();
  return response()->json($achievements);
})->name('getAchievement');

//OBTENER LOS LOGROS DE LA INTELIGENCIA SELECIONADA EN EL SEGUIMIENTO SEMANAL DEL ALUMNO
Route::get('getStudentCourseSelected', function (Request $request) {
  $students = App\Models\Listcourse::select(
    'students.id as idStudent',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listCourse_id', $request->courseSelected)
    ->get();
  return response()->json($students);
})->name('getStudentCourseSelected');


//OBTENER LAS BASES DE ACTIVIDADES DE LA SEMANA SELECIONADA EN EL SEGUIMIENTO SEMANAL
Route::get('getBasesFromWeek', function (Request $request) {
  $chronologicals = App\Models\Chronological::where('chAcademicperiod_id', trim($request->periodSelected))
    ->where('chCourse_id', trim($request->courseSelected))
    ->where('chNumberWeek', trim($request->numberWeek))
    ->get();
  $arrayBases = array();
  $allBases = '';
  foreach ($chronologicals as $chronological) {
    $separatedBases = explode(':', $chronological->chBases);
    for ($i = 0; $i < count($separatedBases); $i++) {
      $findBase = strpos($allBases, (string)$separatedBases[$i]);
      if ($findBase === false) {
        $base = App\Models\Baseactivity::find($separatedBases[$i]);
        if ($base != null) {
          array_push($arrayBases, [
            $base->baIntelligence_id,
            [
              $base->baId,
              $base->baDescription
            ]
          ]);
        }
        $allBases .= $separatedBases[$i] . ',';
      }
    }
  }
  $intelligences = App\Models\Intelligence::all();
  $set = array();
  // dd($arrayBases);
  foreach ($intelligences as $intelligence) {
    $items = array();
    for ($i = 0; $i < count($arrayBases); $i++) {
      if ($arrayBases[$i][0] == $intelligence->id) {
        array_push(
          $items,
          [
            $arrayBases[$i][1][0],
            $arrayBases[$i][1][1],
          ]
        );
      }
    }
    if (count($items) > 0) {
      array_push($set, [
        $intelligence->id,
        $intelligence->type,
        $items
      ]);
    }
  }
  return response()->json($set);
})->name('getBasesFromWeek');


//GUARDAR EL SEGUIMIENTO Y LOS LOGROS CONFIGURADOS LLAMANDO AL METODO DEL CONTROLADOR
//Route::post('saveWeekTracking','WeeklytrackingsController@newWeekTracking')->name('saveWeekTracking');


Route::get('getInfoBasicStudentPeriodClosing', function (Request $request) {
  $periodStudent = App\Models\Weeklytracking::select(
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'students.numberdocument as documentStudent',
    'academicperiods.*',
    'courses.name As nameCourse',
    'courses.id As idCourse'
  )
    ->join('students', 'students.id', 'weeklytrackings.wtStudent_id')
    ->join('academicperiods', 'academicperiods.apId', 'weeklytrackings.wtPeriod_id')
    ->join('courses', 'courses.id', 'weeklytrackings.wtCourse_id')
    ->where('wtStudent_id', $request->studentSelected)
    ->distinct('weeklytrackings.wtPeriod_id')
    ->get();
  //dd($periodStudent);
  return response()->json($periodStudent);
})->name('getInfoBasicStudentPeriodClosing');

// OBTENER INFORMACION GENERAL DEL PERIODO DE UN ALUMNO (INFORME DE PERIODO)
Route::get('getReportPeriod', function (Request $request) {
  // dd($request->all());
  $itemsIntelligence = array();
  $intelligences = App\Models\Intelligence::all();
  foreach ($intelligences as $intelligence) {
    $weeklytrackings = App\Models\Weeklytracking::where('wtCourse_id', trim($request->courseSelected))
      ->where('wtPeriod_id', trim($request->periodSelected))
      ->where('wtStudent_id', trim($request->studentSelected))
      ->where('wtIntelligence_id', $intelligence->id)
      ->get();

    $itemsPercentaje = 0;
    $totalPercentaje = 0;
    foreach ($weeklytrackings as $weeklytracking) {
      $totalPercentaje += $weeklytracking->wtNote;
      $itemsPercentaje++;
    }
    if ($itemsPercentaje > 0) {
      $total = bcdiv(($totalPercentaje / $itemsPercentaje), '1', 1);
    } else {
      $total = 'N/A';
    }
    array_push($itemsIntelligence, [$intelligence->id, $intelligence->type, $total]);
  }
  return response()->json($itemsIntelligence);
})->name('getReportPeriod');

//OBTENER LAS SEMANAS DEL PERIODO SELECCIONADO
Route::get('getWeekPeriodClosing', function (Request $request) {
  // dd($request->all());
  /*
		$request->periodSelected
		$request->studentSelected
		$request->typeRequest
	*/

  if ($request->typeRequest == 'BULLETIN PERIOD PDF') {
    $bulletin = App\Models\Bulletin::where('buStudent_id', trim($request->studentSelected))
      ->where('buPeriod_id', trim($request->periodSelected))
      ->first();
    $all = array();
    $itemsIntelligence = array();
    $student = App\Models\Student::find(trim($bulletin->buStudent_id));
    $course = App\Models\Course::find(trim($bulletin->buCourse_id));
    $period = App\Models\Academicperiod::find(trim($bulletin->buPeriod_id));
    $chronologicals = App\Models\Chronological::where('chAcademicperiod_id', $period->apId)->get();
    $validateRepeatAchievement = '';
    $validateRepeatIntelligence = '';
    $infoIntelligence = array();
    $intelligences = App\Models\Intelligence::all();
    foreach ($intelligences as $intelligence) {

      $infoAchievement = array();
      $weeklytrackings = App\Models\Weeklytracking::select('wtId', 'wtIntelligence_id')
        // ->where('wtChronological_id',$chronological->chId)
        ->where('wtIntelligence_id', $intelligence->id)
        ->where('wtStudent_id', $student->id)
        ->get();
      $itemsPercentaje = 0;
      $totalPercentaje = 0;
      foreach ($weeklytrackings as $weeklytracking) {
        $trackingachievements = App\Models\Trackingachievement::where('taWeektracking_id', $weeklytracking->wtId)->get();
        foreach ($trackingachievements as $trackingachievement) {
          $achievement = App\Models\Achievement::find($trackingachievement->taAchievement_id);
          $findAchievement = strpos($validateRepeatAchievement, (string)$achievement->id);
          if ($findAchievement === false) {
            array_push($infoAchievement, $achievement->name);
            $validateRepeatAchievement .= $achievement->id . ',';
          }
        }
      }
      $findIntelligence = strpos($validateRepeatIntelligence, (string)$intelligence->id);
      // if($findIntelligence === false){
      // }
      if (count($weeklytrackings) > 0) {
        array_push($infoIntelligence, [$intelligence->type, $infoAchievement]);
        $validateRepeatIntelligence .= $intelligence->id . ',';
      } else {
        array_push($infoIntelligence, [$intelligence->type, 'No hay registros']);
      }
    }
    return response()->json($infoIntelligence);
  } else if ($request->typeRequest == 'REPORT PERIOD PDF') {
    $bulletin = App\Models\Bulletin::where('buStudent_id', trim($request->studentSelected))
      ->where('buPeriod_id', trim($request->periodSelected))
      ->first();
    $all = array();
    $itemsIntelligence = array();
    $student = App\Models\Student::find(trim($bulletin->buStudent_id));
    $course = App\Models\Course::find(trim($bulletin->buCourse_id));
    $period = App\Models\Academicperiod::find(trim($bulletin->buPeriod_id));
    $chronologicals = App\Models\Chronological::where('chAcademicperiod_id', $period->apId)->get();
    $validateRepeatAchievement = '';
    $intelligences = App\Models\Intelligence::all();
    foreach ($intelligences as $intelligence) {
      $weeklytrackings = App\Models\Weeklytracking::select('wtId', 'wtIntelligence_id')
        // ->where('wtChronological_id',$chronological->chId)
        ->where('wtIntelligence_id', $intelligence->id)
        ->where('wtStudent_id', $student->id)
        ->get();
      $itemsPercentaje = 0;
      $totalPercentaje = 0;
      foreach ($weeklytrackings as $weeklytracking) {
        $trackingachievements = App\Models\Trackingachievement::where('taWeektracking_id', $weeklytracking->wtId)->get();
        foreach ($trackingachievements as $trackingachievement) {
          $achievement = App\Models\Achievement::find($trackingachievement->taAchievement_id);
          $findAchievement = strpos($validateRepeatAchievement, (string)$achievement->id);
          if ($findAchievement === false) {
            $totalPercentaje += $trackingachievement->taPercentage;
            $itemsPercentaje++;
            $validateRepeatAchievement .= $achievement->id . ',';
          }
        }
      }
      if ($itemsPercentaje > 0) {
        $total = bcdiv(($totalPercentaje / $itemsPercentaje), '1', 1);
      } else {
        $total = 'N/A';
      }
      array_push($itemsIntelligence, [$intelligence->id, $intelligence->type, $total]);
    }
    return response()->json($itemsIntelligence);
  } else if ($request->typeRequest == 'CLOSE PERIOD') {
    $infoWeeks = App\Models\Chronological::select(
      'chronologicals.*',
      'intelligences.type',
      DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
    )
      ->join('intelligences', 'intelligences.id', 'chronologicals.chIntelligence_id')
      ->join('collaborators', 'collaborators.id', 'chronologicals.chCollaborator_id')
      ->where('chAcademicperiod_id', $request->periodSelected)
      ->get();
    return response()->json($infoWeeks);
  }
})->name('getWeekPeriodClosing');

//OBTENER LOS LOGROS DEL ESTUDIANTE EN EL PERIODO SELECCIONADO
Route::get('getAchievementAll', function (Request $request) {

  $trackings = App\Models\Weeklytracking::select(
    'weeklytrackings.*',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'students.numberdocument as documentStudent',
    'academicperiods.*',
    'baseactivitys.*',
    'achievements.name as nameAchievement',
    'courses.name As nameCourse',
    'courses.id As idCourse'
  )
    ->join('students', 'students.id', 'weeklytrackings.wtStudent_id')
    ->join('academicperiods', 'academicperiods.apId', 'weeklytrackings.wtPeriod_id')
    ->join('baseactivitys', 'baseactivitys.baId', 'weeklytrackings.wtBaseactivity_id')
    ->join('achievements', 'achievements.id', 'weeklytrackings.wtAchievement_id')
    ->join('courses', 'courses.id', 'weeklytrackings.wtCourse_id')
    ->where('wtPeriod_id', $request->apId)
    ->where('wtStudent_id', $request->stId)
    // ->distinct('weeklytrackings.wtAchievement_id')
    ->get();

  $intelligences = App\Models\Intelligence::all();
  $set = array();
  $weeklysRepeat = '';
  foreach ($intelligences as $intelligence) {
    $items = array();
    $countTest = 0;
    foreach ($trackings as $tracking) {
      $findRepeatWeek = strpos($weeklysRepeat, $tracking->wtId);
      if ($findRepeatWeek === false) {
        if ($tracking->wtIntelligence_id == $intelligence->id) {
          $getAchievementRepeatsCount = App\Models\Weeklytracking::where('wtPeriod_id', $tracking->wtPeriod_id)
            ->where('wtStudent_id', $tracking->wtStudent_id)
            ->where('wtAchievement_id', $tracking->wtAchievement_id)
            ->get()->count();
          if ($getAchievementRepeatsCount > 1) {
            $getAchievementRepeats = App\Models\Weeklytracking::where('wtPeriod_id', $request->apId)
              ->where('wtStudent_id', $request->stId)
              ->where('wtAchievement_id', $tracking->wtAchievement_id)
              ->get();
            $countBases = 0;
            $countWeeks = 0;
            $bases = '';
            $weeklys = '';
            $totalNotes = 0;
            foreach ($getAchievementRepeats as $itemAchievement) {
              $countBases++;
              $countWeeks++;
              $totalNotes += $itemAchievement->wtNote;
              $bases .= $itemAchievement->wtBaseactivity_id . ':';
              $weeklys .= $itemAchievement->wtId . ':';
            }
            $basesOk = substr($bases, 0, -1);
            $weeksOk = substr($weeklys, 0, -1);
            $averageAchievement = $totalNotes / $countBases;
            $statusNew = getStatusAchievement($averageAchievement);
            array_push($items, [
              $weeksOk,
              $countBases,
              $basesOk,
              $tracking->nameAchievement,
              $averageAchievement,
              $statusNew
            ]);
            $weeklysRepeat .= $weeksOk . ':';
          } else if ($getAchievementRepeatsCount == 1) {
            array_push($items, [
              $tracking->wtId,
              1,
              $tracking->baId,
              $tracking->nameAchievement,
              $tracking->wtNote,
              $tracking->wtStatus
            ]);
            $weeklysRepeat .= $tracking->wtId . ':';
          }
        }
      }
    }
    if (count($items) > 0) {
      array_push($set, [
        $intelligence->id,
        $intelligence->type,
        $items
      ]);
    }
  }
  return response()->json($set);
})->name('getAchievementAll');

// OBTENER LAS INTELIGENCIAS DEL PERIODO
Route::get('getIntelligenceFromArray', function (Request $request) {
  $intelligences = App\Models\Intelligence::whereIn('id', $request->ids)->get();
  return response()->json($intelligences);
})->name('getIntelligenceFromArray');

// OBTENER LAS OBSERVACIONES DE ACUERDO A LA INTELIGENCIA SELECCIONADA EN CIERRE DE PERIODO
Route::get('getObservationsFromIntelligence', function (Request $request) {
  $observations = App\Models\Observation::where('obsIntelligence_id', $request->idIntelligence)->get();
  return response()->json($observations);
})->name('getObservationsFromIntelligence');

// OBTENER LAS OBSERVACIONES DE ACUERDO AL PERIODO EN TABLA (trackingachievements) EN MODULO CIERRE DE PERIODO
Route::get('getObservationsFromPeriod', function (Request $request) {
  $observations = App\Models\Trackingachievement::where('taCourse_id', $request->idCourse)
    ->where('taPeriod_id', $request->idPeriod)
    ->where('taStudent_id', $request->idStudent)
    ->first();
  $observationsPeriod = array();
  if ($observations != null) {
    if ($observations->taObservations != null) {
      $separated = explode(':', $observations->taObservations);
      for ($i = 0; $i < count($separated); $i++) {
        $observationResult = App\Models\Observation::select('observations.*', 'intelligences.*')
          ->join('intelligences', 'intelligences.id', 'observations.obsIntelligence_id')
          ->where('obsId', $separated[$i])
          ->first();
        if ($observationResult != null) {
          array_push($observationsPeriod, [
            $observationResult->obsId,
            $observationResult->obsNumber,
            $observationResult->obsDescription,
            $observationResult->type
          ]);
        }
      }
    }
  }
  return response()->json($observationsPeriod);
})->name('getObservationsFromPeriod');

function getStatusAchievement($value)
{
  if ($value >= 0 && $value <= 25) {
    return 'PENDIENTE';
  } else if ($value >= 26 && $value <= 50) {
    return 'INICIADO';
  } else if ($value >= 51 && $value <= 75) {
    return 'EN PROCESO';
  } else if ($value >= 76 && $value <= 99) {
    return 'POR TERMINAR';
  } else if ($value >= 100) {
    return 'COMPLETADO';
  }
}

// OBTENER LOS LOGROS DE CADA SEMANA SELECCIONADA
Route::get('getAchievementFromWeek', function (Request $request) {
  $infoAchievements = App\Models\Weeklytracking::select(
    'trackingachievements.*',
    'students.id as idStudent',
    'achievements.name as nameAchievement'
  )
    ->join('trackingachievements', 'trackingachievements.taWeektracking_id', 'weeklytrackings.wtId')
    ->join('students', 'students.id', 'weeklytrackings.wtStudent_id')
    ->join('achievements', 'achievements.id', 'trackingachievements.taAchievement_id')
    ->where('wtChronological_id', $request->chId)
    ->where('wtStudent_id', $request->selectedStudent)
    ->get();
  return response()->json($infoAchievements);
})->name('getAchievementFromWeek');

//OBTENER LA DESCRIPCION DE CADA OBSERVACION SELECCIONADA
Route::get('getDescriptionObservation', function (Request $request) {
  $description = App\Models\Observation::select('obsDescription')->where('obsId', $request->selectedObservation)->first();
  return response()->json($description);
})->name('getDescriptionObservation');

// OBTENER LAS OBSERVACIONES DE ACUERDO AL PERIODO EN TABLA (trackingachievements) EN MODULO CIERRE DE PERIODO
Route::get('getObservationsBulletin', function (Request $request) {
  $observations = App\Models\Trackingachievement::where('taCourse_id', $request->courseSelected)
    ->where('taPeriod_id', $request->periodSelected)
    ->where('taStudent_id', $request->studentSelected)
    ->first();
  $observationsPeriod = array();

  if ($observations != null) {
    if (strlen($observations->taObservations) > 0) {
      $allObservations = substr(trim($observations->taObservations), 0, -1);
      $idsObservations = explode(':', $allObservations);
      $intelligences = App\Models\Intelligence::all();
      foreach ($intelligences as $intelligence) {
        $items = array();

        for ($i = 0; $i < count($idsObservations); $i++) {
          $getObservationsFromIntelligence = App\Models\Observation::select('intelligences.*', 'observations.*')
            ->join('intelligences', 'intelligences.id', 'observations.obsIntelligence_id')
            ->where('obsIntelligence_id', $intelligence->id)
            ->where('obsId', $idsObservations[$i])
            ->first();
          if ($getObservationsFromIntelligence != null) {
            array_push($items, [
              $getObservationsFromIntelligence->obsNumber,
              $getObservationsFromIntelligence->obsDescription
            ]);
          }
        }
        if (count($items) > 0) {
          array_push($observationsPeriod, [
            $intelligence->id,
            $intelligence->type,
            $items
          ]);
        } else {
          array_push($observationsPeriod, [
            $intelligence->id,
            $intelligence->type,
            'N/A'
          ]);
        }
      }
    } else {
      $observationsPeriod = 'N/A';
    }
  } else {
    $observationsPeriod = 'N/A';
  }
  return response()->json($observationsPeriod);
})->name('getObservationsBulletin');

//GUARDAR CAMBIOS DE LOGROS DE FORMA INDIVIDUAL
Route::post('saveOneAchievement', function (Request $request) {
  $trackingachievement = App\Models\Trackingachievement::find(trim($request->taId));
  $ids = substr(trim($request->taIds), 0, -1); // QUITAR ULTIMO CARACTER QUE ES (:)
  $separatedTaids = explode(':', $ids);
  $allTrackings = App\Models\Trackingachievement::whereIn('taId', $separatedTaids)->where('taAchievement_id', $trackingachievement->taAchievement_id)->get();
  foreach ($allTrackings as $tracking) {
    $tracking->taPercentage = trim($request->range);
    $tracking->taStatus = trim($request->status);
    $tracking->save();
  }
})->name('saveOneAchievement');

//VALIDAR SI ALGUN BOLETIN YA EXISTENTE DEL ALUMNO, CURSO Y PERIODO SELECCIONADO
Route::get('getBulletins', function (Request $request) {
  $bulletinValidate = App\Models\Bulletin::where('buStudent_id', trim($request->idStudent))
    ->where('buCourse_id', trim($request->idCourse))
    ->where('buPeriod_id', trim($request->idPeriod))
    ->first();
  if ($bulletinValidate == null) {
    return response()->json(false);
  } else {
    $dates = array([
      true,
      $bulletinValidate->buId
    ]);
    return response()->json($dates);
  }
})->name('getBulletins');

//CONSULTAR INFORMACION BASICA DEL ALUMNO SELECCIONADO PARA DESCARGA DE BOLETIN
Route::get('getInfoStudentNewLetter', function (Request $request) {
  $infoStudentNewLetter = App\Models\Bulletin::select(
    'students.numberdocument',
    'academicperiods.apId',
    'academicperiods.apNameperiod',
    'courses.id as idCourse',
    'courses.name as nameCourse'
  )
    ->join('students', 'students.id', 'bulletins.buStudent_id')
    ->join('academicperiods', 'academicperiods.apId', 'bulletins.buPeriod_id')
    ->join('courses', 'courses.id', 'bulletins.buCourse_id')
    ->where('buStudent_id', trim($request->studentSelected))
    ->get();
  return response()->json($infoStudentNewLetter);
})->name('getInfoStudentNewLetter');

//CONSULTAR TODOS LOS ESTUDIANTES DE UN CURSOS SELECCIONADO EN LA VISTA ==> CONTROL DE ASISTENCIA
Route::get('getStudentFromCourse', function (Request $request) {
  $students = App\Models\Listcourse::select(
    'students.id',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listCourse_id', trim($request->courseSelected))
    ->get();
  return response()->json($students);
})->name('getStudentFromCourse');

//CONSULTAR TODOS LOS ESTUDIANTES DE UN CURSOS SELECCIONADO EN LA VISTA ==> CONTROL DE ASISTENCIA
Route::get('getPeriodsOfCourse', function (Request $request) {
  $periods = App\Models\Academicperiod::where('apCourse_id', trim($request->courseSelected))->where('apStatus', 'ACTIVO')->get();
  return response()->json($periods);
})->name('getPeriodsOfCourse');

//CONSULTAR LA JORNADA DE UN ESTUDIANTE SELECCIONADO EN LA VISTA ==> CONTROL DE ASISTENCIA
Route::get('getJourneyFromStudent', function (Request $request) {
  $journey = App\Models\Legalization::select('journeys.*', 'legDateInitial', 'legDateFinal')
    ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
    ->where('legStudent_id', trim($request->studentSelected))
    ->first();
  return response()->json($journey);
})->name('getJourneyFromStudent');

//CONSULTAR EL VALOR DE LA JORNADA QUE SE LLAME DIA ADICIONAL, PARA REALIZAR COBRO EN LISTADO DE ASISTENCIAS
Route::get('getJourneyDayAdditional', function (Request $request) {
  $journey = App\Models\Journey::select('jouValue')->where('jouJourney', 'DIA ADICIONAL')->orWhere('jouJourney', 'Dia adicional')->first();
  return response()->json($journey);
})->name('getJourneyDayAdditional');

//CONSULTAR EL VALOR DE LA JORNADA QUE SE LLAME DIA ADICIONAL, PARA REALIZAR COBRO EN LISTADO DE ASISTENCIAS
Route::get('getValueMinutesAdditional', function (Request $request) {
  $valueMinute = App\Models\Journey::select('jouValue')->where('jouJourney', 'MINUTO ADICIONAL')->orWhere('jouJourney', 'Minuto adicional')->first();
  return response()->json($valueMinute);
})->name('getValueMinutesAdditional');

//CONSULTAR TODOS LOS ESTUDIANTES QUE HACEN FALTA POR INDICAR ASISTENCIA EN LA VISTA ==> CONTROL DE ASISTENCIA
Route::get('getValidateAssistance', function (Request $request) {
  // $otherstudents = App\Models\Legalization::select(
  // 				'students.id',
  // 				DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
  // 				'students.numberdocument',
  // 				'students.yearsold',
  // 				'journeys.jouDays'
  // 			)
  // 			->join('students','students.id','legalizations.legStudent_id')
  // 			->join('journeys','journeys.id','legalizations.legJourney_id')
  // 			->whereNotIn('legStudent_id',$request->students)
  //			->where('legCourse_id',$request->course)
  // 			->get();
  $otherstudents = App\Models\Listcourse::select(
    'listcourses.listStudent_id',
    'students.id',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'students.numberdocument',
    'students.yearsold'
    // 'journeys.jouDays'
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    // ->join('legalizations','legalizations.legId','students.id')
    // ->join('journeys','journeys.id','legalizations.legJourney_id')
    ->where('listCourse_id', $request->course)
    ->whereNotIn('listStudent_id', $request->students)
    ->get();
  $validated = array();
  foreach ($otherstudents as $other) {
    $student = App\Models\Legalization::select('journeys.jouDays')->join('journeys', 'journeys.id', 'legalizations.legJourney_id')->where('legStudent_id', $other->listStudent_id)->first();

    $find = strpos($student->jouDays, getStringDay($request->day));
    if ($find !== false) {
      array_push($validated, [
        $other->id,
        $other->nameStudent,
        $other->numberdocument,
        $other->yearsold
      ]);
    }
  }
  // dd($validated);
  return response()->json($validated);
})->name('getValidateAssistance');

function getStringDay($value)
{
  switch ($value) {
    case '0':
      return 'DOMINGO';
    case '1':
      return 'LUNES';
    case '2':
      return 'MARTES';
    case '3':
      return 'MIERCOLES';
    case '4':
      return 'JUEVES';
    case '5':
      return 'VIERNES';
    case '6':
      return 'SABADO';
  }
}

//CONSULTAR EL ACUDIENTE DE ACUERDO AL ESTUDIANTE SELECCIONADO EN LA VISTA ==> CONTROL DE ADICIONALES
Route::get('getAttendantAdditional', function (Request $request) {
  $attendant = App\Models\Legalization::select(
    'attendants.id AS idAttendant',
    DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant")
  )
    ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
    ->where('legStudent_id', $request->studentSelected)
    ->first();
  if ($attendant == null) {
    $attendant = App\Models\Legalization::select(
      'attendants.id AS idAttendant',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant")
    )
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantmother_id')
      ->where('legStudent_id', $request->studentSelected)
      ->first();
  }
  return response()->json($attendant);
})->name('getAttendantAdditional');


//CONSILTAR EL DATOS DE CONTRATO DE ACUERDO AL ESTUDIANTE SELECCIONADO EN LA VISTA ==> FACTURACIONES
Route::get('getDatesFacturation', function (Request $request) {
  $legalizations = App\Models\Legalization::select(
    'attendants.id AS idAttendant',
    DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
    'grades.name as nameGrade',
    'grades.id as idGrade',
    'courses.name as nameCourse',
    'courses.id as idCourse',
    'legalizations.*'
  )
    ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
    // ->join('attendants','attendants.id','legalizations.legAttendantmother_id')
    ->join('grades', 'grades.id', 'legalizations.legGrade_id')
    ->join('courses', 'courses.id', 'legalizations.legCourse_id')
    ->where('legStudent_id', $request->studentSelected)
    ->first();
  if ($legalizations == null) {
    $legalizations = App\Models\Legalization::select(
      'attendants.id AS idAttendant',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
      'grades.name as nameGrade',
      'grades.id as idGrade',
      'courses.name as nameCourse',
      'courses.id as idCourse',
      'legalizations.*'
    )
      // ->join('attendants','attendants.id','legalizations.legAttendantfather_id')
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantmother_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      ->join('courses', 'courses.id', 'legalizations.legCourse_id')
      ->where('legStudent_id', $request->studentSelected)
      ->first();
  }
  return response()->json($legalizations);
})->name('getDatesFacturation');

//CONSILTAR LAS FECHAS DE LAS AUTORIZACIONES ADICIONALES DE ACUERDO AL ESTUDIANTE SELECCIONADO EN LA VISTA ==> FACTURACIONES
Route::get('getDatesAutorization', function (Request $request) {
  $autorizations = App\Models\Autorization::select(
    'autorizations.auId',
    'autorizations.auDate'
  )
    ->where('auStudent_id', $request->idStudent)
    ->where('auCourse_id', $request->idCourse)
    ->where('auAttendant_id', $request->idAttendant)
    ->get();
  return response()->json($autorizations);
})->name('getDatesAutorization');

//CONSULTAR LOS SERVICIOS ADICIONALES DE LAS AUTORIZACIONES ADICIONALES DE ACUERDO A LA FECHA SELECCIONADA EN LA VISTA ==> FACTURACIONES
Route::get('getAutorized', function (Request $request) {
  $autorizations = App\Models\Autorization::select(
    'autorizations.auId',
    'autorizations.auDate',
    'autorizations.auDescription',
    'autorizations.auAutorized'
  )->where('auId', $request->idAutorized)->first();
  $separatedAdditional = explode('-', $autorizations->auAutorized);
  $datesAdditional = array();
  for ($i = 0; $i < count($separatedAdditional); $i++) {
    $separatedId = explode(':', $separatedAdditional[$i]);
    switch ($separatedId[0]) {
      case 'JORNADA':
        $service = App\Models\Journey::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'JORNADA',
            $service->id,
            $service->jouJourney,
            $service->jouDays,
            $service->jouHourEntry,
            $service->jouHourExit,
            $service->jouValue
          ]);
        }
        break;
      case 'ALIMENTACION':
        $service = App\Models\Feeding::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'ALIMENTACION',
            $service->id,
            $service->feeConcept,
            $service->feeValue
          ]);
        }
        break;
      case 'UNIFORME':
        $service = App\Models\Uniform::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'UNIFORME',
            $service->id,
            $service->uniConcept,
            $service->uniValue
          ]);
        }
        break;
      case 'MATERIAL':
        $service = App\Models\Supplie::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'MATERIAL',
            $service->id,
            $service->supConcept,
            $service->supValue
          ]);
        }
        break;
      case 'TIEMPO EXTRA':
        $service = App\Models\Extratime::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'TIEMPO EXTRA',
            $service->id,
            $service->extTConcept,
            $service->extTValue
          ]);
        }
        break;
      case 'EXTRACURRICULAR':
        $service = App\Models\Extracurricular::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'EXTRACURRICULAR',
            $service->id,
            $service->extConcept,
            $service->extIntensity,
            $service->extValue
          ]);
        }
        break;
      case 'TRANSPORTE':
        $service = App\Models\Transport::find($separatedId[1]);
        if ($service != null) {
          array_push($datesAdditional, [
            'TRANSPORTE',
            $service->id,
            $service->traConcept,
            $service->traValue
          ]);
        }
        break;
    }
  }
  array_push($datesAdditional, [
    $autorizations->auId,
    $autorizations->auDate,
    $autorizations->auDescription,
    $autorizations->auAutorized
  ]);
  //dd($datesAdditional);
  return response()->json($datesAdditional);
})->name('getAutorized');

//VALIDAR CODIGO GENERADO CON EL RAMDOM PARA GUARDAR FACTURA
Route::get('validateCodeFacturation', function (Request $request) {
  $validateCode = App\Models\Facturation::where('facCode', $request->code)->first();
  if ($validateCode == null) {
    return response()->json($request->code);
  } else {
    return response()->json(false);
  }
})->name('validateCodeFacturation');

//CONSULTAR NUMERO DE COMPROBANTES DE INGRESO Y RETORNAR EL SIGUIENTE NUMERO 
Route::get('getNumberVoucherEntry', function (Request $request) {
  $voucherInitial = App\Models\Numeration::select('niVoucherentry')->first();

  $validatedNumber = App\Models\Entry::where('venCode', $voucherInitial->niVoucherentry)->first();
  if ($validatedNumber != null) {
    $validateMax =  App\Models\Entry::select('venCode')->max('venCode');
    $numbernext = $validateMax + 1;
  } else {
    $numbernext = $voucherInitial->niVoucherentry;
  }
  return response()->json($numbernext);
})->name('getNumberVoucherEntry');

//CONSULTAR NUMERO DE COMPROBANTES DE INGRESO Y RETORNAR EL SIGUIENTE NUMERO
Route::get('getNumberVoucherEgress', function (Request $request) {
  $voucherInitial = App\Models\Numeration::select('niVoucheregress')->first();
  $validatedNumber = App\Models\Egress::where('vegCode', $voucherInitial->niVoucheregress)->first();
  if ($validatedNumber != null) {
    $validateMax =  App\Models\Egress::select('vegCode')->max('vegCode');
    $numbernext = $validateMax + 1;
  } else {
    $numbernext = $voucherInitial->niVoucheregress;
  }
  return response()->json($numbernext);
})->name('getNumberVoucherEgress');

//CONSULTAR LAS FACTURAS DEL ESTUDIANTE SELECCIONADO EN EL MODAL DE LA VISTA ==> NUEVO COMPROBANTE DE INGRESO
Route::get('getFactures', function (Request $request) {
  $factures = App\Models\Facturation::select(
    'facturations.*',
    'legalizations.legStudent_id as idStudent'
  )
    ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
    ->where('facLegalization_id', $request->selected)->where('facStatus', 'APROBADA')->get();
  return response()->json($factures);
})->name('getFactures');

//CONSULTAR SALDO EN CARTERA DEL ESTUDIANTE SELECCIONADO EN EL MODAL DE LA VISTA ==> NUEVO COMPROBANTE DE INGRESO
Route::get('getWallet', function (Request $request) {
  $wallet = App\Models\Wallet::where('waStudent_id', $request->student)->first();
  return response()->json($wallet);
})->name('getWallet');

//CONSULTAR DATOS  DE LA FACTURA SELECCIONADA EN EL MODAL DE LA VISTA ==> NUEVO COMPROBANTE DE INGRESO
Route::get('getDatesFacture', function (Request $request) {
  $facture = App\Models\Facturation::find($request->selected);
  $entrys = App\Models\Entry::where('venFacturation_id', $facture->facId)->get();
  $dates = array();
  $paid = 0;
  $count = 0;
  if ($entrys != null) {
    foreach ($entrys as $entry) {
      $paid += $entry->venPaid;
      $count++;
    }
    array_push($dates, [
      $facture->facId,
      $facture->facCode,
      $facture->facInformation,
      $facture->facDateInitial,
      $facture->facDateFinal,
      $facture->facAutorized,
      $facture->facValue,
      $facture->facLegalization_id,
      $facture->facAutorization_id,
      $facture->facStatus
    ]);
    array_push($dates, [
      $count, $paid
    ]);
    return response()->json($dates);
  } else {
    array_push($dates, [
      $facture->facId,
      $facture->facCode,
      $facture->facInformation,
      $facture->facDateInitial,
      $facture->facDateFinal,
      $facture->facAutorized,
      $facture->facValue,
      $facture->facLegalization_id,
      $facture->facAutorization_id,
      $facture->facStatus
    ]);
    return response()->json($dates);
  }
})->name('getDatesFacture');

//CONSULTAR DATOS  DEL PROVEDOR SELECCIONADO EN EL MODAL DE LA VISTA ==> NUEVO COMPROBANTE DE EGRESO
Route::get('getProvider', function (Request $request) {
  $provider = App\Models\Provider::select(
    'providers.*',
    'documents.type as typeDocument',
    'citys.name as nameCity'
  )
    ->join('documents', 'documents.id', 'providers.typedocument_id')
    ->join('citys', 'citys.id', 'providers.cityhome_id')
    ->where('providers.id', $request->selected)
    ->first();
  return response()->json($provider);
})->name('getProvider');

//CONSULTAR ID DE ESTUDIANTE DEL SELECCIONADO POR LEGALIZACION EN VISTA ==> NUEVO COMPROBANTE DE INGRESO
Route::get('getStudentSelected', function (Request $request) {
  $idStudent = App\Models\Legalization::select('legStudent_id as idStudent')->where('legId', $request->selectedLegalization)->first();
  //dd($idStudent);
  return response()->json($idStudent);
})->name('getStudentSelected');



//CONSULTAR LAS LOCALIDADES DE UNA CIUDAD PARA CREAR DATOS DEL JARDIN EN LA VISTA ==> GESTION DE ACCESO (MODAL)
Route::get('getLocationsGarden', function (Request $request) {
  $locations = App\Models\Location::where('city_id', $request->city)->get();
  return response()->json($locations);
})->name('getLocationsGarden');

//CONSULTAR LOS BARRIOS DE UNA LOCALIDAD SELECCIONADA PARA CREAR DATOS DEL JARDIN EN LA VISTA ==> GESTION DE ACCESO (MODAL)
Route::get('getDistrictsGarden', function (Request $request) {
  $districts = App\Models\District::where('location_id', $request->location)->get();
  return response()->json($districts);
})->name('getDistrictsGarden');

//CONSULTA DE JARDIN
Route::get('getGarden', function () {
  $garden = App\Models\Garden::select(
    'garden.*',
    'citys.name AS garNameCity',
    'locations.name AS garNameLocation',
    'districts.name AS garNameDistrict'
  )
    ->join('citys', 'citys.id', 'garden.garCity_id')
    ->join('locations', 'locations.id', 'garden.garLocation_id')
    ->join('districts', 'districts.id', 'garden.garDistrict_id')
    ->first();
  return response()->json($garden);
})->name('getGarden');

//CONSULTA DE LA INFORMACION DE PAGO EN LA VISTA DE FACTURACION ==> MODULO DE FACTURACION
Route::get('getInformationPaid', function (Request $request) {
  $pay = App\Models\Pay::where('payLegalization_id', $request->numberLegalization)->first();
  return response()->json($pay);
})->name('getInformationPaid');

//CONSULTA DE LA INFORMACION DE PAGO EN LA VISTA DE CONTRATO PARA PDF
Route::get('getPaid', function (Request $request) {
  $pay = App\Models\Pay::where('payLegalization_id', $request->legId)->first();
  return response()->json($pay);
})->name('getPaid');

//CONSULTA DE LA INFORMACION DE CITA DEL CLIENTE SELECCIONADO EN LA TABLA DE AGENDAMIENTO (PARA MOSTRAR EN VENTANA MODAL)
Route::get('getSchedulingForChange', function (Request $request) {
  $scheduling = App\Models\Scheduling::where('schCustomer_id', $request->cusId)
    ->where('schStatusVisit', 'ACTIVO')
    ->where('schResultVisit', 'PENDIENTE')
    ->first();
  return response()->json($scheduling);
})->name('getSchedulingForChange');

//CONSULTA DEL HISTORIAL DE VISITAS (PARA MOSTRAR EN VENTANA MODAL) EN LA VISTA REGISTROS
Route::get('getHistoryVisits', function (Request $request) {
  $history = App\Models\Scheduling::where('schCustomer_id', $request->cusId)->get();
  return response()->json($history);
})->name('getHistoryVisits');

//CONSULTA DEL HISTORIAL DE BITACORA (PARA MOSTRAR EN VENTANA MODAL) EN LA VISTA DE SEGUIMIENTO
Route::get('getHistoryBinnacle', function (Request $request) {
  $history = App\Models\Binnacle::where('binProposal_id', $request->proposalId)->get();
  return response()->json($history);
})->name('getHistoryBinnacle');


//CONSULTA DE CONCILIACION DE SALDOS POR AÑO Y MES SELECCIONADO
Route::get('getBalances', function (Request $request) {
  // VALIDAR DIAS DEL MES SELECCIONADO
  $daysMountnow = Date('t', strtotime($request->year . '-' . $request->mount . '-01'));
  //COLLECCION DE COMPROBANTES DE INGRESO DEL MES SELECCIONADO
  $balancesEntrynow = App\Models\Entry::whereBetween('venDate', [$request->year . '-' . $request->mount . '-01', $request->year . '-' . $request->mount . '-' . $daysMountnow])->get();
  //COLLECCION DE COMPROBANTES DE EGRESO DEL MES SELECCIONADO
  $balancesEgressnow = App\Models\Egress::whereBetween('vegDate', [$request->year . '-' . $request->mount . '-01', $request->year . '-' . $request->mount . '-' . $daysMountnow])->get();

  // if($request->mount == '01'){
  // 	$daysMountprevious = Date('t',strtotime(($request->year - 1) . '-12-01' ));
  // 	$balancesEntryprevious = App\Models\Entry::whereBetween('venDate',[($request->year - 1) . '-12-01', ($request->year - 1) . '-12-' . $daysMountprevious])->get();
  // 	$balancesEgressprevious = App\Models\Egress::whereBetween('vegDate',[($request->year - 1) . '-12-01', ($request->year - 1) . '-12-' . $daysMountprevious])->get();
  // }else{
  // 	$daysMountprevious = Date('t',strtotime($request->year . '-' . ($request->mount - 1) . '-01' ));
  // 	$balancesEntryprevious = App\Models\Entry::whereBetween('venDate',[$request->year . '-' . ($request->mount - 1) . '-01', $request->year . '-' . ($request->mount - 1) . '-' . $daysMountprevious])->get();
  // 	$balancesEgressprevious = App\Models\Egress::whereBetween('vegDate',[$request->year . '-' . ($request->mount - 1) . '-01', $request->year . '-' . ($request->mount - 1) . '-' . $daysMountprevious])->get();
  // }

  //COLLECCION DE COMPROBANTES DE INGRESO ANTERIORES AL MES SELECCIONADO
  $balancesEntryprevious = App\Models\Entry::whereNotBetween('venDate', [$request->year . '-' . $request->mount . '-01', $request->year . '-' . $request->mount . '-' . $daysMountnow])->where('venDate', '<', $request->year . '-' . $request->mount . '-01')->get();
  //COLLECCION DE COMPROBANTES DE EGRESO ANTERIORES AL MES SELECCIONADO
  $balancesEgressprevious = App\Models\Egress::whereNotBetween('vegDate', [$request->year . '-' . $request->mount . '-01', $request->year . '-' . $request->mount . '-' . $daysMountnow])->where('vegDate', '<', $request->year . '-' . $request->mount . '-01')->get();

  $totalEntrynow = 0;
  $totalEgressnow = 0;
  $valueIvaEgressnow = 0;
  $valueRetentionEgressnow = 0;
  foreach ($balancesEntrynow as $entry) {
    $totalEntrynow += $entry->venPaid;
  }
  foreach ($balancesEgressnow as $egress) {
    $totalEgressnow += $egress->vegPay;
    $valueIvaEgressnow += $egress->vegValueiva;
    $valueRetentionEgressnow += $egress->vegValueretention;
  }
  $totalEntryprevious = 0;
  $totalEgressprevious = 0;
  foreach ($balancesEntryprevious as $entry) {
    $totalEntryprevious += $entry->venPaid;
  }
  foreach ($balancesEgressprevious as $egress) {
    $totalEgressprevious += $egress->vegPay;
  }
  $balancenow = $totalEntrynow - $totalEgressnow;
  $allBalance = array();
  array_push($allBalance, $totalEntrynow);
  array_push($allBalance, $totalEgressnow);
  array_push($allBalance, $balancenow);
  $balanceprevious = $totalEntryprevious - $totalEgressprevious;
  array_push($allBalance, $balanceprevious);
  $balanceAvailable = $balancenow + $balanceprevious;
  array_push($allBalance, $balanceAvailable);
  array_push($allBalance, $valueIvaEgressnow);
  array_push($allBalance, $valueRetentionEgressnow);
  return response()->json($allBalance);
})->name('getBalances');

//CONSULTA DE DETALLES DE COMPROBANTE DE INGRESO PARA MOSTRAR EN VENTANA MODAL
Route::get('getDetailsVoucherEntry', function (Request $request) {
  $details = array();
  $voucher = App\Models\Entry::select(
    'voucherentrys.*',
    'facturations.*',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'students.yearsold',
    'students.numberdocument',
    'documents.type as typeDocument',
    'legalizations.*',
    'grades.name as nameGrade'
  )
    ->join('facturations', 'facturations.facId', 'voucherentrys.venFacturation_id')
    ->join('students', 'students.id', 'voucherentrys.venStudent_id')
    ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
    ->join('grades', 'grades.id', 'legalizations.legGrade_id')
    ->join('documents', 'documents.id', 'students.typedocument_id')
    ->where('voucherentrys.venId', $request->venId)
    ->first();

  $father = App\Models\Attendant::select(
    'attendants.*',
    'documents.type'
  )->join('documents', 'documents.id', 'attendants.typedocument_id')
    ->where('attendants.id', $voucher->legAttendantfather_id)->first();
  $mother = App\Models\Attendant::select(
    'attendants.*',
    'documents.type'
  )->join('documents', 'documents.id', 'attendants.typedocument_id')
    ->where('attendants.id', $voucher->legAttendantmother_id)->first();

  array_push($details, [
    'INFORMACION',
    $voucher->nameStudent,
    $voucher->typeDocument . ': ' . $voucher->numberdocument,
    $voucher->yearsold,
    $voucher->nameGrade,
    $father->firstname . ' ' . $father->threename,
    $father->type . ': ' . $father->numberdocument,
    $father->phoneone,
    $father->emailone,
    $mother->firstname . ' ' . $mother->threename,
    $mother->type . ': ' . $mother->numberdocument,
    $mother->phoneone,
    $mother->emailone,
    $voucher->legDateInitial,
    $voucher->legDateFinal,
    $voucher->venCode,
    $voucher->venDate,
    $voucher->venDescription,
    $voucher->facCode,
    $voucher->facPorcentageIva,
    $voucher->facDateInitial,
    $voucher->facDateFinal,
    $voucher->facValue,
    $voucher->facValueIva,
  ]);
  $concepts = explode(':', $voucher->facConcepts);
  for ($i = 0; $i < count($concepts); $i++) {
    $concept = App\Models\Concept::find($concepts[$i]);
    $iva = getIva($concept->conValue, $voucher->facPorcentageIva);
    array_push($details, [
      'CONCEPTO',
      $concept->conConcept,
      $concept->conValue,
      $iva,
    ]);
  }
  return response()->json($details);
})->name('getDetailsVoucherEntry');

function getIva($value, $porcentage)
{
  $iva = ($value * $porcentage) / 100;
  return $iva;
}

//CONSULTA DEL HISTORIAL DE BITACORA (PARA MOSTRAR EN VENTANA MODAL) EN LA VISTA DE SEGUIMIENTO
Route::get('accounts.report', function (Request $request) {
  $datenow = Date('Y-m-d');
  $year = Date('Y', strtotime($datenow . ' + 5 year'));
  $accounts = App\Models\Concept::where('conStatus', 'PENDIENTE')
    ->whereBetween('conDate', [$datenow, $year . '-' . Date('m-d')])
    ->where('conLegalization_id', trim($request->legalization))->get();
  return response()->json($accounts);
})->name('accounts.report');

//CONSULTA DE ESTUDIANTES DEL GRADO SELECCIONADO EN LA LISTA DE CAMBIOS DE ESTUDIANTES ENTRE CURSOS

// ESTRUCTURA ESCOLAR >> GRADOS Y CURSOS >> LISTADOS >> VENTANA MODAL DE CAMBIAR ALUMNOS
Route::get('getStudentGrade', function (Request $request) {
  $students = App\Models\Listcourse::select(
    'listcourses.*',
    'students.id as idStudent',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listGrade_id', $request->selectedGrade)
    ->where('listCourse_id', null)
    ->get();
  return response()->json($students);
})->name('getStudentGrade');

// ESTRUCTURA ESCOLAR >> GRADOS Y CURSOS >> LISTADOS >> VENTANA MODAL DE CAMBIAR ALUMNOS
Route::get('getStudentCourse', function (Request $request) {
  $students = App\Models\Listcourse::select(
    'listcourses.*',
    'students.id as idStudent',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listGrade_id', $request->selectedGrade)
    ->where('listCourse_id', $request->selectedCourse)
    ->get();
  return response()->json($students);
})->name('getStudentCourse');

// EVENTO PARA AGREGAR LOS ESTUDIANTES DENTRO DE UN CURSO
Route::post('saveChangeStudents', function (Request $request) {
  $ids = explode('=', $request->idsSelected);
  $count = 0;
  $errorStudent = '';
  for ($i = 0; $i < count($ids); $i++) {
    $student = App\Models\Listcourse::where('listGrade_id', $request->selectedGrade)
      ->where('listCourse_id', null)
      ->where('listStudent_id', $ids[$i])->first();
    if ($student != null) {
      $student->listCourse_id = $request->selectedCourse;
      $student->save();
      $count++;
    } else {
      $errorStudent .= $ids[$i] . '=/=';
    }
  }
  // $course = App\Models\Course::find($request->selectedCourse);
  if (strlen($errorStudent) > 0) {
    return response()->json('Se han agregado ' . $count . ' alumnos, de ' . count($ids) . ' seleccionados');
  } else {
    return response()->json('Se han agregado ' . $count . ' alumnos');
  }
})->name('saveChangeStudents');

// EVENTO PARA ELIMINAR LOS ESTUDIANTES DENTRO DE UN CURSO
Route::post('saveChangeRemove', function (Request $request) {
  $ids = explode('=', $request->idsSelected);
  $count = 0;
  $errorStudent = '';
  for ($i = 0; $i < count($ids); $i++) {
    $student = App\Models\Listcourse::where('listGrade_id', $request->selectedGrade)
      ->where('listCourse_id', $request->selectedCourse)
      ->where('listStudent_id', $ids[$i])->first();
    if ($student != null) {
      $student->listCourse_id = null;
      $student->save();
      $count++;
    } else {
      $errorStudent .= $ids[$i] . '=/=';
    }
  }
  $course = App\Models\Course::find($request->selectedCourse);
  if (strlen($errorStudent) > 0) {
    return response()->json('Se han removido ' . $count . ' alumnos del curso ' . $course->name . ' de ' . count($ids) . ' seleccionados');
  } else {
    return response()->json('Se han removido ' . $count . ' alumnos del curso ' . $course->name);
  }
})->name('saveChangeRemove');





// DATOS DE ASISTENCIA PARA EDITAR LAS SALIDAS DE ASISTENCIA
Route::get('getAssistancesForedit', function (Request $request) {
  $assistance = App\Models\Assistance::find($request->assId);
  $separatedPresent = explode('%', $assistance->assPresents);
  $response = array();
  for ($i = 0; $i < count($separatedPresent); $i++) {
    $separatedDatesPresent = explode('/', $separatedPresent[$i]);
    $legalization = App\Models\Legalization::select(
      'students.id as idStudent',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'journeys.jouHourEntry as hourEntry',
      'journeys.jouHourExit as hourExit'
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
      ->where('legStudent_id', $separatedDatesPresent[0])
      ->first();
    if ($legalization != null) {
      array_push($response, [
        'PRESENTE',
        $legalization->idStudent,
        $legalization->nameStudent,
        $separatedDatesPresent[1] . ' ==> ' . $separatedDatesPresent[3],
        $legalization->hourEntry,
        $legalization->hourExit,
        $separatedDatesPresent[5] // Temperatura de llegada
      ]);
    }
  }

  $separatedAbsent = explode('-', $assistance->assAbsents);
  for ($i = 0; $i < count($separatedAbsent); $i++) {
    $findStudent = strpos($separatedAbsent[$i], 'A');
    if (!$findStudent) {
      $legalization = App\Models\Legalization::select(
        'students.id as idStudent',
        'students.numberdocument',
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'journeys.jouHourEntry as hourEntry',
        'journeys.jouHourExit as hourExit'
      )
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
        ->where('legStudent_id', $separatedAbsent[$i])
        ->first();
      if ($legalization != null) {
        array_push($response, [
          'AUSENTE',
          $legalization->idStudent,
          $legalization->nameStudent,
          $legalization->numberdocument,
          $legalization->hourEntry,
          $legalization->hourExit
        ]);
      }
    } else {
      $idStudent = substr($separatedAbsent[$i], 0, -1); // SE LE QUITA LA A (ULTIMO CARACTER)
      $legalization = App\Models\Legalization::select(
        'students.id as idStudent',
        'students.numberdocument',
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'journeys.jouHourEntry as hourEntry',
        'journeys.jouHourExit as hourExit'
      )
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->join('journeys', 'journeys.id', 'legalizations.legJourney_id')
        ->where('legStudent_id', $idStudent)
        ->first();
      if ($legalization != null) {
        array_push($response, [
          'AUSENTE',
          $legalization->idStudent,
          $legalization->nameStudent,
          $legalization->numberdocument,
          $legalization->hourEntry,
          $legalization->hourExit,
          'ADICIONAL'
        ]);
      }
    }
  }
  array_push($response, [
    'FECHA',
    $assistance->assDate
  ]);
  return response()->json($response);
})->name('getAssistancesForedit');

// DATOS DE REPORTE DE INFORMES DIARIOS (LOGISTICO >> NOVEDADES DIARIAS >> INFORME DIARIO)
Route::get('getReportDaily', function (Request $request) {
  $date = Date('Y-m-d', strtotime($request->dateSelected));

  $dates = Carbon::create($request->dateSelected)->locale('es')->isoFormat('LL');
  $day = Carbon::create($request->dateSelected)->locale('es')->dayName;
  $dateSearch = ucfirst($day) . " " . $dates;

  $assistances = App\Models\Presence::with('student:id,firstname,threename,fourname', 'course:id,name')->where('pre_date', $dateSearch)->get();

  $consolidated = array();

  // SE RECORRE LA INFORMACION RECOLECTADA POR ASISTENCES
  $datesPresents = array();
  $courses = Course::all();

  foreach ($courses as $key => $course) {
    $countPresent = 0;
    $countAbsent  = 0;
    $countStatus = 0;
    foreach ($assistances as $key => $assistance) {
      if ($assistance->pre_status == "PRESENTE" & $assistance->pre_course == $course->id) {
        $countPresent = $countPresent + 1;
        $countStatus = $countStatus + ($assistance->pre_hexit != null) ? 1 : 0;

        array_push($datesPresents, [
          $assistance->student->id, //id del estudiante
          $assistance->student->firstname . " " . $assistance->student->threename . " " . $assistance->student->fourname, // nombre del estudiante
          $assistance->pre_harrival, // hora de llegada
          $assistance->pre_hexit, //hora de salida
          $assistance->pre_obsa, //obs llegada
          $assistance->pre_obse, // obs salida
          $assistance->pre_tarrival, // temperatura llegada
          $assistance->pre_texit //temperatura salida  
        ]);
      } elseif ($assistance->pre_status == "AUSENTE" & $assistance->pre_course == $course->id) {
        $countAbsent = $countAbsent + 1;
      }
    }
    array_push($consolidated, [
      'ASISTENCIA',
      $course->name,
      $countPresent,
      $countAbsent,
      $countStatus,
      $datesPresents
    ]);
  }

  // INFORMACION DE ADICIONALES
  $autorizations = App\Models\Autorization::where('auDate', $date)->get();
  foreach ($autorizations as $autorization) {
    $student = App\Models\Student::find($autorization->auStudent_id);
    $separatedItems = explode('-', $autorization->auAutorized);
    for ($i = 0; $i < count($separatedItems); $i++) {
      $separatedIds = explode(':', $separatedItems[$i]);
      if ($separatedIds[0] == 'JORNADA') {
        $journey = App\Models\Journey::find($separatedIds[1]);
        if ($journey != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'JORNADA',
            $journey->jouJourney
          ]);
        }
      } else if ($separatedIds[0] == 'ALIMENTACION') {
        $feeding = App\Models\Feeding::find($separatedIds[1]);
        if ($feeding != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'ALIMENTACION',
            $feeding->feeConcept
          ]);
        }
      } else if ($separatedIds[0] == 'UNIFORME') {
        $uniform = App\Models\Uniform::find($separatedIds[1]);
        if ($uniform != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'UNIFORME',
            $uniform->uniConcept
          ]);
        }
      } else if ($separatedIds[0] == 'MATERIAL') {
        $supplie = App\Models\Supplie::find($separatedIds[1]);
        if ($supplie != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'MATERIAL ESCOLAR',
            $supplie->supConcept
          ]);
        }
      } else if ($separatedIds[0] == 'TIEMPO EXTRA') {
        $extratime = App\Models\Extratime::find($separatedIds[1]);
        if ($extratime != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'TIEMPO EXTRA',
            $extratime->extTConcept
          ]);
        }
      } else if ($separatedIds[0] == 'EXTRACURRICULAR') {
        $extracurricular = App\Models\Extracurricular::find($separatedIds[1]);
        if ($extracurricular != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'EXTRACURRICULAR',
            $extracurricular->extConcept . ' ' . $extracurricular->extIntensity
          ]);
        }
      } else if ($separatedIds[0] == 'TRANSPORTE') {
        $transport = App\Models\Transport::find($separatedIds[1]);
        if ($transport != null) {
          array_push($consolidated, [
            'NOVEDAD',
            $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
            'TRANSPORTE',
            $transport->traConcept
          ]);
        }
      }
    }
  }

  // INFORMACION DE CONTROL DE ALIMENTACION
  $controlfeedings = App\Models\FeedingControl::where('fcDate', $date)->get();
  foreach ($controlfeedings as $controlfeeding) {
    $student = App\Models\Legalization::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->where('legId', $controlfeeding->fcLegalization_id)->first();
    $separatedNews = explode('==', $controlfeeding->fcNews);
    for ($i = 0; $i < count($separatedNews); $i++) {
      $separatedItems = explode('=|=', $separatedNews[$i]);
      array_push($consolidated, [
        'ALIMENTACION',
        $student->nameStudent,
        $separatedItems[0],
        $separatedItems[1]
      ]);
    }
  }
  // INFORMACION DE CONTROL DE ESFINTERES
  $controlsphincters = App\Models\Sphincters::where('spDate', $date)->get();
  foreach ($controlsphincters as $controlsphincter) {
    $student = App\Models\Legalization::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->where('legId', $controlsphincter->spLegalization_id)->first();
    $separatedNews = explode('==', $controlsphincter->spNews);
    for ($i = 0; $i < count($separatedNews); $i++) {
      array_push($consolidated, [
        'ESFINTERES',
        $student->nameStudent,
        $separatedNews[$i]
      ]);
    }
  }
  // INFORMACION DE CONTROL DE ENFERMERIA
  $controlhealths = App\Models\HealthControl::where('hcDate', $date)->get();
  foreach ($controlhealths as $controlhealth) {
    $student = App\Models\Legalization::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->where('legId', $controlhealth->hcLegalization_id)->first();
    $separatedNews = explode('==', $controlhealth->hcNews);
    for ($i = 0; $i < count($separatedNews); $i++) {
      array_push($consolidated, [
        'ENFERMERIA',
        $student->nameStudent,
        $separatedNews[$i]
      ]);
    }
  }

  // INFORMACION DE CONTROL DE ENFERMERIA
  $controlevents = App\Models\Eventdiary::where('edDate', $date)->where('edStatus', 1)->get();
  foreach ($controlevents as $controlevent) {
    $creation = App\Models\Eventcreation::find($controlevent->edCreation_id);
    array_push($consolidated, [
      'EVENTOS',
      $creation->crName,
      $controlevent->edDescription,
      $controlevent->edDescriptionout
    ]);
  }
  return response()->json($consolidated);
})->name('getReportDaily');

//OBTENER EL NOMBRE DE ESTUDIANTE EN LOGISTICO >> PROGRAMACION DE EVENTOS >> AGENDAMIENTO (Ventana modal para eliminar)
Route::get('getStudentDiary', function (Request $request) {
  $student = App\Models\Listcourse::select(
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listCourse_id', '!=', null)
    ->where('students.id', $request->id)
    ->first();
  return response()->json($student);
})->name('getStudentDiary');

// CONSULTA DE TODOS LOS AGENDAMIENTOS DE APROGRAMACION DE EVENTOS QUE SE MUESTRAN EN EL CALENDARIO DE LOGISTICO >> PROGRAMACION >> SEGUIMIENTO
Route::get('getAllFollow', function (Request $request) {
  $follows = App\Models\Eventdiary::select(
    'eventDiary.edId AS id',
    'eventDiary.edDate AS start',
    'eventDiary.edStart',
    'eventDiary.edEnd',
    'eventDiary.edColor AS color',
    'eventCreations.crName AS title',
    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
  )
    ->join('collaborators', 'collaborators.id', 'eventDiary.edCollaborator_id')
    ->join('eventCreations', 'eventCreations.crId', 'eventDiary.edCreation_id')
    ->get();
  return response()->json($follows);
})->name('getAllFollow');

// CONSULTA DE TODOS LOS AGENDAMIENTOS DE APROGRAMACION DE EVENTOS QUE SE MUESTRAN EN EL CALENDARIO DE LOGISTICO >> PROGRAMACION >> SEGUIMIENTO
Route::get('getDetailsFollow', function (Request $request) {
  $info = array();
  $follow = App\Models\Eventdiary::select(
    'eventDiary.*',
    'eventCreations.crName',
    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
  )
    ->join('collaborators', 'collaborators.id', 'eventDiary.edCollaborator_id')
    ->join('eventCreations', 'eventCreations.crId', 'eventDiary.edCreation_id')
    ->where('eventDiary.edId', $request->edId)
    ->first();
  if ($follow != null) {
    $student = App\Models\Student::find($follow->edStudents);
    if ($student != null) {
      array_push($info, [
        $follow->edId,
        $follow->edDate,
        $follow->edStart,
        $follow->edEnd,
        $follow->edCollaborator_id,
        $follow->nameCollaborator,
        $follow->edCreation_id,
        $follow->crName,
        $student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
        $follow->edDescription,
        $follow->edStatus
      ]);
    } else {
      array_push($info, [
        $follow->edId,
        $follow->edDate,
        $follow->edStart,
        $follow->edEnd,
        $follow->edCollaborator_id,
        $follow->nameCollaborator,
        $follow->edCreation_id,
        $follow->crName,
        'N/A',
        $follow->edDescription,
        $follow->edStatus
      ]);
    }
  }
  return response()->json($info);
})->name('getDetailsFollow');

// CONSULTAR TODOS LOS ESTUDIANTES DE UN CURSOS SELECCIONADO CON MATRICULA VIGENTE EN LOGISTICO >> INFORMES ESPECIALES >> LISTADO DE MATRICULADOS
Route::get('getStudentFromCourseWithEnrollment', function (Request $request) {
  $datenow = Date('Y-m-d');
  $students = App\Models\Listcourse::select(
    'students.id',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listCourse_id', trim($request->courseSelected))
    ->get();
  $filterStudents = array();
  foreach ($students as $student) {
    $legalization = App\Models\Legalization::where([['legStudent_id', $student->id], ['legStatus', 'ACTIVO']])->first();
    $dateStart = Date('Y-m-d', strtotime($legalization->legDateInitial));
    $dateEnd = Date('Y-m-d', strtotime($legalization->legDateFinal));
    if (($datenow >= $dateStart) && ($datenow <= $dateEnd)) {
      array_push($filterStudents, [
        $student->id,
        $student->nameStudent
      ]);
    }
  }
  return response()->json($filterStudents);
})->name('getStudentFromCourseWithEnrollment');


// CONSULTAR EL ALUMNO PARA AGREGAR A TABLA EN LOGISTICO >> INFORMES ESPECIALES >> LISTADO DE MATRICULADOS
Route::get('getRowStudent', function (Request $request) {
  $student = App\Models\Legalization::select(
    'students.*',
    'students.id as idStudent',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'grades.name as nameGrade'
  )
    ->join('students', 'students.id', 'legalizations.legStudent_id')
    ->join('grades', 'grades.id', 'legalizations.legGrade_id')
    ->where('legStudent_id', trim($request->student))
    ->first();
  return response()->json($student);
})->name('getRowStudent');

// CONSULTAR EL NUMERO DE POSICION SELECCIONADO PARA AVISAR AL USUARIO EN REQUISITOS DE MATRICULAS
Route::get('getNumberSelected', function (Request $request) {
  $maxnumber = App\Models\DocumentEnroll::select('dePosition', 'deConcept')->where('dePosition', trim($request->number))->first();
  if ($maxnumber != null) {
    return response()->json($maxnumber);
  } else {
    return response()->json(null);
  }
})->name('getNumberSelected');

// CONSULTAR LAS DESCRIPCIONES DE COSTO DE ACUERDO A LA ESTRUCTURA SELECCIONADA EN FINANCIERO >> ANALISIS >> PRESUPUESTO
Route::get('getCostdescriptions', function (Request $request) {
  $costDescription = App\Models\Costdescription::where('cdCoststructure_id', trim($request->idCoststructure))->get();
  return response()->json($costDescription);
})->name('getCostdescriptions');


// LAS TRES FUNCIONES SIGUIENTES SON PARA USAR EN LA SIGUIENTE RUTA = getFollowYearMount
function getStringMount($mount)
{
  switch ($mount) {
    case '01':
      return 'ENERO';
    case '02':
      return 'FEBRERO';
    case '03':
      return 'MARZO';
    case '04':
      return 'ABRIL';
    case '05':
      return 'MAYO';
    case '06':
      return 'JUNIO';
    case '07':
      return 'JULIO';
    case '08':
      return 'AGOSTO';
    case '09':
      return 'SEPTIEMBRE';
    case '10':
      return 'OCTUBRE';
    case '11':
      return 'NOVIEMBRE';
    case '12':
      return 'DICIEMBRE';
  }
}

function getMount($numberMount)
{
  return ($numberMount < 10 ? '0' : '') . $numberMount;
}

function numberDays($mount, $year)
{
  $days = date("t", strtotime($year . '-' . $mount . '-15'));
  return $days;
  //dd(cal_days_in_month(CAL_GREGORIAN,$mount,$year));
  //return cal_days_in_month(CAL_GREGORIAN,$mount,$year);
}

// CONSULTAR SEGUIMIENTO MENSUAL DE ACUERDO A LOS DATOS SELECCIONADOS EN FINANCIERO >> ANALISIS DE PRESUPUESTO >> SEGUIMIENTO MENSUAL
Route::get('getFollowYearMount', function (Request $request) {
  $mount = (int)$request->mount;
  $voucheregress = App\Models\Egress::whereBetween('vegDate', [$request->year . '-' . $request->mount . '-01', $request->year . '-' . $request->mount . '-' . numberDays($mount, $request->year)])->get();
  $totalVouchers = 0;
  $budgetMountValue = 0;
  foreach ($voucheregress as $voucher) {
    $totalVouchers += $voucher->vegPay; // SUMATORIA DE LOS VALORES DE LOS COMPROBANTES DE EGRESO
  }
  $budget = App\Models\Annual::where('aYear', $request->year)->first();
  if ($budget != null) {
    $separatedDetails = explode('-', $budget->aDetailsMount);
    for ($i = 0; $i < count($separatedDetails); $i++) {
      $separated = explode(':', $separatedDetails[$i]);
      if ($separated[0] == getStringMount($request->mount)) {
        $budgetMountValue = $separated[1]; // VALOR DEL PRESUPUESTO TOTAL PARA EL MES Y AÑO SELECCIONADO
        break;
      }
    }
  } else {
    $budgetMountValue = '0 - No existe presupuesto';
  }
  if ($budgetMountValue > 0) {
    $porcentage = ($totalVouchers * 100) / $budgetMountValue; // PORCENTAJE DEL PRESUPUESTO EJECUTADO
  } else {
    $porcentage = 0;
  }
  $result = array();
  array_push($result, $budgetMountValue);
  array_push($result, $totalVouchers);
  array_push($result, $porcentage . '%');

  return response()->json($result);
})->name('getFollowYearMount');

// CONSULTAR CUERPO SELECCIONADO EN LOGISTICO >> CIRCULARES INFORMATIVAS >> CIRCULARES ACADEMICAS
Route::get('getBodyselected', function (Request $request) {
  $body = App\Models\Body::find($request->body_id);
  return response()->json($body);
})->name('getBodyselected');


// CONSULTAR CANTIDAD DE COMPROBANTES ANTERIORES DE UNA FACTURA:
Route::get('getCountvoucherBefore', function (Request $request) {
  $countVoucher = App\Models\Facturation::select('facCountVoucher')->where('facCode', $request->facCode)->first();
  return response()->json($countVoucher);
})->name('getCountvoucherBefore');

// CONSULTAR PERIODOS A PARTIR DE UN ALUMNO SELECCIONADO EN LOGISTICA >> CRECIMIENTO Y DESARROLLO >> VALORACIONES PERIODICAS
Route::get('getPeriodsRating', function (Request $request) {
  $query = App\Models\Listcourse::select(
    'listcourses.listCourse_id',
    'courses.name as nameCourse',
    'students.*'
  )
    ->join('courses', 'courses.id', 'listcourses.listCourse_id')
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listStudent_id', trim($request->studentSelected))->first();
  $periods = array();
  if ($query != null) {
    array_push($periods, [
      'INFORMACION BASICA',
      $query->firstname . ' ' . $query->threename . ' ' . $query->fourname,
      $query->birthdate,
      $query->numberdocument,
      $query->nameCourse
    ]);
    $periodsAcademic = App\Models\Academicperiod::where('apCourse_id', $query->listCourse_id)->get();
    foreach ($periodsAcademic as $period) {
      array_push($periods, [
        $period->apId,
        $period->apNameperiod
      ]);
    }
  }
  return response()->json($periods);
})->name('getPeriodsRating');

// CONSULTAR VALORACIONES DE ACUERDO A LA VALORACION SELECCIONADA EN CRECIMIENTO Y DESARROLLO >> VALORACIONES PERIODICAS
Route::get('getRating', function (Request $request) {
  $rating = App\Models\Ratingperiod::select(
    'ratingsPeriod.*',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'students.numberdocument',
    'students.birthdate',
    'academicperiods.apNameperiod',
    'courses.name as nameCourse'
  )
    ->join('students', 'students.id', 'ratingsPeriod.rpStudent_id')
    ->join('academicperiods', 'academicperiods.apId', 'ratingsPeriod.rpAcademicperiod_id')
    ->join('courses', 'courses.id', 'academicperiods.apCourse_id')
    ->where('ratingsPeriod.rpId', trim($request->rpId))->first();
  return response()->json($rating);
})->name('getRating');

// CONSULTAR OBSERVACION DE LA SALUD EN LA BASE DE DATOS DE ACUERDO AL ID PARA EDITAR/ELIMINAR VALORACIONES PERIODICAS
Route::get('getObservationhealth', function (Request $request) {
  $observationhealth = App\Models\ObservationHealth::find(trim($request->ohId));
  return response()->json($observationhealth);
})->name('getObservationhealth');

// CONSULTAR PROFESIONAL DE LA SALUD EN LA BASE DE DATOS DE ACUERDO AL ID PARA EDITAR/ELIMINAR VALORACIONES PERIODICAS
Route::get('getProfessionalhealth', function (Request $request) {
  $professionalhealth = App\Models\ProfessionHealth::find(trim($request->phId));
  return response()->json($professionalhealth);
})->name('getProfessionalhealth');

// CONSULTAR ESQUEMA DE VACUNACION EN LA BASE DE DATOS DE ACUERDO AL ID PARA ELIMINAR VALORACIONES PERIODICAS
Route::get('getVaccinations', function (Request $request) {
  $vaccination = App\Models\Vaccination::find(trim($request->vaId));
  $result = [$vaccination->vaName, $request->vaStatus];
  return response()->json($result);
})->name('getVaccinations');

// CONSULTAR FACTURA PARA MODAL PARA EDITAR VALORES, EN MODULO GESTION DE CARTERA
Route::get('getFactureFromEdit', function (Request $request) {
  $facturation = App\Models\Facturation::find(trim($request->facId));
  return response()->json($facturation);
})->name('getFactureFromEdit');

// OBTENER LAS LOCALIDADES RELACIONADAS CON UN CIUDAD SELECCIONADA EN EL FORMULARIO DE MATRICULA
Route::get('getLocationFromAdmission', function (Request $request) {
  $locations = App\Models\Location::where('city_id', trim($request->city_id))->orderBy('locations.name')->get();
  return response()->json($locations);
})->name('getLocationFromAdmission');

// OBTENER BARRIOS RELACIONADOS CON UNA LOCALIDAD EN EL FORMULARIO DE MATRICULA
Route::get('getDistrictFromAdmission', function (Request $request) {
  $districts = App\Models\District::where('location_id', trim($request->location_id))->orderBy('districts.name')->get();
  return response()->json($districts);
})->name('getDistrictFromAdmission');

//BUSCAR ALUMNO DE UN DETERMINADO GRADO (SELECT EN LISTADO => TRASLADO DE ALUMNOS ENTRE LOS GRADOS EXISTENTES)
Route::get('getStudentFromGrade', function (Request $request) {
  $students = App\Models\Listcourse::select(
    'students.*'
  )
    ->join('students', 'students.id', 'listcourses.listStudent_id')
    ->where('listGrade_id', $request->selectedGrade)->get();
  //dd($listCourse);
  return response()->json($students);
})->name('getStudentFromGrade');

// TRASLADOS DE ALUMNOS ENTRE LOS GRADOS EXISTENTES
Route::post('translateStudent', function (Request $request) {
  $query = App\Models\Listcourse::where('listGrade_id', $request->originGrade)->where('listCourse_id', $request->originCourse)->where('listStudent_id', $request->student)->first();
  //dd($listCourse);
  $ready = 0;
  if ($query != null) {
    $query->listGrade_id = $request->destinyGrade;
    $query->listCourse_id = $request->destinyCourse;
    $legalization = App\Models\Legalization::where('legStudent_id', $request->student)->first();
    if ($legalization != null) {
      $legalization->legGrade_id = $request->destinyGrade;
      $query->save();
      $legalization->save();
    }
    $ready = 1;
  }
  return response()->json($ready);
})->name('translateStudent');

// CONSULTA SI YA EXISTE UN ALUMNO MATRICULADO PARA MIGRAR INFORMACION DE FORMULARIO
Route::get('getLegalizationMigration', function (Request $request) {

  $migration = array();
  $admission = App\Models\Formadmission::where('fmId', trim($request->fmId))->first();
  $student = App\Models\Student::select(
    // 'legalizations.*',
    'students.*',
    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
    'documents.type as type',
    'bloodtypes.group as groupBlood',
    'bloodtypes.type as typeBlood',
    'healths.entity as entityHealth',
    'healths.type as typeHealth'
    // 'citys.name as nameCity',
    // 'locations.name as nameLocation',
    // 'districts.name as nameDistrict'
  )
    // ->join('students','students.id','legalizations.legStudent_id')

    ->join('documents', 'documents.id', 'students.typedocument_id')
    ->join('bloodtypes', 'bloodtypes.id', 'students.bloodtype_id')
    ->join('healths', 'healths.id', 'students.health_id')

    // ->join('citys','citys.id','students.cityhome_id')
    // ->join('locations','locations.id','students.locationhome_id')
    // ->join('districts','districts.id','students.dictricthome_id')
    ->where('numberdocument', trim($request->numerodocumento))->first();
  // dd($student);
  if ($student != null) {
    // documents => id, type
    $findSpace = strpos(trim($admission->apellidos), " ");
    if ($findSpace !== false) {
      $separados = explode(" ", trim($admission->apellidos));
      $apellidosNew = $separados[0] . "|" . $separados[1];
    } else {
      $apellidosNew = trim($admission->apellidos);
    }
    $documentTypeStudent = App\Models\Document::where('type', 'like', '%' . $admission->tipodocumento . '%')->first();
    if ($documentTypeStudent != null) {
      $documentStudent = $documentTypeStudent->type;
      $documentStudentMigration = $documentTypeStudent->id . "|" . $documentTypeStudent->type;
    } else {
      $documentStudent = $admission->tipodocumento;
      $documentStudentMigration = null;
    }
    $typeArrival = Bloodtype::where('id', $admission->tiposangre)->value('type');
    $EPSArrival = Health::where('id', $admission->health)->value('entity');
    $typeExists = Bloodtype::where('id', $student->bloodtype_id)->value('type');
    $EPSExists = Health::where('id', $student->health_id)->value('entity');
    array_push(
      $migration,
      [
        ["id_student", $admission->fmId, $student->id],
        ["Foto", $admission->foto, $student->photo],
        ["Tipo de documento", $documentStudent, $student->type, $documentStudent],
        ["Número de documento", $admission->numerodocumento, $student->numberdocument],
        ["Fecha de nacimiento", $admission->fechanacimiento, date_format($student->birthdate, 'Y-m-d')],
        ["Nombres y apellidos", $admission->nombres . " " . $admission->apellidos, $student->nameStudent, $admission->nombres . "|" . $apellidosNew],
        ["Tipo de sangre", $typeArrival, $typeExists],
        ["Género", $admission->genero, $student->gender],
        ["Salud", $EPSArrival, $EPSExists],
        ["Salud adicional", 'SI', $student->additionalHealt],
        [
          "Descripción de salud adicional / Informacion adicional",
          'Datos de formulario de admission: ' .
            'Nacionalidad: ' . $admission->nacionalidad . '. ' .
            'Meses de gestación: ' . $admission->mesesgestacion . '. ' .
            'Tipo de parto: ' . $admission->tipoparto . '. ' .
            'Enfermedades: ' . $admission->enfermedades . '. ' .
            'Tratamientos: ' . $admission->tratamientos . '. ' .
            'Alergias: ' . $admission->alergias . '. ' .
            'Asiste a terapias: ' . $admission->asistenciaterapias . '. ' .
            'Cual terapia: ' . $admission->cual . '. ' .
            'Programa a cursar: ' . $admission->programa . '. ' .
            'Numero de hermanos: ' . $admission->numerohermanos . '. ' .
            'Lugar que ocupa entre sus hermanos: ' . $admission->lugarqueocupa . '. ' .
            'Con quien vive: ' . $admission->conquienvive . '. ' .
            'Otros cuidados: ' . $admission->otroscuidados . '. ' .
            'Nombre de contacto de emergencia: ' . $admission->nombreemergencia . '. ' .
            'Documento en caso de emergencia: ' . $admission->documentoemergencia . '. ' .
            'Dirección emergencia: ' . $admission->direccionemergencia . '. ' .
            'Barrio emergencia: ' . $admission->barrioemergencia . '. ' .
            'Localidad de emergencia: ' . $admission->localidademergencia . '. ' .
            'Celular de emergencia: ' . $admission->celularemergencia . '. ' .
            'Whatsapp de emergencia: ' . $admission->whatsappemergencia . '. ' .
            'Parentesco de contacto de emergencia: ' . $admission->parentescoemergencia . '. ' .
            'Correo de emergencia: ' . $admission->correoemergencia  . '.',
          $student->additionalHealtDescription
        ]
      ]
    );
  } else {
    $findSpace = strpos(trim($admission->apellidos), " ");
    if ($findSpace !== false) {
      $separados = explode(" ", trim($admission->apellidos));
      $apellidosNew = $separados[0] . "|" . $separados[1];
    } else {
      $apellidosNew = trim($admission->apellidos);
    }
    $documentTypeStudent = App\Models\Document::where('type', 'like', '%' . $admission->tipodocumento . '%')->first();
    if ($documentTypeStudent != null) {
      $documentStudent = $documentTypeStudent->type;
      $documentStudentMigration = $documentTypeStudent->id . "|" . $documentTypeStudent->type;
    } else {
      $documentStudent = $admission->tipodocumento;
      $documentStudentMigration = null;
    }
    // array_push($migration,null);
    $typeArrival = Bloodtype::where('id', $admission->tiposangre)->value('type');
    array_push(
      $migration,
      [
        ["id_student", $admission->fmId, 'No existe'],
        ["Foto", $admission->foto, 'No existe'],
        ["Tipo de documento", $documentStudent, 'No existe', $documentStudentMigration],
        ["Número de documento", $admission->numerodocumento, 'No existe'],
        ["Fecha de nacimiento", $admission->fechanacimiento, 'No existe'],
        ["Nombres y apellidos", $admission->nombres . " " . $admission->apellidos, 'No existe', $admission->nombres . "|" . $apellidosNew],
        ["Tipo de sangre", $typeArrival, 'No existe'],
        ["Género", $admission->genero, 'No existe'],
        ["Salud", $admission->health, 'No existe'],
        ["Salud adicional", 'SI', 'No existe'],
        [
          "Descripción de salud adicional / Informacion adicional",
          'Datos de formulario de admission: ' .
            'Nacionalidad: ' . $admission->nacionalidad . '. ' .
            'Meses de gestación: ' . $admission->mesesgestacion . '. ' .
            'Tipo de parto: ' . $admission->tipoparto . '. ' .
            'Enfermedades: ' . $admission->enfermedades . '. ' .
            'Tratamientos: ' . $admission->tratamientos . '. ' .
            'Alergias: ' . $admission->alergias . '. ' .
            'Asiste a terapias: ' . $admission->asistenciaterapias . '. ' .
            'Cual terapia: ' . $admission->cual . '. ' .
            'Programa a cursar: ' . $admission->programa . '. ' .
            'Numero de hermanos: ' . $admission->numerohermanos . '. ' .
            'Lugar que ocupa entre sus hermanos: ' . $admission->lugarqueocupa . '. ' .
            'Con quien vive: ' . $admission->conquienvive . '. ' .
            'Otros cuidados: ' . $admission->otroscuidados . '. ' .
            'Nombre de contacto de emergencia: ' . $admission->nombreemergencia . '. ' .
            'Documento en caso de emergencia: ' . $admission->documentoemergencia . '. ' .
            'Dirección emergencia: ' . $admission->direccionemergencia . '. ' .
            'Barrio emergencia: ' . $admission->barrioemergencia . '. ' .
            'Localidad de emergencia: ' . $admission->localidademergencia . '. ' .
            'Celular de emergencia: ' . $admission->celularemergencia . '. ' .
            'Whatsapp de emergencia: ' . $admission->whatsappemergencia . '. ' .
            'Parentesco de contacto de emergencia: ' . $admission->parentescoemergencia . '. ' .
            'Correo de emergencia: ' . $admission->correoemergencia  . '.',
          'No existe'
        ]
      ]
    );
  }

  $findSpace = strpos(trim($admission->nombreacudiente1), " ");
  if ($findSpace !== false) {
    $separados = explode(" ", trim($admission->nombreacudiente1));
    if (count($separados) == 4) {
      $nombresNew = $separados[0] . " " . $separados[1] . "|" . $separados[2] . " " . $separados[3];
    } elseif (count($separados) == 3) {
      $nombresNew = $separados[0] . "|" . $separados[1] . " " . $separados[2];
    } elseif (count($separados) == 2) {
      $nombresNew = $separados[0] . "|" . $separados[1];
    } else {
      $nombresNew = '';
      for ($i = 0; $i < count($separados); $i++) {
        $nombresNew .= $separados[$i] . ' ';
      }
      $nombresNew = trim($nombresNew);
    }
  } else {
    $nombresNew = trim($admission->nombreacudiente1);
  }
  $acudiente1 = App\Models\Attendant::where('numberdocument', trim($admission->documentoacudiente1))->first();
  if ($acudiente1 != null) {
    $typedocument_id1 = trim($acudiente1->typedocument_id);
    array_push(
      $migration,
      [
        ["id_attendant1", $admission->fmId, $acudiente1->id],
        ["Nombres", $admission->nombreacudiente1, $acudiente1->firstname . " " . $acudiente1->threename, $nombresNew],
        ["N° Documento", $admission->documentoacudiente1, $acudiente1->numberdocument],
        ["Dirección Residencia", $admission->direccionacudiente1, $acudiente1->address],
        ["Barrio", $admission->barrioacudiente1, $acudiente1->locationhome_id],
        ["Localidad", $admission->localidadacudiente1, $acudiente1->dictricthome_id],
        ["Celular", $admission->celularacudiente1, $acudiente1->phoneone],
        ["Whatsapp", $admission->whatsappacudiente1, $acudiente1->whatsapp],
        ["Correo eletrónico", $admission->correoacudiente1, $acudiente1->emailone],
        ["Formación", $admission->formacionacudiente1, $acudiente1->profession_id],
        ["Título", $admission->tituloacudiente1, $acudiente1->address],
        ["Tipo de ocupación", $admission->tipoocupacionacudiente1, $acudiente1->position],
        ["Empresa", $admission->empresaacudiente1, $acudiente1->company],
        ["Dirección", $admission->direccionempresaacudiente1, $acudiente1->addresscompany],
        ["Ciudad Empresa", $admission->ciudadempresaacudiente1, $acudiente1->citycompany_id],
        ["Barrio Empresa", $admission->barrioempresaacudiente1, $acudiente1->dictrictcompany_id],
        ["Localidad Empresa", $admission->localidadempresaacudiente1, $acudiente1->locationcompany_id],
        ["Cargo", $admission->cargoempresaacudiente1, $acudiente1->position],
        ["Fecha Ingreso", $admission->fechaingresoempresaacudiente1, $acudiente1->antiquity],
      ]
    );
  } else {
    // array_push($migration,null);
    array_push(
      $migration,
      [
        ["id_attendant1", $admission->fmId, 'No existe'],
        ["Nombres", $admission->nombreacudiente1, 'No existe', $nombresNew],
        ["N° Documento", $admission->documentoacudiente1, 'No existe'],
        ["Dirección Residencia", $admission->direccionacudiente1, 'No existe'],
        ["Barrio", $admission->barrioacudiente1, 'No existe'],
        ["Localidad", $admission->localidadacudiente1, 'No existe'],
        ["Celular", $admission->celularacudiente1, 'No existe'],
        ["Whatsapp", $admission->whatsappacudiente1, 'No existe'],
        ["Correo eletrónico", $admission->correoacudiente1, 'No existe'],
        ["Formación", $admission->formacionacudiente1, 'No existe'],
        ["Título", $admission->tituloacudiente1, 'No existe'],
        ["Tipo de ocupación", $admission->tipoocupacionacudiente1, 'No existe'],
        ["Empresa", $admission->empresaacudiente1, 'No existe'],
        ["Dirección", $admission->direccionempresaacudiente1, 'No existe'],
        ["Ciudad Empresa", $admission->ciudadempresaacudiente1, 'No existe'],
        ["Barrio Empresa", $admission->barrioempresaacudiente1, 'No existe'],
        ["Localidad Empresa", $admission->localidadempresaacudiente1, 'No existe'],
        ["Cargo", $admission->cargoempresaacudiente1, 'No existe'],
        ["Fecha Ingreso", $admission->fechaingresoempresaacudiente1, 'No existe'],
      ]
    );
  }

  $findSpace = strpos(trim($admission->nombreacudiente2), " ");
  if ($findSpace !== false) {
    $separados = explode(" ", trim($admission->nombreacudiente2));
    if (count($separados) == 4) {
      $nombresNew = $separados[0] . " " . $separados[1] . "|" . $separados[2] . " " . $separados[3];
    } elseif (count($separados) == 3) {
      $nombresNew = $separados[0] . "|" . $separados[1] . " " . $separados[2];
    } elseif (count($separados) == 2) {
      $nombresNew = $separados[0] . "|" . $separados[1];
    } else {
      $nombresNew = '';
      for ($i = 0; $i < count($separados); $i++) {
        $nombresNew .= $separados[$i] . ' ';
      }
      $nombresNew = trim($nombresNew);
    }
  } else {
    $nombresNew = trim($admission->nombreacudiente2);
  }
  $acudiente2 = App\Models\Attendant::where('numberdocument', trim($admission->documentoacudiente2))->first();
  if ($acudiente2 != null) {
    $typedocument_id2 = trim($acudiente2->typedocument_id);
    array_push(
      $migration,
      [
        ["id_attendant2", $admission->fmId, $acudiente2->id],
        ["Nombres", $admission->nombreacudiente2, $acudiente2->firstname . " " . $acudiente2->threename, $nombresNew],
        ["N° Documento", $admission->documentoacudiente2, $acudiente2->numberdocument],
        ["Dirección Residencia", $admission->direccionacudiente2, $acudiente2->address],
        ["Barrio", $admission->barrioacudiente2, $acudiente2->locationhome_id],
        ["Localidad", $admission->localidadacudiente2, $acudiente2->dictricthome_id],
        ["Celular", $admission->celularacudiente2, $acudiente2->phoneone],
        ["Whatsapp", $admission->whatsappacudiente2, $acudiente2->whatsapp],
        ["Correo eletrónico", $admission->correoacudiente2, $acudiente2->emailone],
        ["Formación", $admission->formacionacudiente2, $acudiente2->profession_id],
        ["Título", $admission->tituloacudiente2, $acudiente2->address],
        ["Tipo de ocupación", $admission->tipoocupacionacudiente2, $acudiente2->position],
        ["Empresa", $admission->empresaacudiente2, $acudiente2->company],
        ["Dirección", $admission->direccionempresaacudiente2, $acudiente2->addresscompany],
        ["Ciudad Empresa", $admission->ciudadempresaacudiente2, $acudiente2->citycompany_id],
        ["Barrio Empresa", $admission->barrioempresaacudiente2, $acudiente2->dictrictcompany_id],
        ["Localidad Empresa", $admission->localidadempresaacudiente2, $acudiente2->locationcompany_id],
        ["Cargo", $admission->cargoempresaacudiente2, $acudiente2->position],
        ["Fecha Ingreso", $admission->fechaingresoempresaacudiente2, $acudiente2->antiquity],
      ]
    );
  } else {
    // array_push($migration,null);
    array_push(
      $migration,
      [
        ["id_attendant2", $admission->fmId, 'No existe'],
        ["Nombres", $admission->nombreacudiente2, 'No existe', $nombresNew],
        ["N° Documento", $admission->documentoacudiente2, 'No existe'],
        ["Dirección Residencia", $admission->direccionacudiente2, 'No existe'],
        ["Barrio", $admission->barrioacudiente2, 'No existe'],
        ["Localidad", $admission->localidadacudiente2, 'No existe'],
        ["Celular", $admission->celularacudiente2, 'No existe'],
        ["Whatsapp", $admission->whatsappacudiente2, 'No existe'],
        ["Correo eletrónico", $admission->correoacudiente2, 'No existe'],
        ["Formación", $admission->formacionacudiente2, 'No existe'],
        ["Título", $admission->tituloacudiente2, 'No existe'],
        ["Tipo de ocupación", $admission->tipoocupacionacudiente2, 'No existe'],
        ["Empresa", $admission->empresaacudiente2, 'No existe'],
        ["Dirección", $admission->direccionempresaacudiente2, 'No existe'],
        ["Ciudad Empresa", $admission->ciudadempresaacudiente2, 'No existe'],
        ["Barrio Empresa", $admission->barrioempresaacudiente2, 'No existe'],
        ["Localidad Empresa", $admission->localidadempresaacudiente2, 'No existe'],
        ["Cargo", $admission->cargoempresaacudiente2, 'No existe'],
        ["Fecha Ingreso", $admission->fechaingresoempresaacudiente2, 'No existe'],
      ]
    );
  }
  return response()->json($migration);
})->name('getLegalizationMigration');

Route::get('getNumberGreeting', function () {
  $query = App\Models\Schedule::latest('sch_id')->first();
  return response()->json($query);
})->name('getNumberGreeting');

Route::get('getNumbercontext', function () {
  $query = App\Models\ScheduleContext::latest('sch_id')->first();
  return response()->json($query);
})->name('getNumbercontext');

Route::get('getCircularDel', function (Request $request) {
  $query = \App\Models\AcademicCircularFile::where('acf_id', $request->data)
    ->join('collaborators', 'collaborators.id', 'academic_circular_files.acf_cirFrom')->first();
  return response()->json($query);
})->name('getCircularDel');

Route::get('getAdministrativeDel', function (Request $request) {
  $query = \App\Models\AdministrativeCircularFile::where('acf_id', $request->data)
    ->join('collaborators', 'collaborators.id', 'administrative_circular_file.acf_cirFrom')->first();
  return response()->json($query);
})->name('getAdministrativeDel');

Route::get('getMemorandoDel', function (Request $request) {
  $query = \App\Models\InternalMemo::where('imf_id', $request->data)->first();
  return response()->json($query);
})->name('getMemorandoDel');

Route::get("getAlumnsList", function () {
  $Courses = Course::all();
  $Students = Student::all();
  $ListCourse = Listcourse::select('listcourses.*', 'students.*', 'courses.*')
    ->join('courses', 'courses.id', 'listcourses.listCourse_id')
    ->join('students', 'students.id', 'listStudent_id')->get();
  return response()->json($ListCourse);
})->name("getAlumnsList");

Route::get("getSales", function (Request $request) {
  $query = Entry::whereYear('venDate', $request->data)->get();
  return response()->json($query);
})->name("getSales");

Route::get("getInfoMail", function (Request $request) {
  $query = InfoDaily::where("id_id", $request->data)->get();
  return response()->json($query);
})->name("getInfoMail");

Route::post("getGrade", function (Request $request) {
  $query = Course::where("grade_id", $request->grade)->get();
  return response()->json($query);
})->name("getGrade");

Route::post("getStudent", function (Request $request) {
  $query = Listcourse::where('listCourse_id', $request->course)
    ->join("students", "students.id", "listcourses.listStudent_id")->get();
  return response()->json($query);
})->name("getStudent");

Route::get("apiGetAsistences", function () {
  $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
  $day = Carbon::today('America/Bogota')->locale('es')->dayName;
  $dateNow = ucfirst($day) . " " . $date;
  $query = Presence::select('presences.*', 'students.*')
    ->join("students", "students.id", "presences.pre_student")
    ->where("pre_date", trim($dateNow))->get();
  return response()->json($query);
})->name("apiGetAsistences");

Route::post('getInfoArrival', function (Request $request) {
  $query = Presence::where('pre_id', $request->data)
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')->get();
  return response()->json($query);
})->name('getInfoArrival');

Route::post('getAssistences', function () {
  $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
  $day = Carbon::today('America/Bogota')->locale('es')->dayName;
  $dateNow = ucfirst($day) . " " . $date;
  $query = Presence::select('presences.*', 'students.*', 'courses.*')
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')
    ->where([
      ['pre_date', trim($dateNow)],
      ['pre_status', "PRESENTE"]
    ])->get();
  return response()->json($query);
})->name("getAssistences");

Route::post('getAbsence', function () {
  $date = Carbon::today('America/Bogota')->locale('es')->isoFormat('LL');
  $day = Carbon::today('America/Bogota')->locale('es')->dayName;
  $dateNow = ucfirst($day) . " " . $date;
  $query = Presence::select('presences.*', 'students.*', 'courses.*')
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')
    ->where([
      ['pre_date', trim($dateNow)],
      ['pre_status', "AUSENTE"]
    ])->get();
  return response()->json($query);
})->name("getAbsence");

Route::post('getAssistDate', function (Request $request) {
  $date = Carbon::create($request->dt)->locale('es')->isoFormat('LL');
  $day = Carbon::create($request->dt)->locale('es')->dayName;
  $dateSearch = ucfirst($day) . " " . $date;

  $query = Presence::with('student:id,firstname,threename,fourname', 'course:id,name')->where([['pre_date', trim($dateSearch)], ['pre_status', "PRESENTE"]])->orderby('pre_course', 'asc')->get();

  return response()->json($query);
})->name("getAssistDate");

Route::post('getAbsenceDate', function (Request $request) {
  $date = Carbon::create($request->dt)->locale('es')->isoFormat('LL');
  $day = Carbon::create($request->dt)->locale('es')->dayName;
  $dateSearch = ucfirst($day) . " " . $date;
  $query = Presence::where([['pre_date', trim($dateSearch)], ['pre_status', "AUSENTE"]])
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')->get();
  return response()->json($query);
})->name("getAbsenceDate");

Route::post('getDataStudent', function (Request $request) {
  $query = Presence::where('pre_student', $request->student)
    ->join('students', 'students.id', 'presences.pre_student')
    ->join('courses', 'courses.id', 'presences.pre_course')
    ->orderBy('created_at', 'asc')->get();
  return response()->json($query);
})->name('getDataStudent');

Route::post('getAssistAnual', function (Request $request) {
  $search = Presence::where("pre_student", $request->student)->get();
  return response()->json($search);
})->name('getAssistAnual');

Route::post('departament', function (Request $request) {
  $country = DB::table('paises_prefijoopcional')->where('iddep_pais_prefijoopcional', $request->country)->value('cod_pais_prefijoopcional');
  $departments = DB::table('departamentospaises_prefijoopcional')->where('cod_pais_prefijoopcional', $country)->select('departamentospaises_prefijoopcional.cod_deppais_prefijoopcional AS codiDepartament', 'departamentospaises_prefijoopcional.nom_deppais_prefijoopcional AS nomDepartament', 'departamentospaises_prefijoopcional.iddep_deppais_prefijoopcional AS diminutiveDepartment')->get();
  return $departments;
})->name('apiDepartament');

Route::post('citys', function (Request $request) {
  $departament = DB::table('ciudades_prefijoopcional')->where('cod_deppais_prefijoopcional', $request->departement)->get();
  return $departament;
})->name('apiCity');

Route::post('postal', function (Request $request) {
  $postal = DB::table('codigos_postales_prefijoopcional')->where('cod_ciud_prefijoopcional', $request->city)->pluck('codpos_codpos_prefijoopcional');
  return $postal;
})->name('apiPostal');

Route::post('initials', function (Request $request) {
  $attendant = Attendant::where('id', $request->id)->select('cityhome_id', 'departamenthome_id', 'postalhome_id', 'countryhome_id')->get();
  $country = DB::table('paises_prefijoopcional')->where('iddep_pais_prefijoopcional', $attendant[0]['countryhome_id'])->value('cod_pais_prefijoopcional');
  $departament = DB::table('departamentospaises_prefijoopcional')->where('cod_pais_prefijoopcional', $country)->select('departamentospaises_prefijoopcional.cod_deppais_prefijoopcional AS codiDepartament', 'departamentospaises_prefijoopcional.nom_deppais_prefijoopcional AS nomDepartament', 'departamentospaises_prefijoopcional.iddep_deppais_prefijoopcional AS diminutiveDepartment')->get();
  $city = DB::table('ciudades_prefijoopcional')->where('cod_deppais_prefijoopcional', $attendant[0]['departamenthome_id'])->get();
  $postal = DB::table('codigos_postales_prefijoopcional')->where('cod_ciud_prefijoopcional', $attendant[0]['cityhome_id'])->pluck('codpos_codpos_prefijoopcional');

  $data = array(
    "acudiente" => $attendant,
    "departamentos" => $departament,
    "ciudades" => $city,
    "postales" => $postal
  );

  return $data;
})->name('apiInitials');
