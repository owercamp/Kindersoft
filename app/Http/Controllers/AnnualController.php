<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Annual;

use Illuminate\Http\Request;
use App\Models\Coststructure;
use Illuminate\Support\Facades\DB;

class AnnualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function budgetTo(){
    	// $annuals = Annual::all(); 
    	$annuals = Annual::select(
    		'annual.*',
    		'costDescription.cdId',
    		'costDescription.cdDescription',
    		'costStructure.csId',
    		'costStructure.csDescription'
    	)
    	->join('costDescription','costDescription.cdId','annual.aCostDescription_id')
    	->join('costStructure','costStructure.csId','costDescription.cdCoststructure_id')
    	->get();
    	$structures = Coststructure::all(); 
        return view('modules.analysis.budget',compact('annuals','structures'));
    }

    function budgetSave(Request $request){
    	try{
    		/*
				$request->aYear_new
				$request->aCoststructure_new
				$request->aCostdescription_new
				$request->january_new
				$request->february_new
				$request->march_new
				$request->april_new
				$request->may_new
				$request->june_new
				$request->july_new
				$request->august_new
				$request->september_new
				$request->october_new
				$request->november_new
				$request->december_new
				$request->aValue_new
    		*/
			$datenow = Date('Y-m-d');
			$validateAnnual = Annual::where('aYear',$request->aYear_new)->where('aCostDescription_id',trim($request->aCostdescription_new))->first();
			// $validateAnnual = Annual::where('aYear',$request->aYear_new)->first();
			if($validateAnnual == null){
				$aDetailsMount = '';
				$aDetailsMount .= 'ENERO:' . $request->january_new . '-';
				$aDetailsMount .= 'FEBRERO:' . $request->february_new . '-';
				$aDetailsMount .= 'MARZO:' . $request->march_new . '-';
				$aDetailsMount .= 'ABRIL:' . $request->april_new . '-';
				$aDetailsMount .= 'MAYO:' . $request->may_new . '-';
				$aDetailsMount .= 'JUNIO:' . $request->june_new . '-';
				$aDetailsMount .= 'JULIO:' . $request->july_new . '-';
				$aDetailsMount .= 'AGOSTO:' . $request->august_new . '-';
				$aDetailsMount .= 'SEPTIEMBRE:' . $request->september_new . '-';
				$aDetailsMount .= 'OCTUBRE:' . $request->october_new . '-';
				$aDetailsMount .= 'NOVIEMBRE:' . $request->november_new . '-';
				$aDetailsMount .= 'DICIEMBRE:' . $request->december_new;
				Annual::create([
					'aYear' => trim($request->aYear_new),
                    'aCostDescription_id' => trim($request->aCostdescription_new),
                    'aValue' => trim($request->aValue_new),
                    'aDetailsMount' => $aDetailsMount,
                    'aDate' => $datenow
				]);
				return redirect()->route('analysis.budget')->with('SuccessCreateBudget', 'Presupuesto guardado correctamente, consulte la tabla');
			}else{
				return redirect()->route('analysis.budget')->with('SecondaryCreateBudget', 'Ya existe un presupuesto creado para el año seleccionado');
			}
    	}catch(Exception $ex){
    		return redirect()->route('analysis.budget')->with('SecondaryCreateBudget', 'No es posible procesar la solicitud, comuniquese con el administrador');
    	}
    }

    public function budgetUpdate(Request $request){
    	try{
    		/*
				$request->aYear_edit
				$request->aCoststructure_edit
				$request->aCostdescription_edit
				$request->january_edit
				$request->february_edit
				$request->march_edit
				$request->april_edit
				$request->may_edit
				$request->june_edit
				$request->july_edit
				$request->august_edit
				$request->september_edit
				$request->october_edit
				$request->november_edit
				$request->december_edit
				$request->aValue_edit
				$request->aId_edit
    		*/

			$validateAnnual = Annual::find(trim($request->aId_edit));
			if($validateAnnual != null){
				$aDetailsMount = '';
				$aDetailsMount .= 'ENERO:' . $request->january_edit . '-';
				$aDetailsMount .= 'FEBRERO:' . $request->february_edit . '-';
				$aDetailsMount .= 'MARZO:' . $request->march_edit . '-';
				$aDetailsMount .= 'ABRIL:' . $request->april_edit . '-';
				$aDetailsMount .= 'MAYO:' . $request->may_edit . '-';
				$aDetailsMount .= 'JUNIO:' . $request->june_edit . '-';
				$aDetailsMount .= 'JULIO:' . $request->july_edit . '-';
				$aDetailsMount .= 'AGOSTO:' . $request->august_edit . '-';
				$aDetailsMount .= 'SEPTIEMBRE:' . $request->september_edit . '-';
				$aDetailsMount .= 'OCTUBRE:' . $request->october_edit . '-';
				$aDetailsMount .= 'NOVIEMBRE:' . $request->november_edit . '-';
				$aDetailsMount .= 'DICIEMBRE:' . $request->december_edit;
				$validateAnnual->aYear = trim($request->aYear_edit);
	            $validateAnnual->aCostDescription_id = trim($request->aCostdescription_edit);
	            $validateAnnual->aValue = trim($request->aValue_edit);
	            $validateAnnual->aDetailsMount = $aDetailsMount;
	            $validateAnnual->save();
            	return redirect()->route('analysis.budget')->with('PrimaryUpdateBudget', 'Modificaciones guardadas correctamente, Consulte la tabla');
			}else{
            	return redirect()->route('analysis.budget')->with('SecondaryUpdateBudget', 'No se encuentra el presupuesto, No fue posible guardar los cambios');
			}
    	}catch(Exception $ex){
    		return redirect()->route('analysis.budget')->with('SecondaryUpdateBudget', 'No es posible procesar la solicitud, comuniquese con el administrador');
    	}
    }

    public function budgetDelete(Request $request){
    	try{
    		/*
				$request->aId_delete
    		*/
			$validateAnnual = Annual::find(trim($request->aId_delete));
			$validateAnnual->delete();
			return redirect()->route('analysis.budget')->with('WarningDeleteBudget', 'Presupuesto eliminado correctamente');
    	}catch(Exception $ex){
    		return redirect()->route('analysis.budget')->with('SecondaryDeleteBudget', 'No es posible procesar la solicitud, comuniquese con el administrador');
    	}
    }

}
