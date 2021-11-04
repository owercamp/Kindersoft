<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Scheduling;
use App\Models\Proposal;
use App\Models\Facturation;
use App\Models\Garden;
use App\Models\Eventdiary;
use App\Models\Eventcreation;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getMount($numberMount){
        return ($numberMount<10 ? '0' : '') . $numberMount;
    }

    function numberDays($mount,$year){
        $days = date("t");
        return $days;
        //dd(cal_days_in_month(CAL_GREGORIAN,$mount,$year));
        //return cal_days_in_month(CAL_GREGORIAN,$mount,$year);
    }

    function statisticSchedulingTo(){
        $year = date('Y');
        $datesAll = $this->getScheduling($year);
        return view('modules.customers.statisticSchedulings', compact('datesAll'));
    }

    function getScheduling($year){
        $result = array();
        for ($i=1; $i <= 12; $i++) {
            $assisted = Scheduling::whereBetween('schDateVisit', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->join('customers','customers.id','schedulings.schCustomer_id')->where('schResultVisit','ASISTIDO')->count();
            $notAssisted = Scheduling::whereBetween('schDateVisit', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->join('customers','customers.id','schedulings.schCustomer_id')->where('schResultVisit','INASISTIDO')->count();
            $pending = Scheduling::whereBetween('schDateVisit', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->where('schResultVisit','PENDIENTE')->count();
            $result[$i][0] = $pending;
            $result[$i][1] = $assisted;
            $result[$i][2] = $notAssisted;
        }
        return $result;
    }

    function getPending(Request $request){
        $pending = array();
        for ($i=1; $i <= 12; $i++) {
            $query = Scheduling::whereBetween('schDateVisit', [$request->year . '-' . $this->getMount($i) . '-01' , $request->year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$request->year)])->where('schResultVisit','PENDIENTE')->count();
            array_push($pending, $query);
        }
        return $pending;
        // return response()->json($pending);
        // return $request->year;
    }

    function getAssisted(Request $request){
        $assisted = array();
        for ($i=1; $i <= 12; $i++) {
            $query = Scheduling::whereBetween('schDateVisit', [$request->year . '-' . $this->getMount($i) . '-01' , $request->year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$request->year)])->join('customers','customers.id','schedulings.schCustomer_id')->where('schResultVisit','ASISTIDO')->count();
            array_push($assisted, $query);
        }
        return $assisted;
        // return response()->json($assisted);
        // return $request->year;
    }

    function getNotassisted(Request $request){
        $notAssisted = array();
        for ($i=1; $i <= 12; $i++) {
            $query = Scheduling::whereBetween('schDateVisit', [$request->year . '-' . $this->getMount($i) . '-01' , $request->year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$request->year)])->join('customers','customers.id','schedulings.schCustomer_id')->where('schResultVisit','INASISTIDO')->count();
            array_push($notAssisted, $query);
        }
        return $notAssisted;
    }

    //DESCARGAR EN PDF LAS ESTADISTICAS DE LOS AGENDAMIENTOS: NO SE USA YA QUE EL PDF SE GENERA CON LIBRERIA jsPDF de Javascript
    // function pdfScheduling(Request $request){
    //     try{
    //         //dd($request->view);
    //         $statistic = $this->getScheduling(trim($request->year));
    //         $namefile = 'AGENDAMIENTOS_' . $request->year . '.pdf';
    //         $year = $request->year;
    //         $view = $request->grafic;
    //         $garden = Garden::select(
    //                 'garden.*',
    //                 'citys.name AS garNameCity',
    //                 'locations.name AS garNameLocation',
    //                 'districts.name AS garNameDistrict'
    //             )
    //             ->join('citys','citys.id','garden.garCity_id')
    //             ->join('locations','locations.id','garden.garLocation_id')
    //             ->join('districts','districts.id','garden.garDistrict_id')
    //             ->first();
    //         $pdf = \App::make('dompdf.wrapper');
    //         // $pdf->setIsJavascriptEnabled(TRUE);
    //         $pdf->loadView('modules.customers.schedulingPdf', compact('statistic','garden','year','view'));
    //         // $pdf->loadHtml("<canvas id='statisticSchedulings' width='300' height='150'></canvas>");
    //         // $pdf->loadHtml($request->view);
    //         return $pdf->download($namefile);
    //         // $pdf->render();
    //         // $pdf->stream($namefile);
    //     }catch(Exception $ex){
    //         return redirect()->route('customers')->with('SecondaryExportCustomer', 'No fue posible exportar a PDF, comuniquese con el administrador');
    //     }
    // }

    // COTIZACIONES
    function statisticProposalTo(){
        $year = date('Y');
        $proposalAll = $this->getProposals($year);
        return view('modules.proposals.statisticProposal', compact('proposalAll'));
    }

    function getProposals($year){
        $result = array();
        for ($i=1; $i <= 12; $i++) { 
            $noApproved = Proposal::whereBetween('proDateQuotation', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->where('proResult','DENEGADO')->count();
            $approved = Proposal::whereBetween('proDateQuotation', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->where('proResult','ACEPTADO')->count();
            $result[$i][0] = $noApproved;
            $result[$i][1] = $approved;            
        }
        return $result;
    }

    function getApproved(Request $request){
        $approved = array();
        for ($i=1; $i <= 12; $i++) {
            $query = Proposal::whereBetween('proDateQuotation', [$request->year . '-' . $this->getMount($i) . '-01' , $request->year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$request->year)])->where('proResult','ACEPTADO')->count();
            array_push($approved, $query);
        }
        return $approved;
    }

    function getNotapproved(Request $request){
        $notapproved = array();
        for ($i=1; $i <= 12; $i++) {
            $query = Proposal::whereBetween('proDateQuotation', [$request->year . '-' . $this->getMount($i) . '-01' , $request->year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$request->year)])->where('proResult','DENEGADO')->count();
            array_push($notapproved, $query);
        }
        return $notapproved;
    }

    function statisticEventsTo(){
        $year = date('Y');
        $eventsAll = $this->getEvents($year);
        return view('modules.events.grafic', compact('eventsAll'));
    }

    function getEvents($year){
        $result = array();
        $completed = array();
        $typeEvents = Eventcreation::all();
        foreach ($typeEvents as $type) {
            for ($i=1; $i <= 12; $i++) { 
                $countEvent = Eventdiary::whereBetween('edDate', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->where('edCreation_id',$type->crId)->count();
                $result[$i][0] = $type->crName;
                $result[$i][1] = $countEvent;         
            }
            array_push($completed,$result);
        }
        return $completed;
    }

    // CONSULTAR POR CADA TIPO DE EVENTO
    function getRefreshEvents(Request $request){
        $eventsAll = $this->getEvents($request->year);
        return response()->json($eventsAll);
    }


    // ESTADISTICA DE VENTAS DE => FINANCIERA >> DOCUMENTOS CONTABLES

    function statisticSalesTo(){
        $year = date('Y');
        $salesAll = $this->getSales($year);
        return view('modules.balances.statistic', compact('salesAll'));
    }

    function statisticSalesFilter(Request $request){
        $salesAll = $this->getSales(trim($request->year));
        return $salesAll;
    }

    function getSales($year){
        $result = array();
        for ($i=1; $i <= 12; $i++) {
            $factures = Facturation::whereBetween('facDateInitial', [$year . '-' . $this->getMount($i) . '-01' , $year . '-' . $this->getMount($i) . '-' . $this->numberDays($this->getMount($i),$year)])->where('facStatus','PAGADO')->get();
            $total = 0;
            foreach ($factures as $facture) {
                $total += $facture->facValue;
            }
            $result[$i] = $total;        
        }
        return $result;
    }
}
