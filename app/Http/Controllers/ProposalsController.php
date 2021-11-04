<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Proposal;

use App\Models\Customer;
use App\Models\Scheduling;
use App\Models\Grade;
use App\Models\Admission;
use App\Models\Journey;
use App\Models\Feeding;
use App\Models\Uniform;
use App\Models\Supplie;
use App\Models\Transport;
use App\Models\Extratime;
use App\Models\Extracurricular;
use App\Models\Garden;
use App\Models\Binnacle;
use App\Models\User;
use App\Models\Collaborator;
use App\Models\General;

class ProposalsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  function customerProposal()
  {
    $customers = Customer::select('customers.id as cusId', 'customers.*', 'schedulings.*')
      ->join('schedulings', 'schedulings.schCustomer_id', 'customers.id')
      ->where('schStatusVisit', 'INACTIVO')
      ->where('schResultVisit', 'ASISTIDO')
      ->where('schQuoted', null)
      ->distinct('schCustomer_id')->get();
    return view('modules.proposals.customers', compact('customers'));
  }

  public function quotationTo()
  {
    $customers = Customer::select('customers.id as cusId', 'customers.cusFirstname', 'cusLastname')
      ->join('schedulings', 'schedulings.schCustomer_id', 'customers.id')
      ->where('schStatusVisit', 'INACTIVO')
      ->where('schResultVisit', 'ASISTIDO')
      ->where('schQuoted', null)
      ->distinct('schCustomer_id')->get();
    $grades = Grade::all();
    $admissions = Admission::all();
    $journeys = Journey::all();
    $feedings = Feeding::all();
    $uniforms = Uniform::all();
    $supplies = Supplie::all();
    $transports = Transport::all();
    $extratimes = Extratime::all();
    $extracurriculars = Extracurricular::all();
    return view('modules.proposals.quotation', compact('customers', 'grades', 'admissions', 'journeys', 'feedings', 'uniforms', 'supplies', 'transports', 'extratimes', 'extracurriculars'));
  }

  public function saveQuotation(Request $request)
  {
    //dd($request->all());
    try {
      $dateScheduling = '';
      //Validar si tenia cita para pasar la cita a estado: ASISTIDO y FINALIZADO para quitar de tabla de clientes
      if (isset($request->proScheduling_id)) {
        $scheduling = Scheduling::find($request->proScheduling_id);
        $dateScheduling = $scheduling->schDateVisit;
        $scheduling->schQuoted = 'FINALIZADO';
        $scheduling->schColor = '#fd8701';
        $scheduling->save();
      }

      //Validar si ya existe una cotización igual para el cliente
      $quotationSave = Proposal::where('proCustomer_id', trim($request->proCustomer_id))
        ->where('proGrade_id', trim($request->proGrade_id))
        ->where('proDateQuotation', date('Y-m-d'))
        ->where('proStatus', 'ABIERTO')
        ->first();
      //Tomar los datos del request y guardar la cotización si no existe una cotización igual
      if ($quotationSave == null) {
        $valueTotal = str_replace('$', '', $request->proValueQuotation);
        if (
          trim($request->detailsAdmission_input) == '' &&
          trim($request->detailsJourney_input) == '' &&
          trim($request->detailsFeeding_input) == '' &&
          trim($request->detailsUniform_input) == '' &&
          trim($request->detailsSupplie_input) == '' &&
          trim($request->detailsTransport_input) == '' &&
          trim($request->detailsExtratime_input) == '' &&
          trim($request->detailsExtracurricular_input) == '' &&
          (int)$valueTotal <= 0
        ) {
          return redirect()->route('quotation')->with('SecondarySaveQuotation', 'Ningún Producto/Servicio seleccionado, No se ha guardado la cotización');
        } else {
          Proposal::create([
            'proDateQuotation' => date('Y-m-d'),
            'proCustomer_id' => trim($request->proCustomer_id),
            'proGrade_id' => trim($request->proGrade_id),
            'proAdmission_id' => trim($request->detailsAdmission_input),
            'proJourney_id' => trim($request->detailsJourney_input),
            'proFeeding_id' => trim($request->detailsFeeding_input),
            'proUniform_id' => trim($request->detailsUniform_input),
            'proSupplie_id' => trim($request->detailsSupplie_input),
            'proTransport_id' => trim($request->detailsTransport_input),
            'proExtratime_id' => trim($request->detailsExtratime_input),
            'proExtracurricular_id' => trim($request->detailsExtracurricular_input),
            'proValueQuotation' => $valueTotal
          ]);
          return redirect()->route('quotation')->with('SuccessSaveQuotation', 'Cotización con fecha ' . date('Y-m-d') . ', creada correctamente');
        }
      } else {
        return redirect()->route('quotation')->with('SecondarySaveQuotation', 'Ya existe una cotización para el cliente en espera de respuesta');
      }

      // else if($request->proCustomerOption == 'NO'){
      //     //Usuario ha seleccionado opcion NO es un cliente registrado por lo que se procede a:
      //     $customerExistsId;
      //     //Validar si ya existe el cliente
      //     $customerSave = Customer::where('cusFirstname',trim(ucfirst(strtolower($request->cusFirstnameNew))))
      //                             ->where('cusLastname',trim(ucfirst(strtolower($request->cusLastnameNew))))
      //                             ->where('cusPhone',trim(ucfirst(strtolower($request->cusPhoneNew))))
      //                             ->where('cusMail',trim(strtolower($request->cusMailNew)))
      //                             ->where('cusChild',trim(ucfirst(strtolower($request->cusChildNew))))
      //                             ->first();
      //     if($customerSave == null){
      //         //Guardar el nuevo cliente
      //         Customer::create([
      //             'cusFirstname' => trim(ucfirst(strtolower($request->cusFirstnameNew))),
      //             'cusLastname' => trim(ucfirst(strtolower($request->cusLastnameNew))),
      //             'cusPhone' => trim($request->cusPhoneNew),
      //             'cusMail' => trim(strtolower($request->cusMailNew)),
      //             'cusChild' => trim(ucfirst(strtolower($request->cusChildNew))),
      //             'cusChildYearsold' => trim($request->cusChildYearsoldNew),
      //             'cusNotes' => trim($request->cusNotesNew),
      //         ]);
      //         $customerSaved = Customer::where('cusFirstname',trim(ucfirst(strtolower($request->cusFirstnameNew))))
      //                             ->where('cusLastname',trim(ucfirst(strtolower($request->cusLastnameNew))))
      //                             ->where('cusPhone',trim(ucfirst(strtolower($request->cusPhoneNew))))
      //                             ->where('cusMail',trim(strtolower($request->cusMailNew)))
      //                             ->where('cusChild',trim(ucfirst(strtolower($request->cusChildNew))))
      //                             ->where('cusChildYearsold',trim($request->cusChildYearsoldNew))
      //                             ->where('cusNotes',trim($request->cusNotesNew))
      //                             ->first();
      //         $customerExistsId = $customerSaved->id;
      //     }else{
      //         $customerExistsId = $customerSave->id;
      //     }
      //     //Guardar la cotización
      //     $valueTotal = str_replace('$','',$request->proValueQuotation);
      //     if($request->proAdmission_id == null &&
      //         $request->proJourney_id == null &&
      //         $request->proFeeding_id == null &&
      //         $request->proUniform_id == null &&
      //         $request->proSupplie_id == null &&
      //         $request->proTransport_id == null &&
      //         $request->proExtracurricular_id == null &&
      //         $request->proExtratime_id == null
      //     ){
      //         return redirect()->route('quotation')->with('SecondarySaveQuotation', 'Ningún Producto/Servicio seleccionado, No se ha guardado la cotización');
      //     }else{
      //         Proposal::create([
      //             'proDateQuotation' => date('Y-m-d'),
      //             'proCustomer_id' => trim($request->proCustomer_id),
      //             'proGrade_id' => trim($request->proGrade_id),
      //             'proAdmission_id' => $request->proAdmission_id,
      //             'proJourney_id' => $request->proJourney_id,
      //             'proFeeding_id' => $request->proFeeding_id,
      //             'proUniform_id' => $request->proUniform_id,
      //             'proSupplie_id' => $request->proSupplie_id,
      //             'proTransport_id' => $request->proTransport_id,
      //             'proExtratime_id' => $request->proExtratime_id,
      //             'proExtracurricular_id' => $request->proExtracurricular_id,
      //             'proValueQuotation' => $valueTotal
      //         ]);
      //         return redirect()->route('quotation')->with('SuccessSaveQuotation', 'Cotización de nuevo cliente con fecha ' . date('Y-m-d') . ', creada correctamente');
      //     }
      // }
    } catch (Exception $ex) {
      return redirect()->route('healths')->with('SecondarySaveQuotation', 'No es posible crear la cotización ahora!!, Comuniquese con el administrador');
    }
  }

  //TABLA GENERAL DE SEGUIMIENTOS
  public function tracingTo()
  {
    $tracings = Proposal::select('proposals.id', 'proposals.proDateQuotation', 'proposals.proResult', 'customers.cusFirstname', 'customers.cusLastname', 'customers.cusMail', 'customers.cusPhone', 'customers.cusNotes')
      ->join('customers', 'customers.id', 'proposals.proCustomer_id')
      ->where('proStatus', 'ABIERTO')->get();
    return view('modules.proposals.tracing', compact('tracings'));
  }

  //CAMBIAR ESTADO DE COTIZACIONES A ==> APROBADO
  public function changeStatusProposal(Request $request)
  {
    try {
      $proposal = Proposal::find($request->CodeFromBtnApproved);
      $proposal->proStatus = 'CERRADO';
      $proposal->proResult = 'ACEPTADO';
      $customer = Customer::find($proposal->proCustomer_id);
      if ($customer != null) {
        $customer->cusVisible = 'INACTIVO';
        $customer->save();
      }
      $proposal->save();
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'Cotizacion con ID: ' . $request->CodeFromBtnApproved . ', APROBADA Y CERRADA, Consulte la cotización en ARCHIVO del menú lateral');
    } catch (Exception $ex) {
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'No fue posible aprobar la cotización, comuniquese con el administrador');
    }
  }

  //CAMBIAR ESTADO DE COTIZACIONES A ==> DENEGADO
  public function proposalDenied(Request $request)
  {
    try {
      $proposal = Proposal::find($request->CodeFromBtnDenied);
      $proposal->proStatus = 'CERRADO';
      $proposal->proResult = 'DENEGADO';
      $customer = Customer::find($proposal->proCustomer_id);
      if ($customer != null) {
        $customer->cusVisible = 'INACTIVO';
        $customer->save();
      }
      $proposal->save();
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'Cotizacion con ID: ' . $request->CodeFromBtnDenied . ', DENEGADA Y CERRADA, Consulte la cotización en ARCHIVO del menú lateral');
    } catch (Exception $ex) {
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'No fue posible aprobar la cotización, comuniquese con el administrador');
    }
  }

  //EXPORTAR A PDF LA COTIZACION SELECCIONADA
  public function exportToPdf(Request $request)
  {
    try {
      if (isset($request->CodeFromBtnDownload)) {
        $arrayProposal = array();
        $consolidatedProposal = Proposal::find($request->CodeFromBtnDownload);
        $customer = Customer::find($consolidatedProposal->proCustomer_id);
        $grade = Grade::find($consolidatedProposal->proGrade_id);
        // $user = User::select('collaborators.firm','collaborators.position')->join('collaborators','collaborators.id','users.collaborator_id')->where('users.id',auth()->id())->first();
        $user = User::find(auth()->id());
        $firm = 'N/A';
        if ($user->collaborator_id != 0 || $user->collaborator_id > 0) {
          $firm = Collaborator::find($user->collaborator_id);
        }
        if ($firm != 'N/A') {
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
            $grade->name,
            $firm->firm,
            $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname,
            $firm->position
          ]);
        } else {
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
            $grade->name,
            $firm
          ]);
        }
        if ($consolidatedProposal->proAdmission_id != null && strlen($consolidatedProposal->proAdmission_id) > 0) {
          $separatedAdmission = explode(':', $consolidatedProposal->proAdmission_id);
          for ($i = 0; $i < count($separatedAdmission); $i++) {
            $admission = Admission::find($separatedAdmission[$i]);
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
            $journey = Journey::find($separatedJourney[$i]);
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
            $feeding = Feeding::find($separatedFeeding[$i]);
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
            $uniform = Uniform::find($separatedUniform[$i]);
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
            $supplie = Supplie::find($separatedSupplie[$i]);
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
            $transport = Transport::find($separatedTransport[$i]);
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
            $extratime = Extratime::find($separatedExtratime[$i]);
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
            $extracurricular = Extracurricular::find($separatedExtracurricular[$i]);
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

        $general = General::first();
        /*
                    fgBank
                    fgNumberaccount
                */

        if (count($arrayProposal) > 0) {
          $namefile = 'COTIZACION_' . $arrayProposal[0][4] . '.pdf';
          $idProposal = $request->CodeFromBtnDownload;
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadView('modules.proposals.proposalPdf', compact('arrayProposal', 'idProposal', 'garden', 'general'));
          return $pdf->download($namefile);
        }
        // $consolidatedProposal = App\Models\Proposal::select('proposals.*','customers.*','grades.name','admissions.*','journeys.*','feedings.*','uniforms.*','supplies.*','transports.*','extracurriculars.*')
        //          ->join('customers','customers.id','proposals.proCustomer_id')
        //          ->join('grades','grades.id','proposals.proGrade_id')
        //          ->join('admissions','admissions.id','proposals.proAdmission_id')
        //          ->join('journeys','journeys.id','proposals.proJourney_id')
        //          ->join('feedings','feedings.id','proposals.proFeeding_id')
        //          ->join('uniforms','uniforms.id','proposals.proUniform_id')
        //          ->join('supplies','supplies.id','proposals.proSupplie_id')
        //          ->join('transports','transports.id','proposals.proTransport_id')
        //          ->join('extracurriculars','extracurriculars.id','proposals.proExtracurricular_id')
        //          ->where('proposals.id',$request->proposalSelected)
        //          ->first();
        return response()->json($arrayProposal);
      }
    } catch (Exception $ex) {
      return redirect()->route('tracing')->with('SecondaryExportTracing', 'No fue posible exportar a PDF, comuniquese con el administrador');
    }
  }

  public function filesTo()
  {
    // $tracings = Proposal::select('proposals.id','proposals.proDateQuotation','proposals.proResult','customers.cusFirstname','customers.cusLastname','customers.cusMail','customers.cusPhone','customers.cusNotes')
    //             ->join('customers','customers.id','proposals.proCustomer_id')
    //             ->where('proStatus','CERRADO')->get();
    $proposals = Proposal::where('proStatus', 'CERRADO')->get();
    $tracings = array();
    foreach ($proposals as $proposal) {
      if ($proposal->proCustomer_id != null) {
        $customer = Customer::find($proposal->proCustomer_id);
        // dd($tracings, $customer);
        if ($customer != null) {
          if ($customer->cusVisible == 'ACTIVO') {
            array_push($tracings, [
              $proposal->id,
              $proposal->proDateQuotation,
              $proposal->proResult,
              $customer->cusFirstname . ' ' . $customer->cusLastname,
              $customer->cusMail,
              $customer->cusPhone,
              $customer->cusNotes
            ]);
          } else if ($customer->cusVisible == 'INACTIVO') {
            array_push($tracings, [
              $proposal->id,
              $proposal->proDateQuotation,
              $proposal->proResult,
              $customer->cusFirstname . ' ' . $customer->cusLastname,
              $customer->cusMail,
              $customer->cusPhone,
              $customer->cusNotes
            ]);
          }
        } else {
          array_push($tracings, [
            $proposal->id,
            $proposal->proDateQuotation,
            $proposal->proResult,
            'eliminado',
            'eliminado',
            'eliminado',
            'eliminado'
          ]);
        }
      } else {
        array_push($tracings, [
          $proposal->id,
          $proposal->proDateQuotation,
          $proposal->proResult,
          'eliminado',
          'eliminado',
          'eliminado',
          'eliminado'
        ]);
      }
    }
    return view('modules.proposals.files', compact('tracings'));
  }

  public function saveBinnacle(Request $request)
  {
    try {
      Binnacle::create([
        'binProposal_id' => trim($request->binProposal_id),
        'binDate' => trim($request->binDate),
        'binObservation' => trim($request->binObservation)
      ]);
      $customer = Proposal::select('customers.cusFirstname', 'customers.cusLastname')
        ->join('customers', 'customers.id', 'proposals.proCustomer_id')
        ->where('proposals.id', trim($request->binProposal_id))
        ->first();
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'Registro de bitacora para ' . $customer->cusFirstname . ' ' . $customer->cusLastname . ', guardado correctamente');
    } catch (Exception $ex) {
      return redirect()->route('tracing')->with('PrimaryUpdateTracing', 'No fue posible crear el registro en la bitacora ahora, comuniquese con el administrador');
    }
  }
}
