<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VoucheregressExcel;

use App\Models\Egress;
use App\Models\Provider;
use App\Models\Garden;
use App\Models\User;
use App\Models\Collaborator;
use App\Models\Coststructure;
use App\Models\Costdescription;
use Exception;

class EgressController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function egressvoucherTo()
  {
    $voucheregress = Egress::select(
      'voucheregress.*',
      'providers.*'
    )
      ->join('providers', 'providers.id', 'voucheregress.vegProvider_id')
      ->orderBy('id', 'desc')->get();
    $providers = Provider::select('id', 'namecompany')->orderBy('namecompany', 'asc')->get();
    $structures = Coststructure::all();
    return view('modules.vouchers.egressIndex', compact('voucheregress', 'providers', 'structures'));
  }

  public function newEgressvoucher(Request $request)
  {
    try {
      // dd($request->all());
      // $request->vegReteica
      // $request->vegValuereteica
      $validateEgress = Egress::where('vegCode', trim($request->vegCode))->first();
      if ($validateEgress == null) {
        Egress::create([
          'vegCode' => trim($request->vegCode),
          'vegProvider_id' => trim($request->vegProvider),
          'vegConcept' => trim($request->vegConcept),
          'vegDate' => trim($request->vegDate),
          'vegSubpay' => trim($request->vegSubpay),
          'vegIva' => trim($request->vegIva),
          'vegValueiva' => trim($request->vegValueiva),
          'vegRetention' => trim($request->vegRetention),
          'vegValueretention' => trim($request->vegValueretention),
          'vegReteica' => trim($request->vegReteica),
          'vegValuereteica' => trim($request->vegValuereteica),
          'vegPay' => trim($request->vegPay),
          'vegCoststructure_id' => trim($request->vegCoststructure),
          'vegCostdescription_id' => trim($request->vegCostdescription)
        ]);
        return redirect()->route('egressVouchers')->with('SuccessSaveEgress', 'SE HA GUARDADO EL COMPROBANTE DE EGRESO CON CODIGO ' . trim($request->vegCode) . ' CORRECTAMENTE');
      } else {
        return redirect()->route('egressVouchers')->with('SecondarySaveEgress', 'COINCIDENCIA DE CODIGO EN EL COMPROBANTE DE EGRESO, NO SE HA GUARDADO EL PAGO');
      }
    } catch (Exception $ex) {
      return redirect()->route('egressVouchers')->with('SecondarySaveEgress', 'NO ES POSIBNLE GUARDAR EL COMPROBANTE DE EGRESO AHORA, COMUNIQUESE CON EL ADMINISTRADOR');
    }
  }

  public function pdfEgressvoucher(Request $request)
  {
    try {
      //dd($request->all());
      /* $reuqest->venId */
      $voucher = Egress::select(
        'voucheregress.*',
        'providers.*',
        'documents.type'
      )
        ->join('providers', 'providers.id', 'voucheregress.vegProvider_id')
        ->join('documents', 'documents.id', 'providers.typedocument_id')
        ->where('vegId', trim($request->vegId))
        ->first();
      $user = User::find(auth()->id());
      $firm = 'N/A';
      if ($user->collaborator_id != 0 && $user->collaborator_id > 0) {
        $firm = Collaborator::find($user->collaborator_id);
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
      $pdf = \App::make('dompdf.wrapper');
      $namefile = 'COMPROBANTE_DE_EGRESO_' . $voucher->vegDate . '.pdf';
      $pdf->loadView('modules.vouchers.egressPdf', compact('voucher', 'garden', 'firm'));
      // $pdf->setPaper([0,0,612.00,396.00], "portrait");
      $pdf->setPaper([0, 0, 612.00, 792.00], "portrait");
      return $pdf->download($namefile);
    } catch (Exception $ex) {
    }
  }

  public function excelEgressvoucher(Request $request)
  {
    // dd($request->all());
    // dd($request->all());
    $dateInitialSelected = Date('Y-m-d', strtotime(trim($request->vegDateInitial)));
    $dateFinalSelected = Date('Y-m-d', strtotime(trim($request->vegDateFinal)));
    $vouchers = Egress::whereBetween('vegDate', [trim($request->vegDateInitial), trim($request->vegDateFinal)])->count();
    if ($vouchers > 0) {
      return Excel::download(new VoucheregressExcel(trim($request->vegDateInitial), trim($request->vegDateFinal)), 'COMPROBANTES_DE_EGRESO_DE_' . $dateInitialSelected . '_HASTA_' . $dateFinalSelected . '.xlsx');
    } else {
      return redirect()->route('egressVouchers')->with('SecondarySaveEgress', 'NO EXISTEN COMPROBANTES DE EGRESO EN EL RANGO DE FECHAS: ' . $dateInitialSelected . ' - ' . $dateFinalSelected);
    }
  }
}
