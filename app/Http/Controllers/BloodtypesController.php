<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Bloodtype;
use Illuminate\Http\Request;

class BloodtypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $bloodtypes = Bloodtype::all();
        return view('modules.bloodtypes.index', compact('bloodtypes'));
    }

    function editBloodtype($id){
        $bloodtype = Bloodtype::find($id);
        return view('modules.bloodtypes.edit', compact('bloodtype')); 
    }

    function updateBloodtype(Request $request, $id){
        try{
            $bloodtype = Bloodtype::find($id);
            $bloodtype->group = strtoupper($request->group);
            $bloodtype->type = strtoupper($request->type);
            $bloodtype->save();
            return redirect()->route('bloodtypes')->with('PrimaryUpdateBloodtype', 'Registro: ' . strtoupper($request->group) . ' ' . strtoupper($request->type) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('bloodtypes')->with('SecondaryUpdateBloodtype', 'Error!!, No es posible actualizar el grupo sanguineo');
        }
    }

    function deleteBloodtype($id){
        try{
            $bloodtype = Bloodtype::find($id);
            $namebloodtype = $bloodtype->group . ' ' . $bloodtype->type;
            $bloodtype->delete();
            return redirect()->route('bloodtypes')->with('WarningDeleteBloodtype', 'Registro: ' . $namebloodtype . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('bloodtypes')->with('SecondaryDeleteBloodtype', 'Error!!, No es posible eliminar el grupo sanguineo');
        }
    }

    function newBloodtype(Request $request){
        try{
            if(strtoupper($request->type) !== ''){
                $bloodtypeSave = Bloodtype::where('group',strtoupper($request->group))
                                ->where('type',strtoupper($request->type))
                                ->first();
                if($bloodtypeSave == null){
                    Bloodtype::create([
                        'group' => strtoupper($request->group),
                        'type' => strtoupper($request->type),
                    ]);
                    return redirect()->route('bloodtypes')->with('SuccessSaveBloodtype', 'Registro: ' . strtoupper($request->group) . ' ' . strtoupper($request->type) . ' creado correctamente');
                }else{
                     return redirect()->route('bloodtypes')->with('SecondarySaveBloodtype', 'Ya existe un registro ' . strtoupper($request->group) . ' ' . strtoupper($request->type));
                }
            }else{
                $bloodtypeSave = Bloodtype::where('group',strtoupper($request->group))->first();
                if($bloodtypeSave == null){
                    Bloodtype::create([
                        'group' => strtoupper($request->group),
                        'type' => null,
                    ]);
                    return redirect()->route('bloodtypes')->with('SuccessSaveBloodtype', 'Registro: ' . strtoupper($request->group) . ' creado correctamente');
                }else{
                     return redirect()->route('bloodtypes')->with('SecondarySaveBloodtype', 'Ya existe un registro ' . strtoupper($request->group));
                }
            }
        }catch(Exception $ex){
            return redirect()->route('bloodtypes')->with('SecondarySaveBloodtype', 'Error!!, No es posible crear el grupo sanguineo');
        }
    }
}
