<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Entry;
use App\Models\Concept;
use App\Models\General;
use App\Models\Student;
use App\Models\Attendant;
use App\Models\Numeration;
use App\Models\Facturation;
use App\Models\Legalization;
use Illuminate\Http\Request;
use App\Models\Coststructure;
use App\Models\Costdescription;
use App\Exports\ReportcloseExcel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FacturationTramitedExcel;


class AccountsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function accountsTo()
  {
    return view('modules.accounts.index');
  }

  public function getAccount(Request $request)
  {
    /** SE CONSULTAN LAS LEGALIZACIONES ACTIVAS **/
    $accounts = Legalization::with(
      'student:id,firstname,threename,fourname',
      'father:id,firstname,threename',
      'mother:id,firstname,threename',
      'grade:id,name',
      'journey',
      'concept'
    )->where('legStatus', 'ACTIVO') // Se corrige el uso de where
      ->whereHas('concept', function ($query) use ($request) {
        $query->where('conStatus', 'PENDIENTE') // Se corrige el uso de where
          ->whereBetween('conDate', [
            $request->year . "-" . $request->mount . "-01",
            $request->year . "-" . $request->mount . "-" . date('t', strtotime($request->year . '-' . $request->mount . '-15'))
          ]);
      })
      ->get();
    $datas = array();

    $temporal = "";
    /** SE RECORE TODAS LAS LEGALIZACIONES Y SE FILTRA POR MEDIO DEL ID EN LA VARIABLE TEMPORAL PARA ELIMINAR DUPLICADOS **/
    foreach ($accounts as $key => $account) {
      if ($account->legStudent_id != $temporal) {
        array_push($datas, [
          optional($account)->legId,
          optional($account->student)->id,
          optional($account->student)->firstname . " " . optional($account->student)->threename . " " . optional($account->student)->fourname,
          optional($account->grade)->name,
          // $account->nameCourse,
          optional($account->father)->firstname . " " . optional($account->father)->threename . "</br>" . optional($account->mother)->firstname . " " . optional($account->mother)->threename
        ]);
      }
    }
    return $datas;
  }

  function getItemsConcepts(Request $request)
  {
    $legalization = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'grades.name as nameGrade' // ,
      // 'courses.name as nameCourse'
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      // ->join('courses','courses.id','legalizations.legCourse_id')
      ->where('legId', trim($request->legId))->first();
    $father = Attendant::find($legalization->legAttendantfather_id);
    $mother = Attendant::find($legalization->legAttendantmother_id);
    $concepts = Concept::where([['conLegalization_id', trim($request->legId)], ['conStatus', 'PENDIENTE']])->whereBetween('conDate', [$request->year . "-" . $request->mount . "-01", $request->year . "-" . $request->mount . "-" . date('t', strtotime($request->year . '-' . $request->mount . '-15'))])->get();
    $dates = array();

    if (isset($father) && isset($mother)) {
      array_push($dates, [
        'DATOS',
        $legalization->nameStudent,
        $legalization->nameGrade, // . ' - ' . $legalization->nameCourse,
        $father->firstname . ' ' . $father->threename,
        $mother->firstname . ' ' . $mother->threename,
        $father->emailone . ' - ' . $mother->emailone,
        $father->phoneone . ' - ' . $mother->phoneone,
        $legalization->legDateCreate,
        $legalization->legDateInitial,
        $legalization->legDateFinal
      ]);
    } else if (isset($father)) {
      array_push($dates, [
        'DATOS',
        $legalization->nameStudent,
        $legalization->nameGrade, // . ' - ' . $legalization->nameCourse,
        $father->firstname . ' ' . $father->threename,
        'Acudiente 2: Sin registro',
        $father->emailone,
        $father->phoneone,
        $legalization->legDateCreate,
        $legalization->legDateInitial,
        $legalization->legDateFinal
      ]);
    } else if (isset($mother)) {
      array_push($dates, [
        'DATOS',
        $legalization->nameStudent,
        $legalization->nameGrade, // . ' - ' . $legalization->nameCourse,
        'Acudiente 1: Sin registro',
        $mother->firstname . ' ' . $mother->threename,
        $mother->emailone,
        $mother->phoneone,
        $legalization->legDateCreate,
        $legalization->legDateInitial,
        $legalization->legDateFinal
      ]);
    }

    foreach ($concepts as $concept) {
      array_push($dates, [
        'CONCEPTO',
        $concept->conId,
        $concept->conConcept,
        $concept->conDate,
        $concept->conValue,
        $concept->conStatus,
      ]);
    }
    return response()->json($dates);
  }

  function getFormFacture(Request $request)
  {
    // DATOS DE LA LEGALIZACION
    $legalization = Legalization::find($request->legId);
    // DATOS DEL ESTUDIANTE
    $student = Student::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'students.numberdocument',
      'documents.type'
    )
      ->join('documents', 'documents.id', 'students.typedocument_id')
      ->where('students.id', $legalization->legStudent_id)->first();
    // DATOS DEL PADRE
    $father = Attendant::select(
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameFather"),
      'attendants.numberdocument',
      'documents.type'
    )
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->where('attendants.id', $legalization->legAttendantfather_id)->first();
    // DATOS DE LA MADRE
    $mother = Attendant::select(
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameMother"),
      'attendants.numberdocument',
      'documents.type'
    )
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->where('attendants.id', $legalization->legAttendantmother_id)->first();
    // TOMAR EL PREFIJO DE LA INFORMACION GENERAL
    $prefix = General::select('fgPrefix')->first();
    // NUMERO INICIAL DE LA FACTURACION
    $numeration = Numeration::select('niFacture')->first();

    if (isset($prefix->fgPrefix)) {
      // CONSULTAR SI EXISTE NUMERO INICIAL DE FACTURACION EN LAS FACTURAS EXISTENTES
      $validatefacture = Facturation::select('facCode')->where('facCode', $prefix->fgPrefix . $numeration->niFacture)->first();
      // SI EXISTE EL NUMERO ENTONCES CONSULTAR EL NUMERO MAYOR DE LAS FACTURAS EXISTENTES Y SUMARLE UNO PARA LA NUEVA FACTURA
      if ($validatefacture != null) {
        $codeLastfacture = filter_var(Facturation::max('facCode'), FILTER_SANITIZE_NUMBER_INT); // CODIGO DE ULTIMA FACTURA
        while (Facturation::where('facCode', $prefix->fgPrefix . $codeLastfacture)->count() > 0) {
          $codeLastfacture++;
        }
        $newCodeFacture = $prefix->fgPrefix . $codeLastfacture;
        Numeration::updated(['niFacture' => $codeLastfacture]);
      } else { //SI NO EXISTE EL NUMERO INICIAL ENTONCES SE USA PARA LA NUEVA FACTURA
        $newCodeFacture = $prefix->fgPrefix . $numeration->niFacture;
      }
    } else {
      if (isset($numeration->niFacture)) {
        // CONSULTAR SI EXISTE NUMERO INICIAL DE FACTURACION EN LAS FACTURAS EXISTENTES
        $validatefacture = Facturation::select('facCode')->where('facCode', $numeration->niFacture)->first();
        // SI EXISTE EL NUMERO ENTONCES CONSULTAR EL NUMERO MAYOR DE LAS FACTURAS EXISTENTES Y SUMARLE UNO PARA LA NUEVA FACTURA
        if ($validatefacture != null) {
          $codeLastfacture = filter_var(Facturation::max('facCode'), FILTER_SANITIZE_NUMBER_INT); // CODIGO DE ULTIMA FACTURA
          while (Facturation::where('facCode', $prefix->fgPrefix . $codeLastfacture)->count() > 0) {
            $codeLastfacture++;
          }
          Numeration::updated(['niFacture' => $codeLastfacture]);
        } else { //SI NO EXISTE EL NUMERO INICIAL ENTONCES SE USA PARA LA NUEVA FACTURA
          $newCodeFacture = $numeration->niFacture;
        }
      } else {
        return response()->json('SIN NUMERACION DE FACTURA');
      }
    }

    $datesFacture = array();

    if ($father != null) {
      array_push($datesFacture, [
        'ALUMNO',
        $student->nameStudent,
        $student->type,
        $student->numberdocument
      ]);
    }
    if ($father != null) {
      array_push($datesFacture, [
        'PADRE',
        $father->nameFather,
        $father->type,
        $father->numberdocument
      ]);
    }
    if ($mother != null) {
      array_push($datesFacture, [
        'MADRE',
        $mother->nameMother,
        $mother->type,
        $mother->numberdocument
      ]);
    }

    $datenow = Date('Y-m-d');
    $total = 0;
    $totalConcepts = 0;
    $ids = explode(':', $request->ids);
    for ($i = 0; $i < count($ids); $i++) {
      $concept = Concept::find($ids[$i]);
      array_push($datesFacture, [
        'CONCEPTO',
        $concept->conDate,
        $concept->conConcept,
        $concept->conValue,
        $concept->conStatus
      ]);
      $totalConcepts++;
      $total = $total + $concept->conValue;
    }
    array_push($datesFacture, [
      'FACTURA',
      $newCodeFacture,
      $datenow,
      $total,
      $legalization->legId,
    ]);
    array_push($datesFacture, [
      'TOTAL',
      $totalConcepts,
      $request->ids
    ]);

    $appName = config('app.name');
    array_push($datesFacture, $appName);

    return response()->json($datesFacture);
  }

  function getFacturationtramited(Request $request)
  {
    return Excel::download(new FacturationTramitedExcel(trim($request->xlsYear), trim($request->xlsMount)), 'Facturación tramitada_' . trim($request->xlsYear) . '_' . trim($request->xlsMount) . '.xlsx');
  }

  function getFacturationtramitedcount(Request $request)
  {
    $tramited = Facturation::select(
      'facturations.*',
      'legalizations.legId',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->whereBetween('facDateInitial', [trim($request->xlsYear) . "-" . trim($request->xlsMount) . "-01", trim($request->xlsYear) . "-" . trim($request->xlsMount) . "-" . Carbon::now()->day])
      ->where('facStatus', 'PAGADO')->orderBy('facId', 'ASC')->get();
    $entry = Entry::whereBetween('venDate', [trim($request->xlsYear) . "-" . trim($request->xlsMount) . "-01", trim($request->xlsYear) . "-" . trim($request->xlsMount) . "-" . Carbon::now()->day])->get();
    $total = 0;
    foreach ($entry as $e) {
      $total += $e->venPaid;
    }
    return response()->json($total);
  }

  function getMountString($mount)
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

  /*====================================================*/

  // METODOS DE ITEM ANALISIS DE PRESUPUESTO \\

  /*====================================================*/

  function coststructureTo()
  {
    $structure = Coststructure::all();
    return view('modules.analysis.costStructure', compact('structure'));
  }

  function newCoststructure(Request $request)
  {
    try {
      $validateStructure = Coststructure::where('csDescription', mb_strtoupper(trim($request->costStructure_new)))->first();
      if ($validateStructure == null) {
        Coststructure::create([
          'csDescription' => mb_strtoupper(trim($request->costStructure_new))
        ]);
        return redirect()->route('analysis.structure')->with('SuccessCreateStructure', 'SE HA CREADO EL REGISTRO DE ESTRUCTURA DE COSTO CORRECTAMENTE');
      } else {
        return redirect()->route('analysis.structure')->with('SecondaryCreateStructure', 'YA EXISTE UNA DESCRIPCION IGUAL, NO ES POSIBLE GUARDAR LA MISMA INFORMACION');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.structure')->with('SecondaryCreateStructure', 'PROCESO INTERUMPIDO, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  function editCoststructure(Request $request)
  {
    try {
      $validateStructure = Coststructure::find(trim($request->costStructure_id_edit));
      if ($validateStructure != null) {
        $validateStructure->csDescription = mb_strtoupper(trim($request->costStructure_edit));
        $validateStructure->save();
        return redirect()->route('analysis.structure')->with('PrimaryUpdateStructure', 'SE HA ACTUALIZADO EL REGISTRO DE ESTRUCTURA DE COSTO CORRECTAMENTE');
      } else {
        return redirect()->route('analysis.structure')->with('SecondaryUpdateStructure', 'NO ES POSIBLE ACTUALIZAR EL REGISTRO AHORA, INTENTELO MAS TARDE');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.structure')->with('SecondaryUpdateStructure', 'PROCESO INTERUMPIDO, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  function deleteCoststructure(Request $request)
  {
    try {
      $validateStructure = Coststructure::find(trim($request->costStructure_id_delete));
      if ($validateStructure != null) {
        $id = $validateStructure->csId;
        $costDescriptions = Costdescription::where('cdCoststructure_id', $id)->get();
        $count = 0;
        foreach ($costDescriptions as $description) {
          $description->delete();
          $count++;
        }
        $validateStructure->delete();
        if ($count > 0) {
          return redirect()->route('analysis.structure')->with('WarningDeleteStructure', "SE HA ELIMINADO EL REGISTRO CON ID " . $id . " DE ESTRUCTURA DE COSTO CORRECTAMENTE, JUNTO A " . $count . " DESCRIPCIONES RELACIONADAS");
        } else {
          return redirect()->route('analysis.structure')->with('WarningDeleteStructure', "SE HA ELIMINADO EL REGISTRO CON ID " . $id . " DE ESTRUCTURA DE COSTO CORRECTAMENTE, SIN NINGUNA RELACION");
        }
      } else {
        return redirect()->route('analysis.structure')->with('SecondaryDeleteStructure', 'NO ES POSIBLE ELIMINAR EL REGISTRO AHORA, INTENTELO MAS TARDE');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.structure')->with('SecondaryDeleteStructure', 'PROCESO INTERUMPIDO, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  function costdescriptionTo()
  {
    $structures = Coststructure::all();
    $descriptions = Costdescription::all();
    $dates = array();
    foreach ($descriptions as $description) {
      $structure = Coststructure::find($description->cdCoststructure_id);
      if ($structure != null) {
        array_push($dates, [
          $description->cdId,
          $description->cdDescription,
          $structure->csId,
          $structure->csDescription
        ]);
      } else {
        array_push($dates, [
          $description->cdId,
          $description->cdDescription,
          'N/A',
          'SIN ESTRUCTURA DE COSTO RELACIONADA'
        ]);
      }
    }
    return view('modules.analysis.costDescription', compact('dates', 'structures'));
  }

  function newCostdescription(Request $request)
  {
    try {
      $validateDescription = Costdescription::where('cdDescription', mb_strtoupper(trim($request->costDescription_new)))->where('cdCoststructure_id', trim($request->costStructure_id_new))->first();
      if ($validateDescription == null) {
        Costdescription::create([
          'cdDescription' => mb_strtoupper(trim($request->costDescription_new)),
          'cdCoststructure_id' => trim($request->costStructure_id_new)
        ]);
        return redirect()->route('analysis.description')->with('SuccessCreateDescription', 'SE HA CREADO EL REGISTRO, DESCRIPCION DE COSTO CORRECTAMENTE');
      } else {
        return redirect()->route('analysis.description')->with('SecondaryCreateDescription', 'YA EXISTE UNA DESCRIPCION IGUAL, NO ES POSIBLE GUARDAR LA MISMA INFORMACION');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.description')->with('SecondaryCreateDescription', 'PROCESO INTERUMPIDO, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  function editCostdescription(Request $request)
  {
    try {
      $validateDescription = Costdescription::find(trim($request->costDescription_id_edit));
      if ($validateDescription != null) {
        $validateDescription->cdDescription = mb_strtoupper(trim($request->costDescription_edit));
        $validateDescription->cdCoststructure_id = trim($request->costStructure_id_edit);
        $validateDescription->save();
        return redirect()->route('analysis.description')->with('PrimaryUpdateDescription', 'SE HA ACTUALIZADO EL REGISTRO, DESCRIPCION DE COSTO CORRECTAMENTE');
      } else {
        return redirect()->route('analysis.description')->with('SecondaryUpdateDescription', 'NO ES POSIBLE ACTUALIZAR EL REGISTRO NO ENCONTRADO');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.description')->with('SecondaryUpdateDescription', 'PROCESO INTERUMPIDO, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  function deleteCostdescription(Request $request)
  {
    try {
      $validateDescription = Costdescription::find(trim($request->costDescription_id_delete));
      if ($validateDescription != null) {
        $id = $validateDescription->cdId;
        $validateDescription->delete();
        return redirect()->route('analysis.description')->with('WarningDeleteDescription', "SE HA ELIMINADO EL REGISTRO CON ID " . $id . " DE DESCRIPCION DE COSTO CORRECTAMENTE");
      } else {
        return redirect()->route('analysis.description')->with('SecondaryDeleteDescription', 'NO SE ENCUENTRA EL REGISTRO, INTENTELO MAS TARDE');
      }
    } catch (Exception $ex) {
      return redirect()->route('analysis.description')->with('SecondaryDeleteDescription', 'PROCESO INTERUMPIDO, COMUNIQUEE CON EL ADMINISTRADOR');
    }
  }

  function followMountTo()
  {
    $structures = Coststructure::all();
    return view('modules.analysis.follow', compact('structures'));
  }

  function reportCloseTo()
  {
    return view('modules.analysis.report');
  }

  function getReportcloseExcel(Request $request)
  {
    return Excel::download(new ReportcloseExcel(trim($request->rYear)), 'Presupuesto ' . trim($request->rYear) . '.xlsx');
  }

  /*====================================================*/

  // ## METODOS DE ITEM ANALISIS DE PRESUPUESTO ## \\

  /*====================================================*/
}
