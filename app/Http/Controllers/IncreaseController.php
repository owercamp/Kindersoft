<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\ProfessionHealth;
use App\Models\ObservationHealth;
use App\Models\Vaccination;
use App\Models\Ratingperiod;

use App\Models\Student;
use App\Models\Listcourse;
use App\Models\Academicperiod;

class IncreaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*=================================================
			/start\ PROFESSIONAL HEALTH /start\
    ==================================================*/
    public function professionalHealthTo(){
        $professionalsHealth = ProfessionHealth::all();
    	return view('modules.increase.professionalHealth',compact('professionalsHealth'));
    }

    public function saveProfessionalhealth(Request $request){
        try{
            /*
                $request->phId
                $request->phName
            */
            $professionalValidate = ProfessionHealth::where('phName',trim(mb_strtoupper($request->phName)))->first();
            if($professionalValidate == null){
                ProfessionHealth::create([
                    'phName' => trim(mb_strtoupper($request->phName,'UTF-8'))
                ]);
                return redirect()->route('professionalHealth')->with('SuccessSaveProfessionalhealth', 'PROFESIONAL ' . trim(mb_strtoupper($request->phName,'UTF-8')) . ', GUARDADO');
            }else{
                return redirect()->route('professionalHealth')->with('SecondarySaveProfessionalhealth', 'YA EXISTE UN PROFESIONAL ' . trim(mb_strtoupper($request->phName,'UTF-8')) . ', CONSULTE LA TABLA');
            }
        }catch(Exception $ex){
            return redirect()->route('professionalHealth')->with('SecondarySaveProfessionalhealth', 'NO ES POSIBLE GUARDAR EL PROFESIONAL, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function updateProfessionalhealth(Request $request){
        try{
            /*
                $request->phIdEdit
                $request->phNameEdit
            */
            $professionalValidate = ProfessionHealth::where('phId','!=',trim($request->phIdEdit))
                                                    ->Where('phName',trim(mb_strtoupper($request->phNameEdit,'UTF-8')))
                                                    ->first();
            if($professionalValidate == null){
                $professionalToEdit = ProfessionHealth::find(trim($request->phIdEdit));
                $professionalToEdit->phName = trim(mb_strtoupper($request->phNameEdit,'UTF-8'));
                $nameProfessional = trim(mb_strtoupper($request->phNameEdit,'UTF-8'));
                $professionalToEdit->save();
                return redirect()->route('professionalHealth')->with('PrimaryUpdateProfessionalhealth', 'PROFESIONAL ' . $nameProfessional . ', ACTUALIZADO');
            }else{
                return redirect()->route('professionalHealth')->with('SecondaryUpdateProfessionalhealth', 'YA EXISTE UN PROFESIONAL CON EL NOMBRE ESCRITO');
            }
        }catch(Exception $ex){
            return redirect()->route('professionalHealth')->with('SecondaryUpdateProfessionalhealth', 'NO ES POSIBLE ACTUALIZAR EL PROFESIONAL, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function deleteProfessionalhealth(Request $request){
        try{
            $professionalToDelete = ProfessionHealth::find(trim($request->phIdDelete));
            $nameProfessional = $professionalToDelete->phName;
            $professionalToDelete->delete();
            return redirect()->route('professionalHealth')->with('WarningDeleteProfessionalhealth', 'PROFESIONAL ' . $nameProfessional . ', ELIMINADO');
        }catch(Exception $ex){
            return redirect()->route('professionalHealth')->with('SecondaryDeleteProfessionalhealth', 'NO ES POSIBLE ELIMINAR EL PROFESIONAL, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*=================================================
			/end\ PROFESSIONAL HEALTH /end\
    ==================================================*/

    /*=================================================
			/start\ OBSERVATIONS HEALTH /start\
    ==================================================*/
    public function observationHealthTo(){
        $observationsHealth = ObservationHealth::all();
    	return view('modules.increase.observationsHealth',compact('observationsHealth'));
    }

    public function saveObservationhealth(Request $request){
        try{
            /*
                $request->ohId
                $request->ohObservation
            */
            $observationValidate = ObservationHealth::where('ohObservation',trim(mb_strtoupper($request->ohObservation)))->first();
            if($observationValidate == null){
                ObservationHealth::create([
                    'ohObservation' => trim(mb_strtoupper($request->ohObservation,'UTF-8'))
                ]);
                return redirect()->route('observationsHealth')->with('SuccessSaveObservationhealth', 'OBSERVACION GUARDADA');
            }else{
                return redirect()->route('observationsHealth')->with('SecondarySaveObservationhealth', 'YA EXISTE UNA OBSERVACION COMO LA ESCRITA, CONSULTE LA TABLA');
            }
        }catch(Exception $ex){
            return redirect()->route('observationsHealth')->with('SecondarySaveObservationhealth', 'NO ES POSIBLE GUARDAR LA OBSERVACION, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function updateObservationhealth(Request $request){
        try{
            /*
                $request->ohIdEdit
                $request->ohObservationEdit
            */
            $observationValidate = ObservationHealth::where('ohId','!=',trim($request->ohIdEdit))
                                                    ->Where('ohObservation',trim(mb_strtoupper($request->ohObservationEdit,'UTF-8')))
                                                    ->first();
            if($observationValidate == null){
                $observationToEdit = ObservationHealth::find(trim($request->ohIdEdit));
                $observationToEdit->ohObservation = trim(mb_strtoupper($request->ohObservationEdit,'UTF-8'));
                $nameObservation = trim(mb_strtoupper($request->ohObservationEdit,'UTF-8'));
                $observationToEdit->save();
                return redirect()->route('observationsHealth')->with('PrimaryUpdateObservationhealth', 'OBSERVACION ACTUALIZADA');
            }else{
                return redirect()->route('observationsHealth')->with('SecondaryUpdateObservationhealth', 'YA EXISTE UNA OBSERVACION CON EL NOMBRE ESCRITO');
            }
        }catch(Exception $ex){
            return redirect()->route('observationsHealth')->with('SecondaryUpdateObservationhealth', 'NO ES POSIBLE ACTUALIZAR LA OBSERVACION, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function deleteObservationhealth(Request $request){
        try{
            $observationToDelete = ObservationHealth::find(trim($request->ohIdDelete));
            $observationToDelete->delete();
            return redirect()->route('observationsHealth')->with('WarningDeleteObservationhealth', 'OBSERVACION ELIMINADA');
        }catch(Exception $ex){
            return redirect()->route('observationsHealth')->with('SecondaryDeleteObservationhealth', 'NO ES POSIBLE ELIMINAR LA OBSERVACION, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*=================================================
			/end\ OBSERVATIONS HEALTH /end\
    ==================================================*/


    /*=================================================
			/start\ VACCINATION /start\
    ==================================================*/
    public function vaccinationTo(){
        $vaccinations = Vaccination::all();
    	return view('modules.increase.vaccinations',compact('vaccinations'));
    }
    public function saveVaccination(Request $request){
        try{
            /*
                $request->vaId
                $request->vaName
            */
            $vaccinationValidate = Vaccination::where('vaName',trim(mb_strtoupper($request->vaName)))->first();
            if($vaccinationValidate == null){
                Vaccination::create([
                    'vaName' => trim(mb_strtoupper($request->vaName,'UTF-8'))
                ]);
                return redirect()->route('vaccination')->with('SuccessSaveVaccination', 'ESQUEMA ' . trim(mb_strtoupper($request->vaName,'UTF-8')) . ', GUARDADO');
            }else{
                return redirect()->route('vaccination')->with('SecondarySaveVaccination', 'YA EXISTE UN ESQUEMA ' . trim(mb_strtoupper($request->vaName,'UTF-8')) . ', CONSULTE LA TABLA');
            }
        }catch(Exception $ex){
            return redirect()->route('professionalHealth')->with('SecondarySaveProfessionalhealth', 'NO ES POSIBLE GUARDAR EL ESQUEMA, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function updateVaccination(Request $request){
        try{
            /*
                $request->vaIdEdit
                $request->vaNameEdit
            */
            $vaccinationValidate = Vaccination::where('vaId','!=',trim($request->vaIdEdit))
                                                    ->Where('vaName',trim(mb_strtoupper($request->vaNameEdit,'UTF-8')))
                                                    ->first();
            if($vaccinationValidate == null){
                $vaccinationToEdit = Vaccination::find(trim($request->vaIdEdit));
                $vaccinationToEdit->vaName = trim(mb_strtoupper($request->vaNameEdit,'UTF-8'));
                $vaccinationToEdit->save();
                return redirect()->route('vaccination')->with('PrimaryUpdateVaccination', 'ESQUEMA ' . trim(mb_strtoupper($request->vaNameEdit,'UTF-8')) . ', ACTUALIZADO');
            }else{
                return redirect()->route('vaccination')->with('SecondaryUpdateVaccination', 'YA EXISTE UN ESQUEMA CON EL NOMBRE ' . trim(mb_strtoupper($request->vaNameEdit,'UTF-8')));
            }
        }catch(Exception $ex){
            return redirect()->route('vaccination')->with('SecondaryUpdateVaccination', 'NO ES POSIBLE ACTUALIZAR EL ESQUEMA, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function deleteVaccination(Request $request){
        try{
            $vaccinationToDelete = Vaccination::find(trim($request->vaIdDelete));
            $nameVaccination = $vaccinationToDelete->vaName;
            $vaccinationToDelete->delete();
            return redirect()->route('vaccination')->with('WarningDeleteVaccination', 'ESQUEMA ' . $nameVaccination . ', ELIMINADO');
        }catch(Exception $ex){
            return redirect()->route('vaccination')->with('SecondaryDeleteVaccination', 'NO ES POSIBLE ELIMINAR EL ESQUEMA, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }
    /*=================================================
			/end\ VACCINATION /end\
    ==================================================*/

    /*=================================================
			/start\ PROFESSIONAL HEALTH /start\
    ==================================================*/
    public function ratingsTo(){
        $students = Listcourse::select(
                'students.id as idStudent',
                'students.status',
                DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
            )
            ->join('students','students.id','listcourses.listStudent_id')
            ->orderBy('nameStudent','asc')->get();
        $observationsHealth = ObservationHealth::all();
        $vaccinations = Vaccination::all();
        $professionalHealths = ProfessionHealth::all();
        $ratings = Ratingperiod::select(
                    'ratingsPeriod.*',
                    DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
                    'academicperiods.apNameperiod as namePeriod'
                )
                ->join('students','students.id','ratingsPeriod.rpStudent_id')
                ->join('academicperiods','academicperiods.apId','ratingsPeriod.rpAcademicperiod_id')
                ->get();
    	return view('modules.increase.ratingsPeriod', compact('students','observationsHealth','vaccinations','professionalHealths','ratings'));
    }

    public function newRatings(Request $request){
        try{
            // dd($request->all());
            /*
                $request->rpStudent_id                  // ID DEL ALUMNO SELECCIONADO
                $request->rpAcademicperiod_id           // ID DEL PERIODO SELECCIONADO
                
                // TOMA ANTROPOMETRICA 1
                $request->rpWeight_one                  // MEDIDA DE PESO 1
                $request->rpHeight_one                  // MEDIDA DE TALLA 1
                $request->rpObservation_one             // OBSERVACION DE TOMA 1

                // TOMA ANTROPOMETRICA 2
                $request->rpWeight_two                  // MEDIDA DE PESO 2
                $request->rpHeight_two                  // MEDIDA DE TALLA 2
                $request->rpObservation_two             // OBSERVACION DE TOMA 2

                $request->rpHealtear                    // OBSERVACION DE TAMIZAJE AUDITIVO
                $request->rpHealteye                    // OBSERVACION DE TAMIZAJE VISUAL
                $request->rpHealthoral                  // OBSERVACION DE SALUD ORAL
                $request->rpObservationhealth_id        // OBSERVACION DE SALUD (Pueden ser varios)
                $request->detailsVaccinations           // OPCION (SI/NO) DE CADA ESQUEMA DE VACUNACION
                $request->rpProfessionalhealth_id       // PROFESIONAL DE LA SALUD (Pueden ser varios)

                $request->detailsObservationhealthsSelected     // IDS DE LAS OBSERVACIONES DE LA SALUD SELECCIONADOS
                $request->detailsProfessionalhealthsSelected    // IDS DE LOS PROFESIONALES DE LA SALUD SELECCIONADOS
            */
            $validateRating = Ratingperiod::where('rpStudent_id',trim($request->rpStudent_id))
                                    ->where('rpAcademicperiod_id',trim($request->rpAcademicperiod_id))
                                    ->first();
            $observationsHealth = substr(trim($request->detailsObservationhealthsSelected),0,-1);
            $professionalsHealth = substr(trim($request->detailsProfessionalhealthsSelected),0,-1);
            $vaccinations = substr(trim($request->detailsVaccinations),0,-1);
            if($validateRating == null){
                Ratingperiod::create([
                    'rpStudent_id' => trim($request->rpStudent_id),
                    'rpAcademicperiod_id' => trim($request->rpAcademicperiod_id),
                    'rpWeight_one' => trim(ucfirst(mb_strtolower($request->rpWeight_one,'UTF-8'))),
                    'rpHeight_one' => trim(ucfirst(mb_strtolower($request->rpHeight_one,'UTF-8'))),
                    'rpObservation_one' => trim(ucfirst(mb_strtolower($request->rpObservation_one,'UTF-8'))),
                    'rpWeight_two' => trim(ucfirst(mb_strtolower($request->rpWeight_two,'UTF-8'))),
                    'rpHeight_two' => trim(ucfirst(mb_strtolower($request->rpHeight_two,'UTF-8'))),
                    'rpObservation_two' => trim(ucfirst(mb_strtolower($request->rpObservation_two,'UTF-8'))),
                    'rpHealtear' => trim(ucfirst(mb_strtolower($request->rpHealtear,'UTF-8'))),
                    'rpHealteye' => trim(ucfirst(mb_strtolower($request->rpHealteye,'UTF-8'))),
                    'rpHealthoral' => trim(ucfirst(mb_strtolower($request->rpHealthoral,'UTF-8'))),
                    'rpVaccinations' => $vaccinations,
                    'rpObservationshealth' => $observationsHealth,
                    'rpProfessionaslhealth' => $professionalsHealth
                ]);

                $student = Student::find(trim($request->rpStudent_id));
                $period = Academicperiod::find(trim($request->rpAcademicperiod_id));
                return redirect()->route('ratinPeriod')->with('SuccessSaveRating', 'Valoración para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' en el periodo ' . $period->apNameperiod . ', guardado correctamente');
            }else{
                return redirect()->route('ratinPeriod')->with('SecondarySaveRating', 'Ya existe una valoración con el alumno y periodo seleccionado, consulte la tabla');
            }
        }catch(Exception $ex){
            // Code exception ...
        }
    }

    public function editRatings(Request $request){
        try{
            // dd($request->all());
            /*
                $request->rpIdEdit                          // ID DE LA VALORACION
                $request->rpStudent_idEdit                  // ID DEL ALUMNO
                $request->rpAcademicperiod_idEdit           // ID DEL PERIODO ACADEMICO
                
                // TOMA ANTROPOMETRICA 1
                $request->rpWeight_oneEdit                  // MEDIDA DE PESO 1
                $request->rpHeight_oneEdit                  // MEDIDA DE TALLA 1
                $request->rpObservation_oneEdit             // OBSERVACION DE TOMA 1

                // TOMA ANTROPOMETRICA 2
                $request->rpWeight_twoEdit                  // MEDIDA DE PESO 2
                $request->rpHeight_twoEdit                  // MEDIDA DE TALLA 2
                $request->rpObservation_twoEdit             // OBSERVACION DE TOMA 2

                $request->rpHealtearEdit                    // OBSERVACION DE TAMIZAJE AUDITIVO
                $request->rpHealteyeEdit                    // OBSERVACION DE TAMIZAJE VISUAL
                $request->rpHealthoralEdit                  // OBSERVACION DE SALUD ORAL
                $request->rpObservationhealth_idEdit        // OBSERVACION DE SALUD (Pueden ser varios)
                $request->detailsVaccinationsEdit           // OPCION (SI/NO) DE CADA ESQUEMA DE VACUNACION
                $request->rpProfessionalhealth_idEdit       // PROFESIONAL DE LA SALUD (Pueden ser varios)

                $request->detailsObservationhealthsSelectedEdit     // IDS DE LAS OBSERVACIONES DE LA SALUD SELECCIONADOS
                $request->detailsProfessionalhealthsSelectedEdit    // IDS DE LOS PROFESIONALES DE LA SALUD SELECCIONADOS
            */
            $vaccinations = substr(trim($request->detailsVaccinationsEdit),0,-1);
            $observationsHealth = substr(trim($request->detailsObservationhealthsSelectedEdit),0,-1);
            $professionalsHealth = substr(trim($request->detailsProfessionalhealthsSelectedEdit),0,-1);
            $ratingToEdit = Ratingperiod::find(trim($request->rpIdEdit));
            if($ratingToEdit != null){
                $ratingToEdit->rpWeight_one = trim(ucfirst(mb_strtolower($request->rpWeight_oneEdit,'UTF-8')));
                $ratingToEdit->rpHeight_one = trim(ucfirst(mb_strtolower($request->rpHeight_oneEdit,'UTF-8')));
                $ratingToEdit->rpObservation_one = trim(ucfirst(mb_strtolower($request->rpObservation_oneEdit,'UTF-8')));
                $ratingToEdit->rpWeight_two = trim(ucfirst(mb_strtolower($request->rpWeight_twoEdit,'UTF-8')));
                $ratingToEdit->rpHeight_two = trim(ucfirst(mb_strtolower($request->rpHeight_twoEdit,'UTF-8')));
                $ratingToEdit->rpObservation_two = trim(ucfirst(mb_strtolower($request->rpObservation_twoEdit,'UTF-8')));
                $ratingToEdit->rpHealtear = trim(ucfirst(mb_strtolower($request->rpHealtearEdit,'UTF-8')));
                $ratingToEdit->rpHealteye = trim(ucfirst(mb_strtolower($request->rpHealteyeEdit,'UTF-8')));
                $ratingToEdit->rpHealthoral = trim(ucfirst(mb_strtolower($request->rpHealthoralEdit,'UTF-8')));
                $ratingToEdit->rpVaccinations = $vaccinations;
                $ratingToEdit->rpObservationshealth = $observationsHealth;
                $ratingToEdit->rpProfessionaslhealth = $professionalsHealth;
                $ratingToEdit->save();
                // RETORNAR RESULTADO
                $student = Student::find(trim($request->rpStudent_idEdit));
                $period = Academicperiod::find(trim($request->rpAcademicperiod_idEdit));
                return redirect()->route('ratinPeriod')->with('PrimaryUpdateRating', 'Valoración para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' en el periodo ' . $period->apNameperiod . ', se ha actualizado correctamente');
            }else{
                return redirect()->route('ratinPeriod')->with('SecondaryUpdateRating', 'No se encuentra la valoración periódica, comuniquese con el administrador');
            }
        }catch(Exception $ex){
            // Code exception ...
        }
    }

    public function deleteRatings(Request $request){
        try{
            // dd($request->all());
            /*
                $request->rpIdDelete
                $request->rpStudent_idDelete
                $request->rpAcademicperiod_idDelete
            */
            $ratingToDelete = Ratingperiod::find(trim($request->rpIdDelete));
            $student = Student::find(trim($request->rpStudent_idDelete));
            $period = Academicperiod::find(trim($request->rpAcademicperiod_idDelete));
            $ratingToDelete->delete();
            return redirect()->route('ratinPeriod')->with('WarningDeleteRating', 'Valoración de ' . $period->apNameperiod . ' para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ', eliminada correctamente');
        }catch(Exception $ex){
            return redirect()->route('ratinPeriod')->with('SecondaryDeleteRating', 'No es posible eliminar la valoración, Comuniquese con el administrador');
        }
    }

    public function pdfRatings(Request $request){
        try{
            // dd($request->all());
            /*
                $request->rpIdPdf
            */
            $validateRating = $rating = Ratingperiod::select(
                'ratingsPeriod.*',
                DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
                'students.numberdocument',
                'students.birthdate',
                'academicperiods.apNameperiod',
                'courses.name as nameCourse'
            )
            ->join('students','students.id','ratingsPeriod.rpStudent_id')
            ->join('academicperiods','academicperiods.apId','ratingsPeriod.rpAcademicperiod_id')
            ->join('courses','courses.id','academicperiods.apCourse_id')
            ->where('ratingsPeriod.rpId',trim($request->rpIdPdf))->first();
            if($validateRating != null){
                $infoBasic = [
                    $validateRating->nameStudent,
                    $validateRating->numberdocument,
                    $this->getYearsold($this->converterYearsoldFromBirtdate($validateRating->birthdate)),
                    $validateRating->nameCourse,
                    $validateRating->apNameperiod
                ];

                // OBSERVACIONES DE SALUD
                $idsObservation = explode(':', $validateRating->rpObservationshealth);
                $observations = array();
                for ($i=0; $i < count($idsObservation); $i++) { 
                    $observationhealth = ObservationHealth::find($idsObservation[$i]);
                    if($observationhealth != null){
                        array_push($observations,$observationhealth->ohObservation);
                    }
                }

                // ESQUEMAS DE VACUNACION
                $separatedVaccination = explode(':', $validateRating->rpVaccinations);
                $vaccinations = array();
                for ($i=0; $i < count($separatedVaccination); $i++) { 
                    $itemVaccinations = explode('=', $separatedVaccination[$i]);
                    $validateVaccination = Vaccination::find($itemVaccinations[0]);
                    if($validateVaccination != null){
                        array_push($vaccinations, [
                            $validateVaccination->vaName,
                            $itemVaccinations[1]
                        ]);
                    }
                }

                // PROFESIONALES DE LA SALUD
                $idsProfessional = explode(':', $validateRating->rpProfessionaslhealth);
                $professionals = array();
                for ($i=0; $i < count($idsProfessional); $i++) { 
                    $professionalhealth = ProfessionHealth::find($idsProfessional[$i]);
                    if($professionalhealth != null){
                        array_push($professionals,$professionalhealth->phName);
                    }
                }
                $pdf = \App::make('dompdf.wrapper');
                $namefile = 'VALORACION_PERIODICA_DE_' . '_' . $validateRating->nameStudent . '_' . $validateRating->apNameperiod . '.pdf';
                $pdf->loadView('modules.increase.ratingPeriodPdf',compact('validateRating','infoBasic','observations','vaccinations','professionals'));
                //$pdf->setPaper("A6", "landscape");
                return $pdf->download($namefile);
            }else{
                return redirect()->route('ratinPeriod')->with('SecondarySaveRating', 'No se encuentra la valoración, Comuniquese con el administrador');
            }
        }catch(Exception $ex){
            // return redirect()->route('ratinPeriod')->with('SecondaryDeleteRating', 'No es posible eliminar la valoración, Comuniquese con el administrador');
        }
    }

    function converterYearsoldFromBirtdate($date){
        $values = explode('-',$date);
        $day = $values[2];
        $mount = $values[1];
        $year = $values[0];
        $yearNow = Date('Y');
        $mountNow = Date('m');
        $dayNow = Date('d');
        //Cálculo de años
        $old = ($yearNow + 1900) - $year;
        if ( $mountNow < $mount ){ $old--; }
        if ($mount == $mountNow && $dayNow <$day){ $old--; }
        if ($old > 1900){ $old -= 1900; }
        //Cálculo de meses
        $mounts=0;
        if($mountNow>$mount && $day > $dayNow){ $mounts=($mountNow-$mount)-1; }
        else if ($mountNow > $mount){ $mounts=$mountNow-$mount; }
        else if($mountNow<$mount && $day < $dayNow){ $mounts=12-($mount-$mountNow); }
        else if($mountNow<$mount){ $mounts=12-($mount-$mountNow+1); }
        if($mountNow==$mount && $day>$dayNow){ $mounts=11; }
        $processed = $old . '-' . $mounts;
        return $processed;
    }

    function getYearsold($yearsold){
        $len = strlen($yearsold);
        if($len < 5 & $len > 0){
            $separated = explode('-',$yearsold);
            $mounts = ($separated[1]>1 ? $separated[1] . ' meses' : $separated[1] . ' mes');
            return $separated[0] . ' años ' . $mounts;
        }else{
            return $yearsold;
        }
    }
    /*=================================================
			/end\ PROFESSIONAL HEALTH /end\
    ==================================================*/

    /*=================================================
			/start\ INCREASE STATISTIC /start\
    ==================================================*/
    public function statisticIncreaseTo(){
        $students = Listcourse::select(
                'students.id as idStudent',
                'students.status',
                DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent")
            )
            ->join('students','students.id','listcourses.listStudent_id')
            ->orderBy('nameStudent','asc')->get();
    	return view('modules.increase.statistic',compact('students'));
    }

    public function graficRating(Request $request){

        $ratingFirst = Ratingperiod::select('ratingsPeriod.*','academicperiods.apNameperiod')
                            ->join('academicperiods','academicperiods.apId','ratingsPeriod.rpAcademicperiod_id')
                            ->where('rpStudent_id',trim($request->rpStudent_id))
                            ->where('apNameperiod','PRIMER PERIODO')->first();
        $oneWeightFirst = 0;
        $oneHeightFirst = 0;
        $twoWeightFirst = 0;
        $twoHeightFirst = 0;
        $oneObservationFirst = 'N/A';
        $twoObservationFirst = 'N/A';
        if($ratingFirst != null){
            $oneWeightFirst = $ratingFirst->rpWeight_one;
            $oneHeightFirst = $ratingFirst->rpHeight_one;
            $twoWeightFirst = $ratingFirst->rpWeight_two;
            $twoHeightFirst = $ratingFirst->rpHeight_two;
            $oneObservationFirst = $ratingFirst->rpObservation_one;
            $twoObservationFirst = $ratingFirst->rpObservation_two;
        }

        $ratingSecond = Ratingperiod::select('ratingsPeriod.*','academicperiods.apNameperiod')
                            ->join('academicperiods','academicperiods.apId','ratingsPeriod.rpAcademicperiod_id')
                            ->where('rpStudent_id',trim($request->rpStudent_id))
                            ->where('apNameperiod','SEGUNDO PERIODO')->first();
        $oneWeightSecond = 0;
        $oneHeightSecond = 0;
        $twoWeightSecond = 0;
        $twoHeightSecond = 0;
        $oneObservationSecond = 'N/A';
        $twoObservationSecond = 'N/A';
        if($ratingSecond != null){
            $oneWeightSecond = $ratingSecond->rpWeight_one;
            $oneHeightSecond = $ratingSecond->rpHeight_one;
            $twoWeightSecond = $ratingSecond->rpWeight_two;
            $twoHeightSecond = $ratingSecond->rpHeight_two;
            $oneObservationSecond = $ratingSecond->rpObservation_one;
            $twoObservationSecond = $ratingSecond->rpObservation_two;
        }

        $ratingThree = Ratingperiod::select('ratingsPeriod.*','academicperiods.apNameperiod')
                            ->join('academicperiods','academicperiods.apId','ratingsPeriod.rpAcademicperiod_id')
                            ->where('rpStudent_id',trim($request->rpStudent_id))
                            ->where('apNameperiod','TERCER PERIODO')->first();
        $oneWeightThree = 0;
        $oneHeightThree = 0;
        $twoWeightThree = 0;
        $twoHeightThree = 0;
        $oneObservationThree = 'N/A';
        $twoObservationThree = 'N/A';
        if($ratingThree != null){
            $oneWeightThree = $ratingThree->rpWeight_one;
            $oneHeightThree = $ratingThree->rpHeight_one;
            $twoWeightThree = $ratingThree->rpWeight_two;
            $twoHeightThree = $ratingThree->rpHeight_two;
            $oneObservationThree = $ratingThree->rpObservation_one;
            $twoObservationThree = $ratingThree->rpObservation_two;
        }

        $joined = [
            [$oneWeightFirst,$oneWeightSecond,$oneWeightThree],
            [$twoWeightFirst,$twoWeightSecond,$twoWeightThree],
            [$oneHeightFirst,$oneHeightSecond,$oneHeightThree],
            [$twoHeightFirst,$twoHeightSecond,$twoHeightThree],
            [$oneObservationFirst,$oneObservationSecond,$oneObservationThree],
            [$twoObservationFirst,$twoObservationSecond,$twoObservationThree]
        ];
        return response()->json($joined);
    }
    /*=================================================
			/end\ INCREASE STATISTIC /end\
    ==================================================*/

}
