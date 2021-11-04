<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
//use Illuminate\Database\DatabaseManager;

use App\Models\Customer;
use App\Models\Scheduling;

class SchedulingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $customers = Customer::all();
        return view('modules.customers.programming', compact('customers'));
    }

    public function getScheduling(){
        $schedulings = Scheduling::select('schedulings.id as id','schedulings.schDateVisit as start','schedulings.schColor as color', DB::raw("CONCAT(schedulings.schHourVisit,' ',customers.cusFirstname,' ',customers.cusLastname)  AS title"))->join('customers','customers.id','schedulings.schCustomer_id')->get()->toArray();
        //dd($schedulings);
        return response()->json($schedulings);
    }

    function saveCustomerAndScheduling(Request $request){
        try{
            //dd($request->optionOld);
            if($request->optionOld == 'SI'){//SI EL CLIENTE YA EXISTE Y SOLO SE QUIERE AGENDAR CITA
                $schedulings = Scheduling::where('schCustomer_id',$request->schCustomer_id)
                                        ->where('schResultVisit','PENDIENTE')
                                        ->first();
                if($schedulings == null){
                    Scheduling::create([
                        'schCustomer_id' => trim($request->schCustomer_id),
                        'schDateVisit' => trim($request->schDateVisit),
                        'schDayVisit' => trim($request->schDayVisit),
                        'schHourVisit' => trim($request->schHourVisit),
                    ]);
                    return redirect()->route('programming')->with('SuccessSaveProgramming', 'CITA ASIGNADA CORRECTAMENTE');
                }else{
                    return redirect()->route('programming')->with('SecondarySaveProgramming', 'CLIENTE SELECCIONADO YA CUENTE CON UNA CITA QUE ESTA PENDIENTE DE ASISTENCIA');
                }
            }else if($request->optionOld == 'NO'){//SI EL CLIENTE ES NUEVO, SE CREA EL REGISTRO Y SE LE AGENDA LA CITA
                $customerSave = Customer::where('cusFirstname',trim(ucfirst(strtolower($request->cusFirstname))))
                                    ->where('cusPhone',trim(ucfirst(strtolower($request->cusPhone))))
                                    ->where('cusChild',trim(ucfirst(strtolower($request->cusChild))))
                                    ->first();
                if($customerSave == null){
                    Customer::create([
                        'cusFirstname' => trim(ucfirst(strtolower($request->cusFirstname))),
                        'cusLastname' => trim(ucfirst(strtolower($request->cusLastname))),
                        'cusPhone' => trim($request->cusPhone),
                        'cusMail' => trim(strtolower($request->cusMail)),
                        'cusChild' => trim(ucfirst(strtolower($request->cusChild))),
                        'cusChildYearsold' => trim($request->cusChildYearsold),
                        'cusNotes' => trim($request->cusNotes),
                    ]);

                    $customerNew = Customer::where('cusFirstname',trim(ucfirst(strtolower($request->cusFirstname))))
                                    ->where('cusPhone',trim(ucfirst(strtolower($request->cusPhone))))
                                    ->where('cusChild',trim(ucfirst(strtolower($request->cusChild))))
                                    ->first();

                    Scheduling::create([
                        'schCustomer_id' => trim($customerNew->id),
                        'schDateVisit' => trim($request->schDateVisit),
                        'schDayVisit' => trim($request->schDayVisit),
                        'schHourVisit' => trim($request->schHourVisit),
                    ]);
                    return redirect()->route('programming')->with('SuccessSaveProgramming', 'Cliente ' . trim(ucfirst(strtolower($request->cusFirstname))) . ' con cita para el ' . trim($request->schDateVisit) . ', creada correctamente');
                }else{
                    return redirect()->route('programming')->with('SecondarySaveProgramming', 'Ya existe el cliente ingresado ' . trim(ucfirst(strtolower($request->cusFirstname))) . ', Seleccione cliente existente para asignarle una cita');
                }
            }
        }catch(Exception $ex){
             return redirect()->route('programming')->with('SecondarySaveProgramming', 'Error!! No es posible finalizar el proceso');
        } 
    }

    function saveScheduling(Request $request){
        try{
            $schedulings = Scheduling::where('schCustomer_id',$request->schCustomer_id)
                                    ->where('schResultVisit','PENDIENTE')
                                    ->first();
            if($schedulings == null){
                Scheduling::create([
                    'schCustomer_id' => trim($request->schCustomer_id),
                    'schDateVisit' => trim($request->schDateVisit),
                    'schDayVisit' => trim($request->schDayVisit),
                    'schHourVisit' => trim($request->schHourVisit),
                ]);
                return redirect()->route('customers')->with('SuccessSaveScheduling', "CITA ASIGNADA CORRECTAMENTE, CONSULTE EN LA OPCION 'AGENDAMIENTO' DEL MENU LATERAL");
            }else{
                return redirect()->route('customers')->with('SecondarySaveScheduling', "CLIENTE SELECCIONADO YA CUENTE CON UNA CITA QUE ESTA PENDIENTE DE ASISTENCIA PARA EL " . $schedulings->schDayVisit  . " " . $schedulings->schDateVisit . ", CONSULTE EN LA OPCION 'AGENDAMIENTO' DEL MENU LATERAL");
            }
        }catch(Exception $ex){
            return redirect()->route('customers')->with('SecondarySaveScheduling', 'NO ES POSIBLE CREAR LA CITA PARA EL CLIENTE, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function reprogrammingScheduling(Request $request){
        //dd($request->all());
        try{
            $scheduling = Scheduling::find($request->schId);
            if($scheduling !== null){
                $scheduling->schDateVisit = $request->schDateVisit_new;
                $scheduling->schDayVisit = $request->schDayVisit_new;
                $scheduling->schHourVisit = $request->schHourVisit_new;
                $scheduling->schColor = '#0086f9';//AZUL
                $customer = Customer::find($scheduling->schCustomer_id);
                $scheduling->save();
                return redirect()->route('newAgenda')->with('SuccessSaveCustomerAgenda', "CITA REPROGRAMADA CORRECTAMENTE PARA " . $customer->cusFirstname . ' ' . $customer->cusLastname);
            }
        }catch(Exception $ex){
            return redirect()->route('newAgenda')->with('SecondarySaveCustomerAgenda', 'NO ES POSIBLE REPROGRAMAR LA CITA PARA EL CLIENTE, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function changeScheduling(Request $request){
        //dd($request->all());
        try{
            $scheduling = Scheduling::find($request->schId);
            if($scheduling !== null){
                $scheduling->schResultVisit = mb_strtoupper(trim($request->schResultVisit_change));
                $scheduling->schStatusVisit = 'INACTIVO';
                $scheduling->schObservation = mb_strtoupper(trim($request->schObservation_change));
                if(mb_strtoupper(trim($request->schResultVisit_change)) == 'ASISTIDO'){
                    $scheduling->schColor = '#a4b068';//VERDE
                }else{
                    $scheduling->schColor = '#fd8701';//NARANJA
                }
                $customer = Customer::find($scheduling->schCustomer_id);
                $scheduling->save();
                return redirect()->route('newAgenda')->with('PrimaryUpdateCustomerAgenda', "ESTADO DE CITA CAMBIADO CORRECTAMENTE PARA " . $customer->cusFirstname . ' ' . $customer->cusLastname);
            }
        }catch(Exception $ex){
            return redirect()->route('newAgenda')->with('SecondaryUpdateCustomerAgenda', 'NO ES POSIBLE CAMBIAR EL ESTADO DE LA CITA PARA EL CLIENTE, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
}
