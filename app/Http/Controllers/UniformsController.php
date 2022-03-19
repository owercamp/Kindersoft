<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Uniform;
use Illuminate\Http\Request;

class UniformsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $uniforms = Uniform::all();
        return view('modules.uniforms.index', compact('uniforms'));
    }

    function editUniform($id){ 
        $uniform = Uniform::find($id);
        return view('modules.uniforms.edit', compact('uniform')); 
    }

    function updateUniform(Request $request, $id){
        try{
            $uniformUpdate = Uniform::where('uniConcept', trim(ucfirst(strtolower($request->uniConcept))))
                            ->where('uniValue', trim($request->uniValue))
                            ->first();
            if($uniformUpdate == null){
                $uniform = Uniform::find($id);
                $uniform->uniConcept = trim(ucfirst(strtolower($request->uniConcept)));
                $uniform->uniValue = trim($request->uniValue);
                $uniform->save();
                return redirect()->route('uniforms')->with('PrimaryUpdateUniform', 'Registro: ' . ucfirst(strtolower($request->uniConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('uniforms')->with('SecondarySaveUniform', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->uniConcept)) . ' con el valor indicado');
            }
        }catch(Exception $ex){
            return redirect()->route('uniforms')->with('SecondaryUpdateUniform', 'Error!!, No es posible actualizar el concepto de uniforme');
        }
    }

    function deleteUniform($id){
        try{
            $uniform = Uniform::find($id);
            $nameuniform = $uniform->uniConcept;
            $uniform->delete();
            return redirect()->route('uniforms')->with('WarningDeleteUniform', 'Registro: ' . $nameuniform . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('uniforms')->with('SecondaryDeleteUniform', 'Error!!, No es posible eliminar el concepto de uniforme');
        }
    }

    function newUniform(Request $request){
        try{
            $uniformSave = Uniform::where('uniConcept', trim(ucfirst(strtolower($request->uniConcept))))->first();
            if($uniformSave == null){
                Uniform::create([
                    'uniConcept' => trim(ucfirst(strtolower($request->uniConcept))),
                    'uniValue' => trim($request->uniValue),
                ]);
                return redirect()->route('uniforms')->with('SuccessSaveUniform', 'Registro: ' . ucfirst(strtolower($request->uniConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('uniforms')->with('SecondarySaveUniform', 'Ya existe un registro ' . ucfirst(strtolower($request->uniConcept)));
            }
            /* Uniform::firstOrCreate([
                    'uniConcept' => ucfirst(strtolower($request->uniConcept)),
                ],[
                    'uniConcept' => ucfirst(strtolower($request->uniConcept)),
                    'uniValue' => $request->uniValue,
                ]
            );
            return redirect()->route('uniforms')->with('SuccessSaveUniform', 'Registro: ' . ucfirst(strtolower($request->uniConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('uniforms')->with('SecondarySaveUniform', 'Error!!, No es posible crear el concepto de uniforme');
        }
    }
}
