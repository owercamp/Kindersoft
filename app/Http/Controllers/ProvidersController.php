<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;
use App\Models\Health;
use App\Models\District;
use App\Models\Document;
use App\Models\Location;
use App\Models\Provider;
use App\Models\Bloodtype;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $providers = Provider::all();
       return view('modules.providers.index', compact('providers'));
    }

    function editProvider($id){ 
        $provider = Provider::find($id);
        $documents = Document::all();
        $citys = City::all();
         return view('modules.providers.edit', compact('provider','documents','citys'));
    }

    function updateProvider(Request $request, $id){
        try{
            $providerUpdate = Provider::where('typedocument_id', trim($request->typedocument_id_edit))
                                ->where('numberdocument', trim($request->numberdocument_edit))
                                ->where('id','!=',$id)
                                ->first();
            if($providerUpdate == null){
                $provider = Provider::find($id);
                $provider->typedocument_id = $request->typedocument_id_edit;
                $provider->numberdocument = $request->numberdocument_edit;
                $provider->numbercheck  = $request->numbercheck_edit;
                $provider->namecompany = $request->namecompany_edit;
                $provider->address = $request->address_edit;
                $provider->cityhome_id = $request->cityhome_id_edit;
                $provider->locationhome_id = $request->locationhome_id_edit;
                $provider->dictricthome_id = $request->dictricthome_id_edit;
                $provider->phoneone = $request->phoneone_edit;
                $provider->phonetwo = $request->phonetwo_edit;
                $provider->whatsapp = $request->whatsapp_edit;
                $provider->emailone = $request->emailone_edit;
                $provider->emailtwo = $request->emailtwo_edit;
                $provider->save();
                return redirect()->route('providers')->with('PrimaryUpdateProvider', 'Registro con ID: ' . $request->numberdocument_edit . ' actualizado correctamente');
            }else{
                return redirect()->route('providers')->with('SecondaryUpdateProvider', 'Ya existe un proveedor con el tipo y numero de identificación');
            }
                
        }catch(Exception $ex){
            return redirect()->route('providers')->with('SecondaryUpdateProvider', 'No fue posible actualizar el registro ahora, comuniquese con el administrador');
        }   
    }

    function deleteProvider($id){
        try{
            $provider = Provider::find($id);
            $names = $provider->namecompany . " con ID: " . $provider->numberdocument;
            $provider->delete();
            return redirect()->route('providers')->with('WarningDeleteProvider', 'Registro ' . $names . ' eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('providers')->with('SecondaryDeleteProvider', 'No fue posible eliminar el registro ahora, comuniquese con el administrador');
        }
        
    }

    function newProvider(Request $request){
        $providers = Provider::all();
        $documents = Document::all();
        $citys = City::all();
        return view('modules.providers.new', compact('providers','documents','citys'));
    }

     function saveProvider(Request $request){
        try{
            $providerSave = Provider::where('typedocument_id', trim($request->typedocument_id))
                                ->where('numberdocument', trim($request->numberdocument))
                                ->first();
            if($providerSave == null){
                Provider::create([
                        'typedocument_id' => $request->typedocument_id,
                        'numberdocument' => $request->numberdocument,
                        'numbercheck' => $request->numbercheck,
                        'namecompany' => $request->namecompany,
                        'address' => $request->address,
                        'cityhome_id' => $request->cityhome_id,
                        'locationhome_id' => $request->locationhome_id,
                        'dictricthome_id' => $request->dictricthome_id,
                        'phoneone' => $request->phoneone,
                        'phonetwo' => $request->phonetwo,
                        'whatsapp' => $request->whatsapp,
                        'emailone' => $request->emailone,
                        'emailtwo' => $request->emailtwo
                    ]);
                return redirect()->route('provider.new')->with('SuccessSaveProvider', 'Registro con ID: ' . $request->numberdocument . ' creado correctamente');
            }else{
                return redirect()->route('provider.new')->with('SecondarySaveProvider', 'Ya existe un proveedor con el tipo y numero de identificación ingresado');
            }
                
        }catch(Exception $ex){
            return redirect()->route('provider.new')->with('SecondarySaveProvider', 'No es posible crear el registro ahora, comuniquese con el administrador');
        } 
    }

     function detailsProvider($id){
        $provider = Provider::find($id);
        $documents = Document::all();
        $citys = City::all();
        $locations = Location::all();
        $districts = District::all();
        return view('modules.providers.details', compact('provider','documents','citys','locations','districts'));
    }
}
