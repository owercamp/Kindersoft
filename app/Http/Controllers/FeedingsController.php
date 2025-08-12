<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Feeding;
use Illuminate\Http\Request;

class FeedingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $feedings = Feeding::all();
        return view('modules.feedings.index', compact('feedings'));
    }

    function editFeeding($id){ 
        $feeding = Feeding::find($id);
        return view('modules.feedings.edit', compact('feeding')); 
    }

    function updateFeeding(Request $request, $id){
        try{
            $feedingUpdate = Feeding::where('feeConcept', trim(ucfirst(strtolower($request->feeConcept))))
                            ->where('feeValue', trim($request->feeValue))
                            ->first();
            if($feedingUpdate == null){
                $feeding = Feeding::find($id);
                $feeding->feeConcept = trim(ucfirst(strtolower($request->feeConcept)));
                $feeding->feeValue = $request->feeValue;
                $feeding->save();
                return redirect()->route('feedings')->with('PrimaryUpdateFeeding', 'Registro: ' . ucfirst(strtolower($request->feeConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('feedings')->with('SecondarySaveFeeding', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->feeConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('feedings')->with('SecondaryUpdateFeeding', 'Error!!, No es posible actualizar el concepto de alimentación');
        }
    }

    function deleteFeeding($id){
        try{
            $feeding = Feeding::find($id);
            $namefeeding = $feeding->feeConcept;
            $feeding->delete();
            return redirect()->route('feedings')->with('WarningDeleteFeeding', 'Registro: ' . $namefeeding . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('feedings')->with('SecondaryDeleteFeeding', 'Error!!, No es posible eliminar el concepto de alimentación');
        }
    }

    function newFeeding(Request $request){
        try{
            $feedingSave = Feeding::where('feeConcept', trim(ucfirst(strtolower($request->feeConcept))))->first();
            if($feedingSave == null){
                Feeding::create([
                    'feeConcept' => trim(ucfirst(strtolower($request->feeConcept))),
                    'feeValue' => trim($request->feeValue),
                ]);
                return redirect()->route('feedings')->with('SuccessSaveFeeding', 'Registro: ' . ucfirst(strtolower($request->feeConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('feedings')->with('SecondarySaveFeeding', 'Ya existe un registro ' . ucfirst(strtolower($request->feeConcept)));
            }
            /* Feeding::firstOrCreate([
                    'feeConcept' => ucfirst(strtolower($request->feeConcept)),
                ],[
                    'feeConcept' => ucfirst(strtolower($request->feeConcept)),
                    'feeValue' => $request->feeValue,
                ]
            );
            return redirect()->route('feedings')->with('SuccessSaveFeeding', 'Registro: ' . ucfirst(strtolower($request->feeConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('feedings')->with('SecondarySaveFeeding', 'Error!!, No es posible crear el concepto de alimentación');
        }
    }
}
