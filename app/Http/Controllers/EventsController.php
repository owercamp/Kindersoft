<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Eventdiary;

use App\Models\Listcourse;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use App\Models\Eventcreation;
use App\Models\DocumentEnroll;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*--------------------------------------
		MODULO DE CREACION - EVENTOS
    --------------------------------------*/
    public function creationTo(){
        $creations = Eventcreation::all();
    	return view('modules.events.creation',compact('creations'));
    }

    public function creationSave(Request $request){
        try{
            /*
                $request->crName
                $request->crDescription
            */
            $creationValidate = Eventcreation::where('crName',trim(mb_strtoupper($request->crName)))->where('crDescription',trim(mb_strtoupper($request->crDescription)))->first();
            if($creationValidate == null){
                Eventcreation::create([
                    'crName' => trim(mb_strtoupper($request->crName)),
                    'crDescription' => trim(mb_strtoupper($request->crDescription,'UTF-8'))
                ]);
                return redirect()->route('creation')->with('SuccessSaveCreation', 'EVENTO ' . trim(mb_strtoupper($request->crName)) . ', GUARDADO');
            }else{
                return redirect()->route('creation')->with('SecondarySaveCreation', 'YA EXISTE UN EVENTO ' . trim(mb_strtoupper($request->crName)) . ', CONSULTE LA TABLA');
            }
        }catch(Exception $ex){
            return redirect()->route('creation')->with('SecondarySaveCreation', 'NO ES POSIBLE GUARDAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function creationUpdate(Request $request){
        try{
            /*
                $request->crNameEdit
                $request->crDescriptionEdit
            */
            $creationValidate = Eventcreation::where('crId','!=',$request->crIdEdit)
                                                    ->Where('crName',trim(mb_strtoupper($request->crNameEdit)))
                                                    ->Where('crDescription',trim(mb_strtoupper($request->crDescriptionEdit,'UTF-8')))
                                                    ->first();
            if($creationValidate == null){
                $creationToEdit = Eventcreation::find(trim($request->crIdEdit));
                $creationToEdit->crName = trim(mb_strtoupper($request->crNameEdit));
                $creationToEdit->crDescription = trim(mb_strtoupper($request->crDescriptionEdit,'UTF-8'));
                $nameCreation = trim(mb_strtoupper($request->crNameEdit,'UTF-8'));
                $creationToEdit->save();
                return redirect()->route('creation')->with('PrimaryUpdateCreation', 'EVENTO ' . $nameCreation . ', ACTUALIZADO');
            }else{
                return redirect()->route('creation')->with('SecondaryUpdateCreation', 'YA EXISTE UN EVENTO CON EL NOMBRE O DESCRIPCION ESCRITA');
            }
        }catch(Exception $ex){
            return redirect()->route('creation')->with('SecondaryUpdateCreation', 'NO ES POSIBLE ACTUALIZAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function creationDelete(Request $request){
        try{
            $creationToDelete = Eventcreation::find(trim($request->crIdDelete));
            $nameCreation = $creationToDelete->crName;
            $creationToDelete->delete();
            return redirect()->route('creation')->with('WarningDeleteCreation', 'EVENTO ' . $nameCreation . ', ELIMINADO');
        }catch(Exception $ex){
            return redirect()->route('creation')->with('SecondaryDeleteCreation', 'NO ES POSIBLE ELIMINAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*--------------------------------------
		# MODULO DE CREACION  - EVENTOS#
    --------------------------------------*/

    /*--------------------------------------
		MODULO DE AGENDAMIENTO - EVENTOS
    --------------------------------------*/
    public function diaryTo(){
        $events = Eventdiary::select(
            'eventDiary.*',
            'eventCreations.crName as nameCreation',
            DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
        )
        ->join('eventCreations','eventCreations.crId','eventDiary.edCreation_id')
        ->join('collaborators','collaborators.id','eventDiary.edCollaborator_id')
        ->get();
        $collaborators = Collaborator::select(
            'collaborators.id',
            DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
        )->get();
        $students = Listcourse::select(
            'listcourses.*',
            'students.id',
            DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
        )
        ->join('students','students.id','listcourses.listStudent_id')
        ->where('listCourse_id','!=',null)
        ->orderBy('students.firstname','ASC')
        ->get();
        $creations = Eventcreation::all();
    	return view('modules.events.diary',compact('events','collaborators','creations','students'));
    }

    public function diarySave(Request $request){
        try{
            /*
                $request->edDate
                $request->edStart
                $request->edEnd
                $request->edCollaborator_id
                $request->edCreation_id
                $request->edCreation_id
                $request->activeStudent
                $request->edStudents
                $request->edDescription
            */
            // dd($request->all());
            $diaryValidate = Eventdiary::where('edDate',trim(mb_strtoupper($request->edDate)))->where('edStart',trim(mb_strtoupper($request->edStart)))->first();
            if($diaryValidate == null){
                if(trim($request->edStudents) != ''){
                    Eventdiary::create([
                        'edDate' => trim($request->edDate),
                        'edStart' => trim($request->edStart),
                        'edEnd' => trim($request->edEnd),
                        'edCollaborator_id' => trim($request->edCollaborator_id),
                        'edCreation_id' => trim($request->edCreation_id),
                        'edStudents' => 'ALUMNO:' . trim($request->edStudents),
                        'edDescription' => trim(mb_strtoupper($request->edDescription,'UTF-8'))
                    ]);
                }else{
                    Eventdiary::create([
                        'edDate' => trim($request->edDate),
                        'edStart' => trim($request->edStart),
                        'edEnd' => trim($request->edEnd),
                        'edCollaborator_id' => trim($request->edCollaborator_id),
                        'edCreation_id' => trim($request->edCreation_id),
                        'edStudents' => null,
                        'edDescription' => trim(mb_strtoupper($request->edDescription,'UTF-8'))
                    ]);
                }
                return redirect()->route('diary')->with('SuccessSaveEventdiary', 'AGENDA DE EVENTO PARA ' . trim(mb_strtoupper($request->edDate)) . ', GUARDADO');
            }else{
                return redirect()->route('diary')->with('SecondarySaveEventdiary', 'YA EXISTE UN EVENTO CON FECHA U HORA ' . trim(mb_strtoupper($request->edDate)) . ', CONSULTE LA TABLA');
            }
        }catch(Exception $ex){
            return redirect()->route('diary')->with('SecondarySaveEventdiary', 'NO ES POSIBLE GUARDAR LA AGENDA DE EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function diaryUpdate(Request $request){
        try{
            /*
                $request->edId_edit
                $request->edDate_edit
                $request->edStart_edit
                $request->edEnd_edit
                $request->edCollaborator_id_edit
                $request->edCreation_id_edit
                $request->activeStudentEdit
                $request->edStudents_edit
                $request->edDescription_edit
            */
                // dd($request->all());
            $diaryValidate = Eventdiary::where('edId','!=',$request->edId_edit)
                                                    ->Where('edDate',trim($request->edDate_edit))
                                                    ->Where('edStart',trim($request->edStart_edit))
                                                    ->Where('edEnd',trim($request->edEnd_edit))
                                                    ->first();
            if($diaryValidate == null){
                $diaryToEdit = Eventdiary::find(trim($request->edId_edit));
                $diaryToEdit->edDate = trim(mb_strtoupper($request->edDate_edit));
                $diaryToEdit->edStart = trim(mb_strtoupper($request->edStart_edit));
                $diaryToEdit->edEnd = trim(mb_strtoupper($request->edEnd_edit));
                $diaryToEdit->edCollaborator_id = trim($request->edCollaborator_id_edit);
                $diaryToEdit->edCreation_id = trim($request->edCreation_id_edit);
                if(trim($request->edStudents_edit) == ''){
                    $diaryToEdit->edStudents = null;
                }else{
                    $diaryToEdit->edStudents = trim($request->edStudents_edit);
                }
                $diaryToEdit->edDescription = trim(mb_strtoupper($request->edDescription_edit,'UTF-8'));
                $namediary = trim($request->edDate_edit);
                $diaryToEdit->save();
                return redirect()->route('diary')->with('SuccessSaveEventdiary', 'EVENTO ' . $namediary . ', ACTUALIZADO');
            }else{
                return redirect()->route('diary')->with('SecondarySaveEventdiary', 'YA EXISTE UN EVENTO CON LA FECHA Y HORAS ESTABLECIDAS');
            }
        }catch(Exception $ex){
            return redirect()->route('diary')->with('SecondarySaveEventdiary', 'NO ES POSIBLE ACTUALIZAR EL AGENDAMIENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function diaryDelete(Request $request){
        try{
            $diaryToDelete = Eventdiary::find(trim($request->deId_Delete));
            $datediary = $diaryToDelete->edDate;
            $diaryToDelete->delete();
            return redirect()->route('diary')->with('WarningDeleteEventdiary', 'EVENTO PARA EL ' . $datediary . ', ELIMINADO');
        }catch(Exception $ex){
            return redirect()->route('diary')->with('SecondaryDeleteEventdiary', 'NO ES POSIBLE ELIMINAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*--------------------------------------
		# MODULO DE AGENDAMIENTO - EVENTOS #
    --------------------------------------*/

    /*--------------------------------------
		MODULO DE SEGUIMIENTO - EVENTOS
    --------------------------------------*/
    public function followTo(){
        $collaborators = Collaborator::select(
            'collaborators.id',
            DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
        )->get();
        $creations = Eventcreation::all();
    	return view('modules.events.follow',compact('collaborators','creations'));
    }

    public function followChange(Request $request){
        try {
            /*
                $request->deDate_change
                $request->deStart_change
                $request->deEnd_change
                $request->deDescription_change
                $request->deId_change
            */
            // dd($request->all());
            $validateDiary = Eventdiary::find(trim($request->deId_change));
            if($validateDiary != null){
                $validateDiary->edDate = trim(mb_strtoupper($request->deDate_change));
                $validateDiary->edStart = trim(mb_strtoupper($request->deStart_change));
                $validateDiary->edEnd = trim(mb_strtoupper($request->deEnd_change));
                $datediary = $validateDiary->edDate;
                $validateDiary->save();
                return redirect()->route('follow')->with('PrimaryUpdateFollow', 'SE HA MODIFICADO EL EVENTO DEL ' . $datediary);
            }else{
                return redirect()->route('follow')->with('SecondaryUpdateFollow', 'NO ES POSIBLE MODIFICAR EL EVENTO, INTENTELO MAS TARDE');
            }
        }catch(Exception $ex) {
            return redirect()->route('follow')->with('SecondaryUpdateFollow', 'NO ES POSIBLE MODIFICAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    public function followStop(Request $request){
        try {
            /*
                $request->deDescripcionOut_stop
                $request->deId_stop
            */
            $validateDiary = Eventdiary::find(trim($request->deId_stop));
            if($validateDiary != null){
                $validateDiary->edDescriptionout = trim(mb_strtoupper($request->deDescripcionOut_stop));
                $validateDiary->edStatus = 1;
                $validateDiary->edColor = '#0086f9';
                $datediary = $validateDiary->edDate;
                $validateDiary->save();
                return redirect()->route('follow')->with('SuccessSaveFollow', 'SE HA CERRADO EL EVENTO DEL ' . $datediary);
            }else{
                return redirect()->route('follow')->with('SecondarySaveFollow', 'NO ES POSIBLE CERRAR EL EVENTO, INTENTELO MAS TARDE');
            }
        }catch(Exception $ex) {
            return redirect()->route('follow')->with('SecondarySaveFollow', 'NO ES POSIBLE CERRAR EL EVENTO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*--------------------------------------
		# MODULO DE SEGUIMIENTO - EVENTOS #
    --------------------------------------*/

    /*--------------------------------------
		MODULO DE ESTADISTICA - EVENTOS
    --------------------------------------*/
    public function graficTo(){
    	return view('modules.events.grafic');
    }
    /*--------------------------------------
		# MODULO DE ESTADISTICA - EVENTOS #
    --------------------------------------*/
}
