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
      $legalization = Legalization::select('legId')->where([['legStudent_id', $request->addStudent],['legStatus','ACTIVO']])->first();
      $autorized = '';
      
      $separatedItems = explode('=', substr(trim($request->all_items), 0, -1));
      
      for ($i = 0; $i < count($separatedItems); $i++) {
        $separatedIds = explode(':', $separatedItems[$i]);
        $autorized .= $separatedItems[$i] . '-';
        if ($separatedIds[0] == 'ADMISION') {
          $admission = Admission::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'ADMISION: ' . $admission->admConcept;
          $concept->conValue = $admission->admValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'JORNADA') {
          $journey = Journey::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'JORNADA: ' . $journey->jouJourney;
          $concept->conValue = $journey->jouValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'ALIMENTACION') {
          $feeding = Feeding::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'ALIMENTACION: ' . $feeding->feeConcept;
          $concept->conValue = $feeding->feeValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'UNIFORME') {
          $uniform = Uniform::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'UNIFORME: ' . $uniform->uniConcept;
          $concept->conValue = $uniform->uniValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'MATERIAL') {
          $supplie = Supplie::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'MATERIAL ESCOLAR: ' . $supplie->supConcept;
          $concept->conValue = $supplie->supValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'TIEMPO EXTRA') {
          $extratime = Extratime::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'TIEMPO EXTRA: ' . $extratime->extTConcept;
          $concept->conValue = $extratime->extTValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'EXTRACURRICULAR') {
          $extracurricular = Extracurricular::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'EXTRACURRICULAR: ' . $extracurricular->extConcept . ' ' . $extracurricular->extIntensity;
          $concept->conValue = $extracurricular->extValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        } else if ($separatedIds[0] == 'TRANSPORTE') {
          $transport = Transport::find($separatedIds[1]);
          $concept = new Concept;
          $concept->conDate = date('Y-m-d', strtotime($request->addDate . '+ 1 month'));
          $concept->conConcept = 'TRANSPORTE: ' . $transport->traConcept;
          $concept->conValue = $transport->traValue;
          $concept->conLegalization_id = $legalization->legId;
          $concept->save();
        }
      }
      //QUITAR EL ULTIMO GUION (-)
      $autorizedAll = substr($autorized, 0, (strlen($autorized) - 1));
      
      if ($autorizatedValidate == null) {
        $autorization = new Autorization;
        $autorization->auCourse_id = trim($request->addCourse);
        $autorization->auStudent_id = trim($request->addStudent);
        $autorization->auAttendant_id = trim($request->addIdAttendant);
        $autorization->auDate = trim($request->addDate);
        $autorization->auDescription = trim($request->addDescription);
        $autorization->auAutorized = trim($autorizedAll);
        $autorization->save();
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
