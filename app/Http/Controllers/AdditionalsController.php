<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Course;
use App\Models\Admission;
use App\Models\Journey;
use App\Models\Feeding;
use App\Models\Uniform;
use App\Models\Supplie;
use App\Models\Extratime;
use App\Models\Extracurricular;
use App\Models\Transport;
use App\Models\Autorization;
use App\Models\Legalization;
use App\Models\Concept;
use Exception;

class AdditionalsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  function additionalTo()
  {
    $courses = Course::all();
    $admissions = Admission::all();
    $journeys = Journey::all();
    $feedings = Feeding::all();
    $uniforms = Uniform::all();
    $supplies = Supplie::all();
    $extratimes = Extratime::all();
    $extracurriculars = Extracurricular::all();
    $transports = Transport::all();
    return view('modules.additionals.new', compact('courses', 'admissions', 'journeys', 'feedings', 'uniforms', 'supplies', 'extratimes', 'extracurriculars', 'transports'));
  }

  function newAdditional(Request $request)
  {
    try {
      /*
                $request->addCourse;
                $request->addStudent;
                $request->addIdAttendant;
                $request->addDate;
                $request->addDescription;
                $request->addAdmission;
                $request->activeAdmission;
                $request->addJourney;
                $request->activeJourney;
                $request->addFeeding;
                $request->activeFeeding;
                $request->addUniform;
                $request->activeUniform;
                $request->addSupplie;
                $request->activeSupplie;
                $request->addExtratime;
                $request->activeExtratime;
                $request->addExtracurricular;
                $request->activeExtracurricular;
                $request->addTransport;
                $request->activeTransport;
                $request->all_items;
                */
      // dd($request->all());
      $autorizatedValidate = Autorization::where('auDate', trim($request->addDate))
        ->where('auStudent_id', trim($request->addStudent))
        ->where('auCourse_id', trim($request->addCourse))
        ->first();
      $legalization = Legalization::select('legId')->where('legStudent_id', $request->addStudent)->first();
      $autorized = '';

      $separatedItems = explode('=', substr(trim($request->all_items), 0, -1));

      for ($i = 0; $i < count($separatedItems); $i++) {
        $separatedIds = explode(':', $separatedItems[$i]);
        $autorized .= $separatedItems[$i] . '-';
        if ($separatedIds[0] == 'ADMISION') {
          $admission = Admission::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'ADMISION: ' . $admission->admConcept,
            'conValue' => $admission->admValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'JORNADA') {
          $journey = Journey::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'JORNADA: ' . $journey->jouJourney,
            'conValue' => $journey->jouValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'ALIMENTACION') {
          $feeding = Feeding::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'ALIMENTACION: ' . $feeding->feeConcept,
            'conValue' => $feeding->feeValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'UNIFORME') {
          $uniform = Uniform::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'UNIFORME: ' . $uniform->uniConcept,
            'conValue' => $uniform->uniValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'MATERIAL') {
          $supplie = Supplie::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'MATERIAL ESCOLAR: ' . $supplie->supConcept,
            'conValue' => $supplie->supValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'TIEMPO EXTRA') {
          $extratime = Extratime::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'TIEMPO EXTRA: ' . $extratime->extTConcept,
            'conValue' => $extratime->extTValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'EXTRACURRICULAR') {
          $extracurricular = Extracurricular::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'EXTRACURRICULAR: ' . $extracurricular->extConcept . ' ' . $extracurricular->extIntensity,
            'conValue' => $extracurricular->extValue,
            'conLegalization_id' => $legalization->legId
          ]);
        } else if ($separatedIds[0] == 'TRANSPORTE') {
          $transport = Transport::find($separatedIds[1]);
          Concept::create([
            'conDate' => date('Y-m-d', strtotime($request->addDate . '+ 1 month')),
            'conConcept' => 'TRANSPORTE: ' . $transport->traConcept,
            'conValue' => $transport->traValue,
            'conLegalization_id' => $legalization->legId
          ]);
        }
      }
      //QUITAR EL ULTIMO GUION (-)
      $autorizedAll = substr($autorized, 0, (strlen($autorized) - 1));

      if ($autorizatedValidate == null) {
        Autorization::create([
          'auCourse_id' => trim($request->addCourse),
          'auStudent_id' => trim($request->addStudent),
          'auAttendant_id' => trim($request->addIdAttendant),
          'auDate' => trim($request->addDate),
          'auDescription' => trim($request->addDescription),
          'auAutorized' => trim($autorizedAll),
        ]);
        return redirect()->route('additionals')->with('SuccessSaveAdditional', 'Autorización de las novedades adicionales, Se ha procesado correctamente');
      } else {
        $autorizatedValidate->auAttendant_id = $request->addIdAttendant;
        $autorizatedValidate->auDescription = $request->addDescription;
        $autorizatedValidate->auAutorized = $autorizedAll;
        $autorizatedValidate->save();
        return redirect()->route('additionals')->with('SuccessSaveAdditional', 'Autorización de las novedades adicionales, Se ha sobreescrito correctamente');
      }
    } catch (Exception $ex) {
      return redirect()->route('additionals')->with('SuccessSaveAdditional', 'No es posible procesar autorizaciones ahora, Comuniquese con el administrador');
    }
  }
}
