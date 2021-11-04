<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Garden;
use App\Models\Customer;
use App\Models\Scheduling;
use App\Models\Proposal;
use App\Mail\MessageRemember;

class customersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $customers = Customer::select(
            'customers.id as cusId',
            'customers.*'
        )->get();
        $customerInactive = array();
        foreach ($customers as $customer) {
            if($customer->cusVisible == 'ACTIVO'){
                $scheduling = Scheduling::where('schCustomer_id',$customer->cusId)
                                        ->where('schStatusVisit','ACTIVO')
                                        ->where('schResultVisit','PENDIENTE')
                                        ->first();
                if($scheduling === null){
                    array_push($customerInactive, [
                        $customer->id,
                        $customer->cusFirstname . ' ' . $customer->cusLastname,
                        $customer->cusPhone,
                        $customer->cusMail,
                        $customer->cusContact,
                        $customer->cusChild,
                        $customer->cusChildYearsold,
                        $customer->cusNotes
                    ]);
                }
            }
        }
       return view('modules.customers.scheduling', compact('customerInactive'));
    }

    function editCustomer($id){ 
        $customer = Customer::find($id);
        $scheduling = Scheduling::where('schCustomer_id',$customer->id)->get()->count();
         return view('modules.customers.editCustomer', compact('customer','scheduling'));
    }

    function updateCustomer(Request $request, $id){
        try{
            $customerUpdate = Customer::where('cusFirstname',mb_strtoupper(trim($request->cusFirstname)))
                                        ->where('cusPhone',trim($request->cusPhone))
                                        ->where('id','!=',$id)
                                        ->first();
            if($customerUpdate == null){
                $customer = Customer::find($id);
                $customer->cusFirstname = mb_strtoupper(trim($request->cusFirstname));
                $customer->cusLastname = mb_strtoupper(trim($request->cusLastname));
                $customer->cusPhone  = trim($request->cusPhone);
                $customer->cusMail = trim(strtolower($request->cusMail));
                $customer->cusContact = mb_strtoupper(trim($request->cusContact));
                $customer->cusChild = mb_strtoupper(trim($request->cusChild));
                if(trim($request->cusChildYears) !== '' && trim($request->cusChildMount) !== ''){
                    $customer->cusChildYearsold = 'AÑOS(' . trim($request->cusChildYears) . ') - MESES(' . trim($request->cusChildMount) . ')';
                }
                $customer->cusNotes = mb_strtoupper(trim($request->cusNotes));
                $customer->save();
                return redirect()->route('customers')->with('PrimaryUpdateCustomer', 'Registro de: ' . $request->cusFirstname . ' ' . $request->cusLastname . ' actualizado correctamente');
            }else{
                if($customerUpdate->id != $request->id){
                    return redirect()->route('customers')->with('SecondarySaveCustomer', 'Registro ' . $request->cusFirstname . ' NO ACTUALIZADO, Ya existe un registro con los datos modificados');
                }else{
                    $customer = Customer::find($id);
                    if($customer->cusFirstname !== mb_strtoupper(trim($request->cusFirstname)) ||
                        $customer->cusFirstname !== mb_strtoupper(trim($request->cusFirstname)) ||
                        $customer->cusPhone  !== trim($request->cusPhone) ||
                        $customer->cusMail !== trim(strtolower($request->cusMail)) ||
                        $customer->cusContact !== mb_strtoupper(trim($request->cusContact)) ||
                        $customer->cusChild !== mb_strtoupper(trim($request->cusChild)) ||
                        $customer->cusNotes !== mb_strtoupper(trim($request->cusNotes))
                    ){
                        $customer->cusFirstname = mb_strtoupper(trim($request->cusFirstname));
                        $customer->cusLastname = mb_strtoupper(trim($request->cusLastname));
                        $customer->cusPhone  = trim($request->cusPhone);
                        $customer->cusMail = trim(strtolower($request->cusMail));
                        $customer->cusContact = trim(strtolower($request->cusContact));
                        $customer->cusChild = mb_strtoupper(trim($request->cusChild));
                        if(trim($request->cusChildYears) !== '' && trim($request->cusChildMount) !== ''){
                            $customer->cusChildYearsold = 'AÑOS(' . trim($request->cusChildYears) . ') - MESES(' . trim($request->cusChildMount) . ')';
                        }
                        $customer->cusNotes = mb_strtoupper(trim($request->cusNotes));
                        $customer->save();
                        return redirect()->route('customers')->with('PrimaryUpdateCustomer', 'Registro de: ' . mb_strtoupper(trim($request->cusFirstname)) . ' ' . mb_strtoupper(trim($request->cusLastname)) . ', actualizado correctamente');
                    }else{
                        return redirect()->route('customers')->with('SecondaryUpdateCustomer', 'Registro sin ningun cambio');
                    }
                }
            }
        }catch(Exception $ex){
            return redirect()->route('customers')->with('SecondaryUpdateCustomer', 'Error!!, No fue posible actualizar el registro');
        }   
    }

    function deleteCustomer($id){
        try{
            //Eliminación en cascada de la clientes y agendamientos relacionados
            // 1.) Buscar el cliente a eliminar
            $customer = Customer::find($id);
            // 2.) Guardar nombre para mensaje final
            $nameCustomer = $customer->cusFirstname . " " . $customer->cusLastname;
            // 3.) Buscar el agendamiento PENDIENTE relacionados con el cliente
            $schedulings = Scheduling::where('schCustomer_id', $customer->id)->where('schResultVisit','PENDIENTE')->first();
            // 4.) actualizar el agendamiento pendiente a estado: INACTIVO-INASISTIDO
            if($schedulings !== null){
                $schedulings->schStatusVisit = 'INACTIVO';
                $schedulings->schResultVisit = 'INASISTIDO';
                $schedulings->schCustomer_id = null;
                $schedulings->save();
            }
            // 5.) Eliminar al cliente
            $customer->cusVisible = 'INACTIVO';
            $customer->save();
            return redirect()->route('customers')->with('WarningDeleteCustomer', 'Registro ' . $nameCustomer . ', eliminado correctamente');
        }catch(Exception $ex){
             return redirect()->route('customers')->with('SecondaryDeleteCustomer', 'Error!!, No fue posible eliminar el registro');
        }  
    }

    function newCustomer(Request $request){
        return view('modules.customers.newCustomer');
    }

    function saveCustomer(Request $request){
        try{
            $customerSave = Customer::where('cusFirstname',mb_strtoupper(trim($request->cusFirstname)))
                                    ->where('cusPhone',trim($request->cusPhone))
                                    ->where('cusChild',mb_strtoupper(trim($request->cusChild)))
                                    ->first();
            if($customerSave == null){
                Customer::create([
                    'cusFirstname' => mb_strtoupper(trim($request->cusFirstname)),
                    'cusLastname' => mb_strtoupper(trim($request->cusLastname)),
                    'cusPhone' => trim($request->cusPhone),
                    'cusMail' => trim(strtolower($request->cusMail)),
                    'cusContact' => mb_strtoupper(trim($request->cusContact)),
                    'cusChild' => mb_strtoupper(trim($request->cusChild)),
                    'cusChildYearsold' => 'AÑOS(' . trim($request->cusChildYears) . ') - MESES(' . trim($request->cusChildMount) . ')',
                    'cusNotes' => mb_strtoupper(trim($request->cusNotes)),
                ]);
                //SI EL USUARIO ACEPTA HACER UN AGENDAMIENTO DE UNA VEZ PARA EL NUEVO USUARIO
                if($request->schedule == 'SI'){
                    $customerWithSchedule = Customer::where('cusFirstname',mb_strtoupper(trim($request->cusFirstname)))
                                                    ->where('cusChild',mb_strtoupper(trim($request->cusChild)))
                                                    ->first();
                    $selectIdCustomer = $customerWithSchedule->id;
                    Scheduling::FirstOrCreate([
                        'schCustomer_id' => $selectIdCustomer,
                        'schDateVisit' => trim($request->cusDateVisit),
                        'schDayVisit' => trim($request->cusDayVisit),
                        'schHourVisit' => trim($request->cusHourVisit),
                    ],[
                        'schCustomer_id' => $selectIdCustomer,
                        'schDateVisit' => trim($request->cusDateVisit),
                        'schDayVisit' => trim($request->cusDayVisit),
                        'schHourVisit' => trim($request->cusHourVisit),
                    ]);
                    return redirect()->route('customer.new')->with('SuccessSaveCustomer', 'Registro de: ' . mb_strtoupper(trim($request->cusFirstname)) . ' ' . mb_strtoupper(trim($request->cusLastname)) . ' creado correctamente con una cita programada, Consulte en el menú lateral en la opción AGENDAMIENTO');

                }else if($request->schedule == 'NO'){
                    return redirect()->route('customer.new')->with('SuccessSaveCustomer', 'Registro de: ' . mb_strtoupper(trim($request->cusFirstname)) . ' ' . mb_strtoupper(trim($request->cusLastname)) . ' creado correctamente sin cita programada, , Consulte en el menú lateral en la opción REGISTROS');
                }
            }else{
                 return redirect()->route('customer.new')->with('SecondarySaveCustomer', 'Ya existe el cliente ' . mb_strtoupper(trim($request->cusFirstname)));
            }
        }catch(Exception $ex){
            return redirect()->route('customer.new')->with('SecondarySavecustomer', 'Error!! No es posible crear el registro');
        } 
    }

    function newAgenda(){
        $customers = Customer::select(
            'customers.id as cusId',
            'customers.*',
            'schedulings.*'
        )->join('schedulings','schedulings.schCustomer_id','customers.id')
        ->where('schStatusVisit','ACTIVO')
        ->get();
        return view('modules.customers.newAgenda', compact('customers'));
    }

    function rememberMail(Request $request){
        $garden = Garden::select('garden.*','citys.name as nameCity','locations.name as nameLocation')
                        ->join('citys','citys.id','garden.garCity_id')
                        ->join('locations','locations.id','garden.garLocation_id')
                        ->first();
        $datesMail = array();
        array_push($datesMail, [
            $request->customer_forMail,
            $request->day_forMail,
            $request->date_forMail,
            $request->hour_forMail,
            $request->student_forMail,
            $garden->garReasonsocial,
            $garden->garAddress . ', ' . $garden->nameCity . ' - ' . $garden->nameLocation,
            'TELs: ' . $garden->garPhone . ' / ' . $garden->garPhoneone
        ]);
        if(trim($request->mail_forMail) != ''){
            Mail::to(trim($request->mail_forMail))
                ->cc(['irma.vargas@colchildren.com.co','erika.pertuz@colchildren.com.co'])
                ->queue(new MessageRemember($datesMail));
            $scheduling = Scheduling::find($request->idScheduling_forMail);
            $scheduling->schMails++;
            $countMails = $scheduling->schMails;
            $scheduling->save();
            return redirect()->route('newAgenda')->with('SuccessMailCustomer', 'CORREO A ' . $request->customer_forMail . ' ENVIADO.');
        }else{
            return redirect()->route('newAgenda')->with('SecondaryMailCustomer', 'NO ES POSIBLE ENVIAR, CORREO DE CLIENTE VACIO.');
        }
    }

    function reschedulingCustomer(Request $request){
        dd($request->all());
    }
}
