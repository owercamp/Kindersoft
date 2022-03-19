<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Garden;
use App\Models\Concept;
use App\Models\General;
use App\Models\Facturation;
use App\Models\Collaborator;
use App\Models\Legalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class CanceledController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function canceledTo()
  {
    $facturations = Facturation::select(
      'facturations.*',
      DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
    )
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->where('facStatus', 'ANULADA')->orderBy('facCode', 'asc')->get();
    return view('modules.facturations.canceled', compact('facturations'));
  }

  public function factureCanceledall(Request $request)
  {
    // dd($request->all());
    $initial = Carbon::createFromDate($request->searchInitial)->locale('es')->isoFormat('LL');
    $final = Carbon::createFromDate($request->searchFinal)->locale('es')->isoFormat('LL');

    $data = Facturation::where('facStatus', 'ANULADA')
      ->join('legalizations', 'legalizations.legId', 'facturations.facLegalization_id')
      ->join('students', 'students.id', 'legalizations.legStudent_id')
      ->whereBetween('facDateFinal', [$request->searchInitial, $request->searchFinal])->get();
    // return $data;
    $priceTotal = 0;
    foreach ($data as $value) {
      $priceTotal += $value->facValue;
    }
    $pdf = App::make('dompdf.wrapper');
    $namefile = 'Facturas Anuladas entre ' . $request->searchInitial . ' - ' . $request->searchFinal . '.pdf';
    $pdf->loadview('modules.facturations.canceledAllPDF', compact('initial', 'final', 'data', 'priceTotal'));
    return $pdf->download($namefile);
  }

  public function factureCanceled(Request $request)
  {
    // dd($request->all());
    /*
			$request->argumentCanceled
			$request->facId_canceled
			$request->legId_canceled
    	*/
    $validate = Facturation::find(trim($request->facId_canceled));
    if ($validate != null) {
      $code = $validate->facCode;
      $validate->facStatus = 'ANULADA';
      $validate->facArgument = $this->fu($request->argumentCanceled);
      $validate->save();
      return redirect()->route('facturation.all')->with('SuccessSaveEntry', 'Factura ' . $code . ', anulada');
    } else {
      return redirect()->route('facturation.all')->with('SecondarySaveEntry', 'No se encuentra la factura');
    }
  }

  public function pdfCanceled(Request $request)
  {
    try {
      // dd($request->all());
      /*
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
      $namefile = 'FACTURA_ANULADA_' . $facture[0][1] . '.pdf';
      $pdf->loadView('modules.facturations.canceledPdf', compact('facture', 'garden', 'totalAbsolut', 'totalAbsolutNotIva', 'iva', 'totalAbsolutOnlyIva', 'discount'));
      //$pdf->setPaper("A6", "landscape");
      return $pdf->download($namefile);
      //dd($facture);
    } catch (Exception $ex) {
    }
  }

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
