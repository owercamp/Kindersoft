<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NewCollaboratorRequest;

//use Laracasts\Flash\FlashServiceProvider;

use App\Models\Collaborator;
use App\Models\Document;
use App\Models\Bloodtype;
use App\Models\Chronological;
use App\Models\Profession;
use App\Models\City;
use App\Models\CourseConsolidated;
use App\Models\Location;
use App\Models\District;
use App\Models\Eventdiary;
use App\Models\Hourweek;
use Exception;

class CollaboratorsController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }
    function index(){
        $collaborators = Collaborator::all();
        return view('modules.collaborators.index', compact('collaborators'));
    }

    function editCollaborator($id){ 
        $collaborator = Collaborator::find($id);
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        $citys = City::all();
         return view('modules.collaborators.edit', compact('collaborator','documents','bloodtypes','professions','citys'));
    }

    function updateCollaborator(Request $request, $id){
        try{
            $collaboratorUpdate = Collaborator::where('typedocument_id', trim($request->typedocument_id_edit))
                                ->where('numberdocument', trim($request->numberdocument_edit))
                                ->where('id','!=',$id)
                                ->first();
            if($collaboratorUpdate == null){
                if($request->hasFile('photo_edit')){
                    $photo = $request->file('photo_edit');
                    $namephotofinal = trim($request->numberdocument_edit) . '_photo.' . $photo->extension();
                    if($collaboratorUpdate->photo != 'defaultphoto.png'){
                        Storage::disk('kindersoft')->delete('collaborators/'.$collaboratorUpdate->photo);
                    }
                    Storage::disk('kindersoft')->putFileAs('collaborators/',$photo,$namephotofinal);
                }else{
                    if($collaboratorUpdate->photo != 'defaultphoto.png'){
                        $separatedName = explode('_', $collaboratorUpdate->photo);
                        $namephotofinal = trim($request->numberdocument_edit) . '_' . $separatedName[2];
                        if($collaboratorUpdate->photo != $namephotofinal){
                            Storage::disk('kindersoft')->move('collaborators/'.$collaboratorUpdate->photo,'collaborators/'.$namephotofinal);
                        }
                    }else{
                        $namephotofinal = 'defaultphoto.png';
                    }
                }
                if($request->hasFile('firm_edit')){
                    $firm = $request->file('firm_edit');
                    $namefirmfinal = trim($request->numberdocument_edit) . '_firm.' . $photo->extension();
                    if($collaboratorUpdate->firm != null){
                        Storage::disk('kindersoft')->delete('firms/'.$collaboratorUpdate->firm);
                    }
                    Storage::disk('kindersoft')->putFileAs('firms/',$firm,$namefirmfinal);
                }else{
                    if($collaboratorUpdate->firm != null){
                        $separatedName = explode('_', $collaboratorUpdate->firm);
                        $namefirmfinal = trim($request->numberdocument_edit) . '_' . $separatedName[2];
                        if($collaboratorUpdate->firm != $namefirmfinal){
                            Storage::disk('kindersoft')->move('firms/'.$collaboratorUpdate->firm,'firms/'.$namefirmfinal);
                        }
                    }else{
                        $namefirmfinal = null;
                    }
                }
                $collaborator = Collaborator::find($id);
                $collaborator->typedocument_id = trim($request->typedocument_id_edit);
                $collaborator->numberdocument = trim($request->numberdocument_edit);
                $collaborator->firstname = trim(strtoupper($request->firstname_edit));
                $collaborator->threename = trim(strtoupper($request->threename_edit));
                $collaborator->fourname = trim(strtoupper($request->fourname_edit));
                $collaborator->photo = $namephotofinal;
                $collaborator->address = trim(strtoupper($request->address_edit));
                $collaborator->cityhome_id = trim($request->cityhome_id_edit);
                $collaborator->locationhome_id = trim($request->locationhome_id_edit);
                $collaborator->dictricthome_id = trim($request->dictricthome_id_edit);
                $collaborator->phoneone = trim(strtoupper($request->phoneone_edit));
                $collaborator->phonetwo = trim(strtoupper($request->phonetwo_edit));
                $collaborator->whatsapp = trim(strtoupper($request->whatsapp_edit));
                $collaborator->emailone = trim(strtoupper($request->emailone_edit));
                $collaborator->emailtwo = trim(strtoupper($request->emailtwo_edit));
                $collaborator->bloodtype_id = trim($request->bloodtype_id_edit);
                $collaborator->gender = trim($request->gender_edit);
                $collaborator->profession_id = trim($request->profession_id_edit);
                $collaborator->position = trim($request->position_edit);
                $collaborator->firm = $namefirmfinal;
                $collaborator->save();
                return redirect()->route('collaborators')->with('PrimaryUpdateCollaborator', 'COLABORADOR CON ID: ' . $request->numberdocument_edit . ', ACTUALIZADO CORRECTAMENTE');
            }else{
                return redirect()->route('collaborators')->with('SecondaryUpdateCollaborator', 'Registro: ' . ucfirst(strtolower($request->numberdocument_edit)) . ', NO ACTUALIZADO, YA EXISTE UN COLABORADOR CON EL NUMERO INGRESADO');
            }
        }catch(Exception $ex){
            return redirect()->route('collaborators')->with('SecondaryUpdateCollaborator', 'NO ES POSIBLE ACTUALIZAR EL COLABORADOR, COMUNIQUESE CON EL ADMINISTRADOR');
        }   
    }

    function deleteCollaborator($id){
        try{
            // valida que no haya registros relacionados con el colaborador en cursos consolidados
            $coursesconsolidatedCol = CourseConsolidated::where('ccCollaborator_id',trim($id))->first();
            if ($coursesconsolidatedCol == null) {
                // valida que no haya registros relacionados con el colaborador en cronologicos
                $chronologicalsCol = Chronological::where('chCollaborator_id',trim($id))->first();
                if ($chronologicalsCol == null) {
                    // valida que no haya registros relacionados con el colaborador en Eventos Diarios
                    $eventDiaryCol = Eventdiary::where('edCollaborator_id',trim($id))->first();
                    if ($eventDiaryCol == null) {
                        // valida que no haya registros relacionados con el colaborador en cronologicos
                        $hoursweekCol = Hourweek::where('hwCollaborator_id',trim($id))->first();
                        if ($hoursweekCol == null) {
                            $collaborator = Collaborator::find($id);
                            if($collaborator != null){
                                $names = $collaborator->firstname . " con ID: " . $collaborator->numberdocument;
                                if($collaborator->photo != 'defaultphoto.png'){
                                    Storage::disk('kindersoft')->delete('collaborators/'.$collaborator->photo);
                                }
                                if($collaborator->firm != null){
                                    Storage::disk('kindersoft')->delete('firms/'.$collaborator->firm);
                                }
                                $collaborator->delete();
                                return redirect()->route('collaborators')->with('WarningDeleteCollaborator', 'Registro: ' . $names . ', eliminado correctamente');
                            }else{
                                return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'No se encuentra el colaborador');
                            }
                        } else {
                            return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'No pudo ser posible la eliminación del colaborador cuenta con registros relacionados en Horario Semanal');
                        }
                    } else {
                        return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'No pudo ser posible la eliminación del colaborador cuenta con registros relacionados en Eventos Diarios');
                    }
                } else {
                    return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'No pudo ser posible la eliminación del colaborador cuenta con registros relacionados en Planeación Cronológica');
                }
            } else {
                return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'No pudo ser posible la eliminación del colaborador cuenta con registros relacionados en Cursos Consolidados');
            }
        }catch(Exception $ex){
            return redirect()->route('collaborators')->with('SecondaryDeleteCollaborator', 'Error!!, No fue posible eliminar el colaborador');
        }
    }

    function newCollaborator(){
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        $citys = City::all();
        return view('modules.collaborators.new', compact('documents','bloodtypes','professions','citys'));
    }

    function saveCollaborator(Request $request){ //NewCollaboratorRequest
        try{
            // dd($request->all());
            $collaboratorSave = Collaborator::where('typedocument_id', trim($request->typedocument_id))
                                ->where('numberdocument', trim($request->numberdocument))
                                ->first();
            if($collaboratorSave == null){
                if($request->hasFile('photo')){
                    if($request->hasFile('firm')){
                        $photo = $request->file('photo');
                        $firm = $request->file('firm');
                        // $namephoto = $photo->getClientOriginalName();
                        // $namefirm = $firm->getClientOriginalName();
                        $namephoto = trim($request->numberdocument) . '_photo.' . $photo->extension();
                        $namefirm = trim($request->numberdocument) . '_firm.' . $firm->extension();
                        Storage::disk('kindersoft')->putFileAs('collaborators',$photo,$namephoto);
                        Storage::disk('kindersoft')->putFileAs('collaborators',$firm,$namefirm);
                        Collaborator::create([
                            'typedocument_id' => trim($request->typedocument_id),
                            'numberdocument' => trim($request->numberdocument),
                            'firstname' => trim(strtoupper($request->firstname)),
                            'threename' => trim(strtoupper($request->threename)),
                            'fourname' => trim(strtoupper($request->fourname)),
                            'photo' => $namephoto,
                            'address' => trim(strtoupper($request->address)),
                            'cityhome_id' => trim($request->cityhome_id),
                            'locationhome_id' => trim($request->locationhome_id),
                            'dictricthome_id' => trim($request->dictricthome_id),
                            'phoneone' => trim(strtoupper($request->phoneone)),
                            'phonetwo' => trim(strtoupper($request->phonetwo)),
                            'whatsapp' => trim(strtoupper($request->whatsapp)),
                            'emailone' => trim(strtoupper($request->emailone)),
                            'emailtwo' => trim(strtoupper($request->emailtwo)),
                            'bloodtype_id' => trim($request->bloodtype_id),
                            'gender' => trim($request->gender),
                            'profession_id' => trim($request->profession_id),
                            'position' => trim($request->position),
                            'firm' => $namefirm
                        ]);
                         return redirect()->route('collaborator.new')->with('SuccessSaveCollaborator', 'COLABORADOR con ID: ' . $request->numberdocument . ' CREADO CORRECTAMENTE');
                    }else{
                        $photo = $request->file('photo');
                        // $namephoto = $photo->getClientOriginalName();
                        $namephoto = trim($request->numberdocument) . '_photo.' . $photo->extension();
                        Storage::disk('kindersoft')->putFileAs('collaborators',$photo,$namephoto);
                        Collaborator::create([
                            'typedocument_id' => trim($request->typedocument_id),
                            'numberdocument' => trim($request->numberdocument),
                            'firstname' => trim(strtoupper($request->firstname)),
                            'threename' => trim(strtoupper($request->threename)),
                            'fourname' => trim(strtoupper($request->fourname)),
                            'photo' => $namephoto,
                            'address' => trim(strtoupper($request->address)),
                            'cityhome_id' => trim($request->cityhome_id),
                            'locationhome_id' => trim($request->locationhome_id),
                            'dictricthome_id' => trim($request->dictricthome_id),
                            'phoneone' => trim(strtoupper($request->phoneone)),
                            'phonetwo' => trim(strtoupper($request->phonetwo)),
                            'whatsapp' => trim(strtoupper($request->whatsapp)),
                            'emailone' => trim(strtoupper($request->emailone)),
                            'emailtwo' => trim(strtoupper($request->emailtwo)),
                            'bloodtype_id' => trim($request->bloodtype_id),
                            'gender' => trim($request->gender),
                            'profession_id' => trim($request->profession_id),
                            'position' => trim($request->position),
                            'firm' => null
                        ]);
                         return redirect()->route('collaborator.new')->with('SuccessSaveCollaborator', 'COLABORADOR con ID: ' . $request->numberdocument . ' CREADO CORRECTAMENTE');
                    }
                        
                }else{
                    if($request->hasFile('firm')){
                        $firm = $request->file('firm');
                        // $namefirm = $firm->getClientOriginalName();
                        $namefirm = trim($request->numberdocument) . '_firm.' . $firm->extension();
                        Storage::disk('kindersoft')->putFileAs('collaborators',$firm,$namefirm);
                        Collaborator::create([
                            'typedocument_id' => trim($request->typedocument_id),
                            'numberdocument' => trim($request->numberdocument),
                            'firstname' => trim(strtoupper($request->firstname)),
                            'threename' => trim(strtoupper($request->threename)),
                            'fourname' => trim(strtoupper($request->fourname)),
                            'photo' => 'defaultphoto.png',
                            'address' => trim(strtoupper($request->address)),
                            'cityhome_id' => trim($request->cityhome_id),
                            'locationhome_id' => trim($request->locationhome_id),
                            'dictricthome_id' => trim($request->dictricthome_id),
                            'phoneone' => trim(strtoupper($request->phoneone)),
                            'phonetwo' => trim(strtoupper($request->phonetwo)),
                            'whatsapp' => trim(strtoupper($request->whatsapp)),
                            'emailone' => trim(strtoupper($request->emailone)),
                            'emailtwo' => trim(strtoupper($request->emailtwo)),
                            'bloodtype_id' => trim($request->bloodtype_id),
                            'gender' => trim($request->gender),
                            'profession_id' => trim($request->profession_id),
                            'position' => trim($request->position),
                            'firm' => $namefirm,
                        ]);
                         return redirect()->route('collaborator.new')->with('SuccessSaveCollaborator', 'COLABORADOR con ID: ' . $request->numberdocument . ' CREADO CORRECTAMENTE');
                    }else{
                        Collaborator::create([
                            'typedocument_id' => trim($request->typedocument_id),
                            'numberdocument' => trim($request->numberdocument),
                            'firstname' => trim(strtoupper($request->firstname)),
                            'threename' => trim(strtoupper($request->threename)),
                            'fourname' => trim(strtoupper($request->fourname)),
                            'photo' => 'defaultphoto.png',
                            'address' => trim(strtoupper($request->address)),
                            'cityhome_id' => trim($request->cityhome_id),
                            'locationhome_id' => trim($request->locationhome_id),
                            'dictricthome_id' => trim($request->dictricthome_id),
                            'phoneone' => trim(strtoupper($request->phoneone)),
                            'phonetwo' => trim(strtoupper($request->phonetwo)),
                            'whatsapp' => trim(strtoupper($request->whatsapp)),
                            'emailone' => trim(strtoupper($request->emailone)),
                            'emailtwo' => trim(strtoupper($request->emailtwo)),
                            'bloodtype_id' => trim($request->bloodtype_id),
                            'gender' => trim($request->gender),
                            'profession_id' => trim($request->profession_id),
                            'position' => trim($request->position),
                            'firm' => null,
                        ]);
                         return redirect()->route('collaborator.new')->with('SuccessSaveCollaborator', 'COLABORADOR con ID: ' . $request->numberdocument . ' CREADO CORRECTAMENTE');
                    }
                }
            }else{
                 return redirect()->route('collaborator.new')->with('SecondarySaveCollaborator', 'Ya existe un registro con ID: ' . $request->numberdocument . ' con datos asignados');
            }
        }catch(Exception $e){
            return redirect()->route('collaborator.new')->with('SecondarySaveCollaborator', 'Error!! No es posible crear el colaborador');
        }
    }

    function detailsCollaborator($id){
        $collaborator = Collaborator::find($id);
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        $citys = City::all();
        $locations = Location::all();
        $districts = District::all();
        return view('modules.collaborators.details', compact('collaborator','documents','bloodtypes','professions','citys','locations','districts'));
    }
}
