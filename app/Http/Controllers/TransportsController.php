<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Transport;
use Illuminate\Http\Request;

class TransportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $transports = Transport::all();
        return view('modules.transports.index', compact('transports'));
    }

    function editTransport($id){ 
        $transport = Transport::find($id);
        return view('modules.transports.edit', compact('transport')); 
    }

    function updateTransport(Request $request, $id){
        try{
            $transportUpdate = Transport::where('traConcept', trim(ucfirst(strtolower($request->traConcept))))
                                ->where('traValue', trim($request->traValue))
                                ->first();
            if($transportUpdate == null){
                $transport = Transport::find($id);
                $transport->traConcept = trim(ucfirst(strtolower($request->traConcept)));
                $transport->traValue = trim($request->traValue);
                $transport->save();
                return redirect()->route('transports')->with('PrimaryUpdateTransport', 'Registro: ' . ucfirst(strtolower($request->traConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('transports')->with('SecondarySaveTransport', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->traConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('transports')->with('SecondaryUpdateTransport', 'Error!!, No es posible actualizar el concepto de transporte');
        }
    }

    function deleteTransport($id){
        try{
            $transport = Transport::find($id);
            $nametransport = $transport->traConcept;
            $transport->delete();
            return redirect()->route('transports')->with('WarningDeleteTransport', 'Registro: ' . $nametransport . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('transports')->with('SecondaryDeleteTransport', 'Error!!, No es posible eliminar el concepto de transporte');
        }
    }

    function newTransport(Request $request){
        try{
            $transportSave = Transport::where('traConcept', trim(ucfirst(strtolower($request->traConcept))))->first();
            if($transportSave == null){
                Transport::create([
                    'traConcept' => trim(ucfirst(strtolower($request->traConcept))),
                    'traValue' => trim($request->traValue),
                ]);
                return redirect()->route('transports')->with('SuccessSaveTransport', 'Registro: ' . ucfirst(strtolower($request->traConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('transports')->with('SecondarySaveTransport', 'Ya existe un registro ' . ucfirst(strtolower($request->traConcept)));
            }
            /* Transport::firstOrCreate([
                    'traConcept' => ucfirst(strtolower($request->traConcept)),
                ],[
                    'traConcept' => ucfirst(strtolower($request->traConcept)),
                    'traValue' => $request->traValue,
                ]
            );
            return redirect()->route('transports')->with('SuccessSaveTransport', 'Registro: ' . ucfirst(strtolower($request->traConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('transports')->with('SecondarySaveTransport', 'Error!!, No es posible crear el concepto de transporte');
        }
    }
}
