<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Entry;

use App\Models\Garden;
use App\Models\Wallet;
use App\Models\Concept;
use App\Models\General;
use App\Models\Facturation;
use App\Models\Collaborator;
use App\Models\Legalization;
use Illuminate\Http\Request;
use App\Exports\VoucherentryExcel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EntrysController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function entryvoucherTo()
  {
    $day = Carbon::now()->toDateString();
    $voucherentrys = Entry::select(
      'voucherentrys.*',
      'facturations.facId',
      'facturations.facCode',
      'students.id as idStudent',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS venStudent")
    )
      ->join('facturations', 'facturations.facId', 'voucherentrys.venFacturation_id')
      ->join('students', 'students.id', 'voucherentrys.venStudent_id')
      ->get();
    $students = Legalization::select(
      'legalizations.legId',
      'students.id',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->get();
    //dd($students);
    return view('modules.vouchers.entryIndex', compact('voucherentrys', 'students', 'day'));
  }

  public function saveEntryvoucher(Request $request)
  {
    // dd($request->all());
    try {
      $legalization = Legalization::find($request->venLegalization_id);
      $voucherentryValidate = Entry::where('venCode', trim($request->venCode))->first();
      if ($voucherentryValidate == null && $legalization != null) {
        Entry::create([
          'venCode' => trim($request->venCode),
          'venFacturation_id' => trim($request->venFacturation_id),
          'venStudent_id' => $legalization->legStudent_id,
          'venDate' => trim($request->venDate),
          'venPaid' => trim($request->venPaid_hidden),
          'venObs' => trim($request->venObs),
          'venDescription' => trim($request->venDescrimtion)
        ]);
        if ($request->venTypepaid == 'TOTAL') {
          $facture = Facturation::find(trim($request->venFacturation_id));
          $facture->facValueCopy = 0;
          $facture->facCountVoucher += 1;
          $facture->facStatus = 'PAGADO';
          $facture->save();
        } else if ($request->venTypepaid == 'PARCIAL') {
          $facture = Facturation::find(trim($request->venFacturation_id));
          $facture->facValueCopy -= trim($request->venPaid_hidden);
          $facture->facCountVoucher += 1;
          $facture->facStatus = 'PAGO PARCIAL';
          $facture->save();
        }
        return redirect()->route('entryVouchers')->with('SuccessSaveEntry', 'COMPROBANTE CON CODIGO ' . trim($request->venCode) . ' GENERADO CORRECTAMENTE');
      } else {
        return redirect()->route('entryVouchers')->with('SecondarySaveEntry', 'INTENTELO NUEVAMENTE, EXISTE UNA COINCIDENCIA DE COMPROBANTE');
      }
    } catch (Exception $ex) {
      return redirect()->route('facturations')->with('SecondarySaveEntry', 'NO ES POSIBLE GENERAR EL COMPROBANTE AHORA, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  public function pdfEntryvoucher(Request $request)
  {
    try {
      // dd($request->all());
      /* $request->venId */
      $voucher = Entry::select(
        'voucherentrys.*',
        'facturations.*',
        DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
        'attendants.numberdocument as docAttendant',
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'students.numberdocument as docStudent'
      )
        ->join('facturations', 'facturations.facId', 'voucherentrys.venFacturation_id')
        ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
        ->join('attendants', 'attendants.id', 'legalizations.legAttendantfather_id')
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->where('venId', $request->venId)
        ->first();
      if ($voucher->nameAttendant == null) {
        $voucher = Entry::select(
          'voucherentrys.*',
          'facturations.*',
          DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
          'attendants.numberdocument as docAttendant',
          DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
          'students.numberdocument as docStudent'
        )
          ->join('facturations', 'facturations.facId', 'voucherentrys.venFacturation_id')
          ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
          ->join('attendants', 'attendants.id', 'legalizations.legAttendantmother_id')
          ->join('students', 'students.id', 'legalizations.legStudent_id')
          ->join('documents', 'documents.id', 'attendants.typedocument_id')
          ->where('venId', $request->venId)
          ->first();
      }
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
      $user = User::find(auth()->id());
      $firm = 'N/A';
      if ($user->id != 0 and $user->id != "1024500065" and $user->id != "80503717") {
      $firm = Collaborator::where('numberdocument', $user->id)->first();
      if (!$firm) {
        return back()->with('WarningUpdateFacturation', 'Este usuario no se encuentra registrado como colaborador');
      }
    }
      $separated = explode(',', $voucher->facAutorized);
      $concepts = '';
      for ($i = 0; $i < count($separated); $i++) {
        $separatedEach = explode('/', $separated[$i]);
        if ($i == (count($separated) - 1)) {
          $concepts .= $separatedEach[0];
        } else {
          $concepts .= $separatedEach[0] . '-';
        }
      }
      $pdf = \App::make('dompdf.wrapper');
      $namefile = 'COMPROBANTE_DE_INGRESO_' . $voucher->venDate . '.pdf';
      $pdf->setPaper([0, 0, 612.00, 792.00], "portrait");
      $pdf->loadView('modules.vouchers.entryPdf', compact('voucher', 'concepts', 'garden', 'firm'));
      return $pdf->download($namefile);
    } catch (Exception $ex) {
      // Code exception ...
    }
  }

  public function excelEntryvoucher(Request $request)
  {
    // dd($request->all());
    $vouchers = Entry::whereBetween('venDate', [$request->venDateInitial, $request->venDateFinal])->count();
    if ($vouchers) {
      return Excel::download(new VoucherentryExcel(trim($request->venDateInitial), trim($request->venDateFinal)), 'COMPROBANTES_DE_INGRESO_DE_' . $request->venDateInitial . '_HASTA_' . $request->venDateFinal . '.xlsx');
    } else {
      return redirect()->route('entryVouchers')->with('SecondarySaveEntry', 'NO EXISTEN COMPROBANTES DE INGRESO EN EL RANGO DE FECHAS: ' . $request->venDateInitial . ' - ' . $request->venDateFinal);
    }
  }

  public function pdfEntryvoucherfacturation(Request $request)
  {
    try {
      // dd($request->all());
      /*0
        legId
                $request->facId;
            */
      $facture = array(); // DONDE SE GUARDA TODA LA INFORMACIÖN QUE SE MUESTRA EN EL PDF
      $facturation = Facturation::select(
        'facturations.*', // facCode, facDateInitial, facFateFinal, facValue, facLegalization_id, facConcepts, facStatus
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'citys.name as nameCity',
        'legalizations.legId'
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
        ->where('legId', $facturation->legId)->first();
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
        ->where('legId', $facturation->legId)->first();
      $student = Legalization::select(
        DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
        'documents.type',
        'students.numberdocument',
        'grades.name as grade'
      )
        ->join('students', 'students.id', 'legalizations.legStudent_id')
        ->join('documents', 'documents.id', 'students.typedocument_id')
        ->join('grades', 'grades.id', 'legalizations.legGrade_id')
        ->where('legId', $facturation->legId)->first();
      $user = User::select('collaborators.firm', 'collaborators.position')->join('collaborators', 'collaborators.id', 'users.collaborator_id')->where('users.id', auth()->id())->first();
      $user = User::find(auth()->id());
      $firm = 'N/A';
      if ($user->collaborator_id != 0) {
        $firm = Collaborator::find($user->collaborator_id);
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

      $pdf = \App::make('dompdf.wrapper');
      $namefile = 'FACTURA_' . $facture[0][1] . '.pdf';
      $pdf->loadView('modules.vouchers.entryFacturePdf', compact('facture', 'garden', 'totalAbsolut', 'totalAbsolutNotIva', 'iva', 'totalAbsolutOnlyIva', 'discount'));
      //$pdf->setPaper("A6", "landscape");
      return $pdf->download($namefile);
      //dd($facture);
    } catch (Exception $ex) {
    }
  }
}
