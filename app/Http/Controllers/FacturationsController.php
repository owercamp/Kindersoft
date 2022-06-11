<?php

namespace App\Http\Controllers;

use App\Mail\MessageFactureGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\Course;
use App\Models\Listcourse;
use App\Models\CourseConsolidated;
use App\Models\Facturation;

use App\Models\Wallet;
use App\Models\Entry;

use App\Models\Legalization;
use App\Models\Autorization;
use App\Models\Concept;
use App\Models\General;
use App\Models\Attendant;

use App\Models\Garden;
use App\Models\Pay;
use App\Models\User;
use App\Models\Collaborator;
use App\Models\Numeration;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FacturationsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function facturationTo(Request $request)
  {
    // dd($request->all());
    $all = $request->all();
    // dd($all);
    // $students = Student::select(
    //         'students.id',
    //         DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    //     )->get();
    // $courses = Course::all();
    // return view('modules.facturations.index', compact('students','courses'));
    return view('modules.facturations.index', compact('all'));
  }

  function newFacturation(Request $request)
  {
    try {
      $validateFacturation = Facturation::where('facCode', trim($request->facCode))->first();

      if ($validateFacturation == null) {
        $dateInitial = Date('Y-m-d');
        switch (trim($request->facDateFinal)) {
          case '':
            $dateFinal = Date('Y-m-d');
            break;
          case '1':
            $dateFinal = Date('Y-m-d', strtotime(' + 1 days'));
            break;
          case '2':
            $dateFinal = Date('Y-m-d', strtotime(' + 2 days'));
            break;
          case '3':
            $dateFinal = Date('Y-m-d', strtotime(' + 3 days'));
            break;
          case '4':
            $dateFinal = Date('Y-m-d', strtotime(' + 4 days'));
            break;
          case '5':
            $dateFinal = Date('Y-m-d', strtotime(' + 5 days'));
            break;
          case '6':
            $dateFinal = Date('Y-m-d', strtotime(' + 6 days'));
            break;
          case '7':
            $dateFinal = Date('Y-m-d', strtotime(' + 7 days'));
            break;
          case '8':
            $dateFinal = Date('Y-m-d', strtotime(' + 8 days'));
            break;
          case '9':
            $dateFinal = Date('Y-m-d', strtotime(' + 9 days'));
            break;
          case '30':
            $dateFinal = Date('Y-m-d', strtotime(' + 30 days'));
            break;
          default:
            $dateFinal = Date('Y-m-d');
            break;
        }

        // CREAR LA FACTURA EN ESTADO POR DEFECTO 'EN REVISION'
        Facturation::create([
          'facCode' => trim($request->facCode),
          'facDateInitial' => $dateInitial,
          'facDateFinal' => $dateFinal,
          'facValue' => trim($request->facSubtotal),
          'facValueCopy' => trim($request->facValueIva),
          'facLegalization_id' => trim($request->facLegalization_id),
          'facConcepts' => trim($request->facConcepts),
          'facPorcentageIva' => trim($request->facPorcentageIva),
          'facValuediscount' => trim($request->facValuediscount),
          'facValueIva' => trim($request->facValueIva)
        ]);

        $ids = explode(':', $request->facConcepts);
        for ($i = 0; $i < count($ids); $i++) {
          $concept = Concept::find($ids[$i]);
          $concept->conStatus = 'FACTURADO';
          $concept->save();
        }
        
        $split = substr($request->facCode,1,1);
        $nextnumber = \mb_split($split, $request->facCode);
        $numb = $nextnumber[1];
        $facture = Numeration::where('niId','>', 0)->first();
        $newVal = \intval($numb) + 1;
        
        if ($newVal != null) {
          $facture->niFacture = $newVal;
          $facture->save();
        }
          
        return response()->json(['success' => "SE HA GENERADO LA FACTURA: " . trim($request->facCode) . " CORRECTAMENTE, CONSULTE EN LA OPCION GESTION DE CARTERA"]);
      } else {
        return response()->json("POR FAVOR VUELVA A INTENTARLO: HUBO UNA COINCIDENCIA DE FACTURA YA EXISTENTE");
      }
    } catch (Exception $ex) {
      //Code in case error
    }
  }

  public function allFacturation()
  {
    $allFacturations = Facturation::select(
      'legalizations.legId',
      'legalizations.legAttendantmother_id',
      'legalizations.legAttendantfather_id',
      'facturations.facId',
      'facturations.facCode',
      'facturations.facDateFinal',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'facturations.facValueIva'
    )
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
      ->where('facturations.facStatus', 'EN REVISION')
      ->orWhere('facturations.facStatus', 'PAGO PARCIAL')
      ->get();
    $allDates = array();

    foreach ($allFacturations as $key => $facturation) {
      array_push($allDates, [
        $facturation->legId,
        $facturation->facId,
        $facturation->facCode,
        $facturation->facDateFinal,
        $facturation->nameStudent,
        $facturation->facValueIva
      ]);
    }
    $students = Student::all();
    $courses = Course::all();
    // dd($allDates);
    return view('modules.facturations.all', compact('allDates', 'courses', 'students'));
  }

  public function editFacturation(Request $request)
  {
    // dd($request->all());
    /*
            $request->facValuediscountnew_edit
            $request->facDateInitialnew_edit
            $request->facDateFinalnew_edit
            $request->facId_edit
        */
    $validate = Facturation::find(trim($request->facId_edit));
    if ($validate != null) {
      $code = $validate->facCode;
      $dateInitial = Date('Y-m-d', strtotime(trim($request->facDateInitialnew_edit)));
      $dateFinal = Date('Y-m-d', strtotime(trim($request->facDateFinalnew_edit)));
      $valueTotal = $validate->facValueIva - (int)trim($request->facValuediscountnew_edit);
      $validate->facValuediscount = trim($request->facValuediscountnew_edit);
      $validate->facDateInitial = $dateInitial;
      $validate->facDateFinal = $dateFinal;
      $validate->facValueIva = $valueTotal;
      $validate->save();
      return redirect()->route('facturation.all')->with('PrimaryUpdateFacturation', 'Factura ' . $code . ', actualizada');
    } else {
      return redirect()->route('facturation.all')->with('SecondaryUpdateFacturation', 'No se encuentra la factura');
    }
  }

  public function pdfFacturationEmail(Request $request)
  {

    $facture = array(); // DONDE SE GUARDA TODA LA INFORMACIÖN QUE SE MUESTRA EN EL PDF
    $facturation = Facturation::select(
      'facturations.*', // facCode, facDateInitial, facFateFinal, facValue, facLegalization_id, facConcepts, facStatus
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'citys.name as nameCity'
    )
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('citys', 'citys.id', 'students.cityhome_id')
      ->where('facId', $request->facId)
      ->first();
    $garden = Garden::select('garden.*', 'citys.name as nameCity', 'locations.name as nameLocation')
      ->join('citys', 'citys.id', 'garden.garCity_id')
      ->join('locations', 'locations.id', 'garden.garLocation_id')
      ->first();
    array_push($facture, [
      'SECTION ONE',
      $facturation->facCode,
      $facturation->facDateInitial,
      $facturation->facDateFinal,
      $garden->garReasonsocial,
      $garden->garNamerepresentative,
      $garden->garNit,
      $garden->garAddress,
      $garden->nameCity,
      $garden->nameLocation,
      $garden->garMailone,
      $garden->garPhone
    ]);

    $general = General::first();
    $father = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameFather"),
      'documents.type',
      'attendants.numberdocument',
      'attendants.address',
      'attendants.emailone',
      'citys.name as city'
    )
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->join('citys', 'citys.id', 'attendants.cityhome_id')
      ->where('legId', $request->legId)->first();
    $mother = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameMother"),
      'documents.type',
      'attendants.numberdocument',
      'attendants.address',
      'attendants.emailone',
      'citys.name as city'
    )
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantmother_id')
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->join('citys', 'citys.id', 'attendants.cityhome_id')
      ->where('legId', $request->legId)->first();
    $student = Legalization::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'documents.type',
      'students.numberdocument',
      'grades.name as grade'
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('documents', 'documents.id', 'students.typedocument_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      ->where('legId', $request->legId)->first();
    // $user = User::select('collaborators.firm', 'collaborators.position')->join('collaborators', 'collaborators.id', 'users.collaborator_id')->where('users.id', auth()->id())->first();
    $user = User::find(auth()->id());
    $firm = 'N/A';
    if ($user->id != 0 and $user->id != "1024500065" and $user->id != "80503717") {
      $firm = Collaborator::where('numberdocument', $user->id)->first();
      if (!$firm) {
        return back()->with('WarningUpdateFacturation', 'Este usuario no se encuentra registrado como colaborador');
      }
    }
    if ($firm != 'N/A') {
      if ($father != null && $mother != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          $mother->nameMother . ' ' . $mother->numberdocument,
          $father->type  . ' - ' . $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else if ($mother != null && $father == null) {
        array_push($facture, [
          'SECTION TWO',
          '',
          $mother->nameMother . ' ' . $mother->numberdocument,
          $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $mother->address,
          $mother->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else if ($mother == null && $father != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          '',
          $father->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else {
        array_push($facture, [
          'SECTION TWO',
          '',
          '',
          '',
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          '',
          '',
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      }
    } else {
      if ($father != null && $mother != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          $mother->nameMother . ' ' . $mother->numberdocument,
          $father->type  . ' - ' . $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else if ($mother != null && $father == null) {
        array_push($facture, [
          'SECTION TWO',
          '',
          $mother->nameMother . ' ' . $mother->numberdocument,
          $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $mother->address,
          $mother->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else if ($mother == null && $father != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          '',
          $father->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else {
        array_push($facture, [
          'SECTION TWO',
          '',
          '',
          '',
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          '',
          '',
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      }
    }
    $totalAbsolut = 0;
    $totalAbsolutNotIva = 0;
    $totalAbsolutOnlyIva = 0;
    $separatedConcepts = explode(':', $facturation->facConcepts);
    for ($i = 0; $i < count($separatedConcepts); $i++) {
      $concept = Concept::find($separatedConcepts[$i]); // conId, conDate, conConcept, conValue, conStatus, conLegalization_id
      // var value = $(this).find('td:last').text();
      $resultTotalWithIva = ($facturation->facPorcentageIva * $concept->conValue) / 100 + $concept->conValue;
      $resultOnlyIva = ($facturation->facPorcentageIva * $concept->conValue) / 100;

      array_push($facture, [
        'CONCEPTOS',
        $concept->conId,
        $concept->conConcept,
        $concept->conValue,
        $resultOnlyIva,
        $resultTotalWithIva,
        $facturation->facPorcentageIva
      ]);
      $totalAbsolut += $resultTotalWithIva;
      $totalAbsolutNotIva += $concept->conValue;
      $totalAbsolutOnlyIva += ($facturation->facPorcentageIva * $concept->conValue) / 100;
    }
    $iva = $facturation->facPorcentageIva;
    $discount = $facturation->facValuediscount;
    $totalAbsolutOnlyIva = ($iva * $facturation->facValue) / 100;
    $totalAbsolutNotIva = $facturation->facValue - $facturation->facValuediscount;
    $totalAbsolut = $totalAbsolutNotIva + $totalAbsolutOnlyIva;

    $pdf = App::make('dompdf.wrapper');
    $namefile = 'FACTURA_' . $facture[0][1] . ', ' . $facture[1][4] . '.pdf';
    $pdf->loadView('modules.facturations.facturePdf', compact('facture', 'garden', 'totalAbsolut', 'totalAbsolutNotIva', 'iva', 'totalAbsolutOnlyIva', 'discount'));
    $pdfOutput = $pdf->output();

    $mydate = $facturation->facDateFinal;
    $separatedDate = \mb_split("-", $mydate);
    $month = $separatedDate[1];
    $year = $separatedDate[0];
    $day = $separatedDate[2];

    switch ($month) {
      case '01':
        $dateFinal = $day . ' de Enero de ' . $year;
        break;
      case '02':
        $dateFinal = $day . ' de Febrero de ' . $year;
        break;
      case '03':
        $dateFinal = $day . ' de Marzo de ' . $year;
        break;
      case '04':
        $dateFinal = $day . ' de Abril de ' . $year;
        break;
      case '05':
        $dateFinal = $day . ' de Mayo de ' . $year;
        break;
      case '06':
        $dateFinal = $day . ' de Junio de ' . $year;
        break;
      case '07':
        $dateFinal = $day . ' de Julio de ' . $year;
        break;
      case '08':
        $dateFinal = $day . ' de Agosto de ' . $year;
        break;
      case '09':
        $dateFinal = $day . ' de Septiembre de ' . $year;
        break;
      case '10':
        $dateFinal = $day . ' de Octubre de ' . $year;
        break;
      case '11':
        $dateFinal = $day . ' de Noviembre de ' . $year;
        break;
      case '12':
        $dateFinal = $day . ' de Diciembre de ' . $year;
        break;
    }

    $nameFat = $father->nameFather;
    $nameMot = $mother->nameMother;
    $code = $facturation->facCode;
    $val = $totalAbsolut;
    $subjects = "ORDEN DE PAGO - " . Str::upper(config('app.name'));
    $countData = General::select('fgAccounttype','fgBank','fgNumberaccount')->first();

    $garden = Garden::select('garReasonsocial','garNit')->first();

    // $recipients = [$father->emailone, $mother->emailone];
    $recipients = ["owerion22@gmail.com", "tyson01b_e413j@hxsni.com"];

    Mail::to($recipients)->send(new MessageFactureGenerate($code, $dateFinal, $nameFat, $nameMot, $val, $pdfOutput, $namefile, $subjects, $countData, $garden));

    return redirect()->route('facturation.all')->with('SuccessSaveEntry', "Correo enviado al Sr " . Str::ucfirst($nameFat) . " y la Sra " . Str::ucfirst($nameMot) . " con factura adjunta");
  }

  public function pdfFacturation(Request $request)
  {
    // dd($request->all());
    /*
            $request->legId;
            $request->facId;
            */
    $facture = array(); // DONDE SE GUARDA TODA LA INFORMACIÖN QUE SE MUESTRA EN EL PDF
    $facturation = Facturation::select(
      'facturations.*', // facCode, facDateInitial, facFateFinal, facValue, facLegalization_id, facConcepts, facStatus
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'citys.name as nameCity'
    )
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('citys', 'citys.id', 'students.cityhome_id')
      ->where('facId', $request->facId)
      ->first();
    $garden = Garden::select('garden.*', 'citys.name as nameCity', 'locations.name as nameLocation')
      ->join('citys', 'citys.id', 'garden.garCity_id')
      ->join('locations', 'locations.id', 'garden.garLocation_id')
      ->first();
    array_push($facture, [
      'SECTION ONE',
      $facturation->facCode,
      $facturation->facDateInitial,
      $facturation->facDateFinal,
      $garden->garReasonsocial,
      $garden->garNamerepresentative,
      $garden->garNit,
      $garden->garAddress,
      $garden->nameCity,
      $garden->nameLocation,
      $garden->garMailone,
      $garden->garPhone
    ]);

    /*
                $facture[0][1] //NUMERO DE FACTURA
                $facture[0][2] //FECHA DE EMISION
                $facture[0][3] //FECHA DE VENCIMIENTO
                $facture[0][4] //NOMBRE JARDIN
                $facture[0][5] //NOMBRE DE REPRESENTANTE
                $facture[0][6] //NIT DE JARDIN
                $facture[0][7] //DIRECCION DE JARDIN
                $facture[0][8] //CIUDAD DE JARDIN
                $facture[0][9] //CORREO DE JARDIN
                $facture[0][10] //TELEFONO DE JARDIN
            */
    $general = General::first();
    $father = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameFather"),
      'documents.type',
      'attendants.numberdocument',
      'attendants.address',
      'citys.name as city'
    )
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->join('citys', 'citys.id', 'attendants.cityhome_id')
      ->where('legId', $request->legId)->first();
    $mother = Legalization::select(
      'legalizations.*',
      DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameMother"),
      'documents.type',
      'attendants.numberdocument',
      'attendants.address',
      'citys.name as city'
    )
      ->join('attendants', 'attendants.id', 'legalizations.legAttendantmother_id')
      ->join('documents', 'documents.id', 'attendants.typedocument_id')
      ->join('citys', 'citys.id', 'attendants.cityhome_id')
      ->where('legId', $request->legId)->first();
    $student = Legalization::select(
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      'documents.type',
      'students.numberdocument',
      'grades.name as grade'
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->join('documents', 'documents.id', 'students.typedocument_id')
      ->join('grades', 'grades.id', 'legalizations.legGrade_id')
      ->where('legId', $request->legId)->first();
    // $user = User::select('collaborators.firm', 'collaborators.position')->join('collaborators', 'collaborators.id', 'users.collaborator_id')->where('users.id', auth()->id())->first();
    $user = User::find(auth()->id());
    $firm = 'N/A';
    if ($user->id != 0 and $user->id != "1024500065" and $user->id != "80503717") {
      $firm = Collaborator::where('numberdocument', $user->id)->first();
      if (!$firm) {
        return back()->with('WarningUpdateFacturation', 'Este usuario no se encuentra registrado como colaborador');
      }
    }
    /*
                array_push($facture, [
                    'SECTION TWO',
                    '',
                    '',
                    '',
                    $student->nameStudent,
                    $student->type,
                    $student->numberdocument,
                    $student->grade,
                    '',
                    '',
                    $general->fgRegime,
                    $general->fgTaxpayer,
                    $general->fgAutoretainer,
                    $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
                    $general->fgResolution,
                    $general->fgDateresolution,
                    $general->fgNumerationsince,
                    $general->fgNumerationuntil,
                    $general->fgBank,
                    $general->fgAccounttype,
                    $general->fgNumberaccount,
                    $general->fgNotes,
                    $firm->firm,
                    $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
                    $firm->position
                ]);
            */
    if ($firm != 'N/A') {
      if ($father != null && $mother != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          $mother->nameMother . ' ' . $mother->numberdocument,
          $father->type  . ' - ' . $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else if ($mother != null && $father == null) {
        array_push($facture, [
          'SECTION TWO',
          '',
          $mother->nameMother . ' ' . $mother->numberdocument,
          $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $mother->address,
          $mother->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else if ($mother == null && $father != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          '',
          $father->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      } else {
        array_push($facture, [
          'SECTION TWO',
          '',
          '',
          '',
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          '',
          '',
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm->firm,
          $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
          $firm->position
        ]);
      }
    } else {
      if ($father != null && $mother != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          $mother->nameMother . ' ' . $mother->numberdocument,
          $father->type  . ' - ' . $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else if ($mother != null && $father == null) {
        array_push($facture, [
          'SECTION TWO',
          '',
          $mother->nameMother . ' ' . $mother->numberdocument,
          $mother->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $mother->address,
          $mother->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else if ($mother == null && $father != null) {
        array_push($facture, [
          'SECTION TWO',
          $father->nameFather . ' ' . $father->numberdocument,
          '',
          $father->type,
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          $father->address,
          $father->city,
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      } else {
        array_push($facture, [
          'SECTION TWO',
          '',
          '',
          '',
          $student->nameStudent,
          $student->type,
          $student->numberdocument,
          $student->grade,
          '',
          '',
          $general->fgRegime,
          $general->fgTaxpayer,
          $general->fgAutoretainer,
          $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
          $general->fgResolution,
          $general->fgDateresolution,
          $general->fgNumerationsince,
          $general->fgNumerationuntil,
          $general->fgBank,
          $general->fgAccounttype,
          $general->fgNumberaccount,
          $general->fgNotes,
          $firm
        ]);
      }
      // if($father != null){
      //     array_push($facture, [
      //         'SECTION TWO',
      //         $father->nameFather,
      //         $father->type,
      //         $father->numberdocument,
      //         $student->nameStudent,
      //         $student->type,
      //         $student->numberdocument,
      //         $student->grade,
      //         $father->address,
      //         $father->city,
      //         $general->fgRegime,
      //         $general->fgTaxpayer,
      //         $general->fgAutoretainer,
      //         $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
      //         $general->fgResolution,
      //         $general->fgDateresolution,
      //         $general->fgNumerationsince,
      //         $general->fgNumerationuntil,
      //         $general->fgBank,
      //         $general->fgAccounttype,
      //         $general->fgNumberaccount,
      //         $general->fgNotes,
      //         $firm
      //     ]);
      // }else if($mother != null){
      //     array_push($facture, [
      //         'SECTION TWO',
      //         $mother->nameMother,
      //         $mother->type,
      //         $mother->numberdocument,
      //         $student->nameStudent,
      //         $student->type,
      //         $student->numberdocument,
      //         $student->grade,
      //         $mother->address,
      //         $mother->city,
      //         $general->fgRegime,
      //         $general->fgTaxpayer,
      //         $general->fgAutoretainer,
      //         $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
      //         $general->fgResolution,
      //         $general->fgDateresolution,
      //         $general->fgNumerationsince,
      //         $general->fgNumerationuntil,
      //         $general->fgBank,
      //         $general->fgAccounttype,
      //         $general->fgNumberaccount,
      //         $general->fgNotes,
      //         $firm
      //     ]);
      // }else{
      //     array_push($facture, [
      //         'SECTION TWO',
      //         '',
      //         '',
      //         '',
      //         $student->nameStudent,
      //         $student->type,
      //         $student->numberdocument,
      //         $student->grade,
      //         '',
      //         '',
      //         $general->fgRegime,
      //         $general->fgTaxpayer,
      //         $general->fgAutoretainer,
      //         $general->fgActivityOne . '-' . $general->fgActivityTwo . '-' . $general->fgActivityThree . '-' . $general->fgActivityFour,
      //         $general->fgResolution,
      //         $general->fgDateresolution,
      //         $general->fgNumerationsince,
      //         $general->fgNumerationuntil,
      //         $general->fgBank,
      //         $general->fgAccounttype,
      //         $general->fgNumberaccount,
      //         $general->fgNotes,
      //         $firm
      //     ]);
      // }
    }
    $totalAbsolut = 0;
    $totalAbsolutNotIva = 0;
    $totalAbsolutOnlyIva = 0;
    $separatedConcepts = explode(':', $facturation->facConcepts);
    for ($i = 0; $i < count($separatedConcepts); $i++) {
      $concept = Concept::find($separatedConcepts[$i]); // conId, conDate, conConcept, conValue, conStatus, conLegalization_id
      // var value = $(this).find('td:last').text();
      $resultTotalWithIva = ($facturation->facPorcentageIva * $concept->conValue) / 100 + $concept->conValue;
      $resultOnlyIva = ($facturation->facPorcentageIva * $concept->conValue) / 100;


      // total += resultIva
      array_push($facture, [
        'CONCEPTOS',
        $concept->conId,
        $concept->conConcept,
        $concept->conValue,
        $resultOnlyIva,
        $resultTotalWithIva,
        $facturation->facPorcentageIva
      ]);
      $totalAbsolut += $resultTotalWithIva;
      $totalAbsolutNotIva += $concept->conValue;
      $totalAbsolutOnlyIva += ($facturation->facPorcentageIva * $concept->conValue) / 100;
    }
    $iva = $facturation->facPorcentageIva;
    $discount = $facturation->facValuediscount;
    $totalAbsolutOnlyIva = ($iva * $facturation->facValue) / 100;
    $totalAbsolutNotIva = $facturation->facValue - $facturation->facValuediscount;
    $totalAbsolut = $totalAbsolutNotIva + $totalAbsolutOnlyIva;

    $pdf = App::make('dompdf.wrapper');
    $namefile = 'FACTURA_' . $facture[0][1] . ', ' . $facture[1][4] . '.pdf';
    $pdf->loadView('modules.facturations.facturePdf', compact('facture', 'garden', 'totalAbsolut', 'totalAbsolutNotIva', 'iva', 'totalAbsolutOnlyIva', 'discount'));
    //$pdf->setPaper("A6", "landscape");
    // return $pdf->stream($namefile);
    return $pdf->download($namefile);
  }

  public function pdfFilter(Request $request)
  {
    try {
      //dd($request->all());
      /*
            REUQEST GET RECIBIDO:
            $request->optionFilterPdf //Si se ha filtrado por curso o estudiante
            $request->pdfCourse //Id del curso filtrado
            $request->pdfStudent //Id del estudiante filtrado
            */
      if ($request->optionFilterPdf == 'course') {
        $countStudent = Listcourse::where('listCourse_id', $request->pdfCourse)->count();

        $students = Listcourse::where('listCourse_id', $request->pdfCourse)->get();

        $initialDates = array();
        $allfacturations = array();
        foreach ($students as $student) {
          $basicDates = Legalization::select(
            'legalizations.legId',
            DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
            DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
            'wallets.*'
          )
            ->join('students', 'students.id', 'legalizations.legStudent_id')
            ->join('attendants', 'attendants.id', 'legalizations.legAttendant_id')
            ->join('wallets', 'wallets.waStudent_id', 'students.id')
            ->where('legalizations.legStudent_id', $student->listStudent_id)
            ->first();
          $countfacturations = Facturation::where('facturations.facLegalization_id', $basicDates->legId)->count();
          $facturations = Facturation::where('facturations.facLegalization_id', $basicDates->legId)->get();

          if ($countfacturations > 0) {
            $totalFactures = 0;
            foreach ($facturations as $facturation) {
              $totalFactures += $facturation->facValue;
            }
            array_push($initialDates, [
              $basicDates->legId,
              $basicDates->nameStudent,
              $basicDates->waMoney,
              $basicDates->waStatus,
              $basicDates->nameAttendant,
              $countfacturations,
              $totalFactures
            ]);
            //dd($initialDates);
            foreach ($facturations as $facturation) {
              $entrys = Entry::where('venFacturation_id', $facturation->facId)->get();
              $origin = '';

              foreach ($entrys as $entry) {
                if ($entry->venDescription != null || $entry->venDescription != '') {
                  if (end($entry)) {
                    $origin .= 'SALDO DE CARTERA ';
                  } else {
                    $origin .= 'SALDO EN CARTERA Y ';
                  }
                } else {
                  if (end($entry)) {
                    $origin .= 'CONSIGNACION-EFECTIVO ';
                  } else {
                    $origin .= 'CONSIGNACION-EFECTIVO Y ';
                  }
                }
              } //foreach entrys
              array_push($allfacturations, [
                $facturation->facLegalization_id,
                $facturation->facCode,
                $facturation->facValue,
                $facturation->facDateInitial,
                $facturation->facStatus,
                $origin
              ]);
              /*array_push($initialDates, [
                                [
                                    $basicDates->nameStudent,
                                    $basicDates->waMoney,
                                    $basicDates->waStatus,
                                    $basicDates->nameAttendant,
                                    $countfacturations,
                                    $totalFactures
                                ],
                                $facturation->facCode,
                                $facturation->facValue,
                                $facturation->facDateInitial,
                                $facturation->facStatus,
                                $origin
                            ]);*/
            } // close foreach facturations
          } else {
            array_push($initialDates, [
              $basicDates->legId,
              $basicDates->nameStudent,
              $basicDates->waMoney,
              $basicDates->waStatus,
              $basicDates->nameAttendant,
              '0',
              '$ 0'
            ]);
          } //end else
        } // close foreach students
        //dd($allDates);
        $datesfirst = CourseConsolidated::select(
          'courses.id AS idCourse',
          'courses.name AS nameCourse',
          'grades.id AS idGrade',
          'grades.name AS nameGrade',
          DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename) AS nameCollaborator")
        )
          ->join('courses', 'courses.id', 'coursesconsolidated.ccCourse_id')
          ->join('grades', 'grades.id', 'coursesconsolidated.ccGrade_id')
          ->join('collaborators', 'collaborators.id', 'coursesconsolidated.ccCollaborator_id')
          ->where('courses.id', $request->pdfCourse)->first();
        if ($datesfirst != null) {
          $countStudent = Listcourse::where('listCourse_id', $datesfirst->idCourse)
            ->where('listGrade_id', $datesfirst->idGrade)->count();
          $pdf = \App::make('dompdf.wrapper');
          $namefile = 'REPORTE_DE_CARTERA_DE_CURSO' . $datesfirst->nameCourse . '.pdf';
          $pdf->loadView('modules.facturations.reportCoursePdf', compact('datesfirst', 'countStudent', 'initialDates', 'allfacturations'));
          //$pdf->setPaper("A6", "landscape");
          return $pdf->download($namefile);
        } else {
          $course = Course::select('name')->where('id', trim($request->pdfCourse))->first();
          return redirect()->route('facturation.all')->with('WarningUpdateFacturation', 'No hay datos consolidados del curso ' . $course->name);
        }
      } else if ($request->optionFilterPdf == 'student') {
        $datehead = Legalization::select(
          'courses.name AS nameCourse',
          'courses.id AS idCourse',
          'grades.name AS nameGrade',
          'grades.id AS idGrade',
          DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
          DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
          'wallets.*',
          'legalizations.legId'
        )
          ->join('courses', 'courses.id', 'legalizations.legCourse_id')
          ->join('grades', 'grades.id', 'legalizations.legGrade_id')
          ->join('students', 'students.id', 'legalizations.legStudent_id')
          ->join('attendants', 'attendants.id', 'legalizations.legAttendant_id')
          ->join('wallets', 'wallets.waStudent_id', 'students.id')
          ->where('legalizations.legStudent_id', trim($request->pdfStudent))
          ->first();
        if ($datehead != null) {
          $collaborator = CourseConsolidated::select(
            DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename) AS nameCollaborator")
          )->join('collaborators', 'collaborators.id', 'coursesconsolidated.ccCollaborator_id')
            ->where('ccCourse_id', $datehead->idCourse)
            ->where('ccGrade_id', $datehead->idGrade)
            ->where('ccStatus', 'ACTIVO')
            ->first();
          $allfacturations = array();
          $countfacturations = Facturation::where('facturations.facLegalization_id', $datehead->legId)->count();
          $facturations = Facturation::where('facturations.facLegalization_id', $datehead->legId)->get();
          if ($countfacturations > 0) {
            $totalFactures = 0;
            foreach ($facturations as $facturation) {
              $totalFactures += $facturation->facValue;
            }
            foreach ($facturations as $facturation) {
              $entrys = Entry::where('venFacturation_id', $facturation->facId)->get();
              $origin = '';

              foreach ($entrys as $entry) {
                if ($entry->venDescription != null || $entry->venDescription != '') {
                  if (end($entry)) {
                    $origin .= 'SALDO DE CARTERA ';
                  } else {
                    $origin .= 'SALDO EN CARTERA Y ';
                  }
                } else {
                  if (end($entry)) {
                    $origin .= 'CONSIGNACION-EFECTIVO ';
                  } else {
                    $origin .= 'CONSIGNACION-EFECTIVO Y ';
                  }
                }
              } //foreach entrys
              array_push($allfacturations, [
                $facturation->facCode,
                $facturation->facValue,
                $facturation->facDateInitial,
                $facturation->facStatus,
                $origin
              ]);
            } // close foreach facturations
          }

          $student = Student::find($request->pdfStudent);
          $pdf = \App::make('dompdf.wrapper');
          $namefile = 'REPORTE_DE_CARTERA_INDIVIDUAL_' . $student->firstname . '_' . $student->threename . '.pdf';
          $pdf->loadView('modules.facturations.reportStudentPdf', compact('datehead', 'collaborator', 'allfacturations', 'countfacturations', 'totalFactures'));
          //$pdf->setPaper("A6", "landscape");
          return $pdf->download($namefile);
        } else {
          $student = Student::find($request->pdfStudent);
          return redirect()->route('facturation.all')->with('WarningUpdateFacturation', 'No hay informes del alumno ' . $student->firstname . ' ' . $student->threename);
        }
      }
    } catch (Exception $ex) {
    }
  }

  public function accountsPendingPdf(Request $request)
  {
    try {
      // dd($request->all());
      /*
                $request->concepts
                $request->legalization
            */
      $concept = explode(':', $request->concepts);
      $concepts = array();
      for ($i = 0; $i < count($concept); $i++) {
        $find = Concept::find($concept[$i]);
        if ($find != null) {
          if ($i == 0) {
            $leg = $find->conLegalization_id;
          }
          array_push($concepts, [
            $find->conId,
            $find->conDate,
            $find->conConcept,
            $find->conValue,
            $find->conStatus
          ]);
        }
      }
      // dd($concepts);
      $garden = Garden::select('garden.*', 'citys.name as nameCity', 'locations.name as nameLocation')
        ->join('citys', 'citys.id', 'garden.garCity_id')
        ->join('locations', 'locations.id', 'garden.garLocation_id')
        ->first();
      $legalization = Legalization::select(
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
        'grades.name as nameGrade',
        'students.address'
      )
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
        ->join('grades', 'grades.id', 'legalizations.legGrade_id')
        ->where('legId', trim($request->legalization))->first();
      // if($legalization == null){
      //     $legalization = Legalization::select(
      //             DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
      //             DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
      //             'grades.name as nameGrade',
      //             'students.address'
      //         )
      //         ->join('students','students.id','legalizations.legStudent_id')
      //         ->join('attendants','attendants.id','legalizations.legAttendantmother_id')
      //         ->join('grades','grades.id','legalizations.legGrade_id')
      //         ->where('legId',trim($request->legalization))->first();
      // }
      $pdf = \App::make('dompdf.wrapper');
      $namefile = 'CARTERA_PENDIENTE_ALUMNO_' . $legalization->nameStudent . '.pdf';
      $pdf->loadView('modules.facturations.accountsPendingPdf', compact('garden', 'concepts', 'legalization'));
      //$pdf->setPaper("A6", "landscape");
      return $pdf->download($namefile);
    } catch (Exception $ex) {
      // Code exception...
    }
  }

  public function defeatedFacturation()
  {
    try {
      $legalizations = Legalization::select(
        'legalizations.*',
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'grades.name as nameGrade'
      )
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->join('grades', 'grades.id', 'legalizations.legGrade_id')
        ->get();
      $today = Date('Y-m-d');
      $result = array();
      foreach ($legalizations as $legalization) {
        $fromLegalization = array();
        $facturations = Facturation::where('facLegalization_id', $legalization->legId)
          ->where('facDateFinal', '<', $today)
          ->whereIn('facStatus', ['EN REVISION', 'PAGO PARCIAL'])
          ->get();

        foreach ($facturations as $facturation) {
          $voucherCodes = '';
          if ($facturation->facCountVoucher > 0) {
            $vouchers = Entry::where('venFacturation_id', $facturation->facId)->get();
            foreach ($vouchers as $voucher) {
              $voucherCodes .= ',' . $voucher->venCode;
            }
            array_push($fromLegalization, [
              $facturation->facCode,
              $facturation->facDateFinal,
              $facturation->facValueCopy,
              $facturation->facCountVoucher,
              $voucherCodes
            ]);
          } else {
            array_push($fromLegalization, [
              $facturation->facCode,
              $facturation->facDateFinal,
              $facturation->facValueCopy,
              $facturation->facCountVoucher,
              'N/A'
            ]);
          }
        }
        if (count($fromLegalization) > 0) {
          array_push($result, [$legalization->nameStudent, $legalization->nameGrade, $fromLegalization]);
        }
      }
      $pdf = App::make('dompdf.wrapper');
      $namefile = 'CARTERA_VENCIDA.pdf';
      $pdf->loadView('modules.facturations.defeatedFacturation', compact('result'));
      return $pdf->download($namefile);
    } catch (Exception $ex) {
    }
  }
}
