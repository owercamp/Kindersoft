<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ActivitySpace;



class ActivityspacesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function activitySpaceTo(){
        $activityspaces = ActivitySpace::all();
        return view('modules.structure.activitySpace', compact('activityspaces'));
    }

    function newActivitySpace(Request $request){
        try{
            $activityspaceValidate = ActivitySpace::where('asNumber',$request->asNumber)->orWhere('asSpace',$request->asSpace)->first();
            if($activityspaceValidate == null){
                ActivitySpace::create([
                    'asNumber' => trim($request->asNumber),
                    'asSpace' => trim(ucfirst(mb_strtolower($request->asSpace,'UTF-8'))),
                    'asDescription' => trim(ucfirst(mb_strtolower($request->asDescription,'UTF-8')))
                ]);
                return redirect()->route('activitySpace')->with('SuccessSaveActivitySpace', 'Registro ' . $request->asSpace . ', creado correctamente');
            }else{
                return redirect()->route('activitySpace')->with('SecondarySaveActivitySpace', 'Ya existe un registro con número ' . $request->asNumber . ' o nombre de espacio ' . $request->asSpace);
            }
        }catch(Exception $ex){
            return redirect()->route('activitySpace')->with('SecondarySaveActivitySpace', 'No es posible crear el espacio ahora, Comuníquese con el administrador');
        }
    }

    function updateActivitySpace(Request $request){
        try{
            $activitySpaceValidate = ActivitySpace::where('asId','!=',$request->asIdEdit)
                                                    ->Where('asNumber',trim($request->asNumberEdit))
                                                    ->Where('asSpace',trim(ucfirst(mb_strtolower($request->asSpaceEdit,'UTF-8'))))
                                                    ->first();
            if($activitySpaceValidate == null){
                $activityToUpdate = ActivitySpace::find($request->asIdEdit);
                $activityToUpdate->asNumber = trim($request->asNumberEdit);
                $activityToUpdate->asSpace = trim(ucfirst(mb_strtolower($request->asSpaceEdit,'UTF-8')));
                $activityToUpdate->asDescription = trim(ucfirst(mb_strtolower($request->asDescriptionEdit,'UTF-8')));
                $activityToUpdate->save();
                return redirect()->route('activitySpace')->with('PrimaryUpdateActivitySpace', 'Registro ' . trim(ucfirst(mb_strtolower($request->asSpaceEdit,'UTF-8'))) . ', modificado correctamente');
            }else{
                return redirect()->route('activitySpace')->with('SecondaryUpdateActivitySpace', 'Ya existe un espacio con el numero o nombre modificado');
            }
        }catch(Exception $ex){
            return redirect()->route('activitySpace')->with('SecondaryUpdateActivitySpace', 'No es posible actualizar el espacio ahora, Comuníquese con el administrador');
        }
    }

    function deleteActivitySpace(Request $request){
        try{
            $activityToDelete = ActivitySpace::find($request->asIdDelete);
            $nameActivity = $activityToDelete->asSpace;
            $activityToDelete->delete();
            return redirect()->route('activitySpace')->with('WarningDeleteActivitySpace', 'Registro ' . $nameActivity . ', Eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('activitySpace')->with('SecondaryDeleteActivitySpace', 'No es posible eliminar el registro ahora, Comuníquese con el administrador');
        }
    }
}
