<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Course;
use App\Models\Academicperiod;
use App\Models\CourseConsolidated;

class AcademicperiodsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    function academicPeriodTo(){
        //$academicperiods = Academicperiod::withCount(['apCourse_id'])->get();
        //->selectRaw('count(academicperiods.apNamePeriod) as total_periods')
        $academicperiods = Academicperiod::select('academicperiods.*','courses.name AS nameCourse')->join('courses','courses.id','academicperiods.apCourse_id')->get();

        return view('modules.programming.academicperiod',compact('academicperiods'));
    }

    function newAcademicperiod(){
        $courses = CourseConsolidated::select('courses.*')->join('courses','courses.id','coursesconsolidated.ccCourse_id')->get();
        return view('modules.programming.newAcademicperiod', compact('courses'));
    }

    function saveAcademicperiod(Request $request){
        /*
            $request->countPeriod
            $request->apCourse
            $request->optionAll

            $request->apNamePeriodUnique
            $request->apDateInitialUnique
            $request->apDateFinalUnique
            $request->apStatusUnique

            $request->apNamePeriodOne
            $request->apDateInitialOne
            $request->apDateFinalOne
            $request->apStatusOne

            $request->apNameperiodTwo_one
            $request->apDateInitialTwo_one
            $request->apDateFinalTwo_one
            $request->apStatusTwo_one
            $request->apNameperiodTwo_two
            $request->apDateInitialTwo_two
            $request->apDateFinalTwo_two
            $request->apStatusTwo_two

            $request->apNameperiodThree_one
            $request->apDateInitialThree_one
            $request->apDateFinalThree_one
            $request->apStatusThree_one
            $request->apNameperiodThree_two
            $request->apDateInitialThree_two
            $request->apDateFinalThree_two
            $request->apStatusThree_two
            $request->apNameperiodThree_three
            $request->apDateInitialThree_three
            $request->apDateFinalThree_three
            $request->apStatusThree_three

            $request->apNameperiodFour_one
            $request->apDateInitialFour_one
            $request->apDateFinalFour_one
            $request->apStatusFour_one
            $request->apNameperiodFour_two
            $request->apDateInitialFour_two
            $request->apDateFinalFour_two
            $request->apStatusFour_two
            $request->apNameperiodFour_three
            $request->apDateInitialFour_three
            $request->apDateFinalFour_three
            $request->apStatusFour_three
            $request->apNameperiodFour_four
            $request->apDateInitialFour_four
            $request->apDateFinalFour_four
            $request->apStatusFour_four
        */
    	try{
            //dd($request->all());
            if($request->optionAll == 'SI'){
                if($request->countPeriod == 1){
                    $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse))->where('apNameperiod','PRIMER PERIODO')->first();
                    if($academicperiodValidate == null){
                        Academicperiod::create([
                            'apNameperiod' => 'PRIMER PERIODO',
                            'apDateInitial' => trim($request->apDateInitialOne),
                            'apDateFinal' => trim($request->apDateFinalOne),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusOne)
                        ]);
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SuccessSaveAcademicperiod', 'Se ha definido el PRIMER PERIODO para el curso ' . $course->name . ' correctamente');
                    }else{
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'Ya existe el PRIMER PERIODO para el curso ' . $course->name);
                    }
                }else if($request->countPeriod == 2){
                    $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse))->where('apNameperiod','PRIMER PERIODO')->where('apNameperiod','SEGUNDO PERIODO')->first();
                    if($academicperiodValidate == null){
                        Academicperiod::create([
                            'apNameperiod' => 'PRIMER PERIODO',
                            'apDateInitial' => trim($request->apDateFinalTwo_one),
                            'apDateFinal' => trim($request->apDateFinalTwo_one),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusTwo_one)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'SEGUNDO PERIODO',
                            'apDateInitial' => trim($request->apDateInitialTwo_two),
                            'apDateFinal' => trim($request->apDateFinalTwo_two),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusTwo_two)
                        ]);
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SuccessSaveAcademicperiod', 'Se ha definido el PRIMERO y SEGUNDO PERIODO para el curso ' . $course->name . ' correctamente');
                    }else{
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'Ya existe el PRIMERO o SEGUNDO PERIODO para el curso ' . $course->name);
                    }
                }else if($request->countPeriod == 3){
                    $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse))->where('apNameperiod','PRIMER PERIODO')->where('apNameperiod','SEGUNDO PERIODO')->where('apNameperiod','TERCER PERIODO')->first();
                    if($academicperiodValidate == null){
                        Academicperiod::create([
                            'apNameperiod' => 'PRIMER PERIODO',
                            'apDateInitial' => trim($request->apDateFinalThree_one),
                            'apDateFinal' => trim($request->apDateFinalThree_one),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusThree_one)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'SEGUNDO PERIODO',
                            'apDateInitial' => trim($request->apDateInitialThree_two),
                            'apDateFinal' => trim($request->apDateFinalThree_two),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusThree_two)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'TERCER PERIODO',
                            'apDateInitial' => trim($request->apDateInitialThree_three),
                            'apDateFinal' => trim($request->apDateFinalThree_three),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusThree_three)
                        ]);
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SuccessSaveAcademicperiod', 'Se ha definido el PRIMERO, SEGUNDO y TERCERO PERIODO para el curso ' . $course->name . ' correctamente');
                    }else{
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'Ya existe el PRIMERO, SEGUNDO o TERCERO PERIODO para el curso ' . $course->name);
                    }
                }else if($request->countPeriod == 4){
                    $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse))->where('apNameperiod','PRIMER PERIODO')->where('apNameperiod','SEGUNDO PERIODO')->where('apNameperiod','TERCER PERIODO')->where('apNameperiod','CUARTO PERIODO')->first();
                    if($academicperiodValidate == null){
                        Academicperiod::create([
                            'apNameperiod' => 'PRIMER PERIODO',
                            'apDateInitial' => trim($request->apDateFinalFour_one),
                            'apDateFinal' => trim($request->apDateFinalFour_one),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusFour_one)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'SEGUNDO PERIODO',
                            'apDateInitial' => trim($request->apDateInitialFour_two),
                            'apDateFinal' => trim($request->apDateFinalFour_two),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusFour_two)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'TERCER PERIODO',
                            'apDateInitial' => trim($request->apDateInitialFour_three),
                            'apDateFinal' => trim($request->apDateFinalFour_three),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusFour_three)
                        ]);
                        Academicperiod::create([
                            'apNameperiod' => 'CUARTO PERIODO',
                            'apDateInitial' => trim($request->apDateInitialFour_four),
                            'apDateFinal' => trim($request->apDateFinalFour_four),
                            'apCourse_id' => trim($request->apCourse),
                            'apStatus' => trim($request->apStatusFour_four)
                        ]);
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SuccessSaveAcademicperiod', 'Se ha definido el PRIMERO, SEGUNDO, TERCERO y CUARTO PERIODO para el curso ' . $course->name . ' correctamente');
                    }else{
                        $course = Course::find(trim($request->apCourse));
                        return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'Ya existe el PRIMERO, SEGUNDO, TERCERO o CUARTO PERIODO para el curso ' . $course->name);
                    }
                }
            }else if($request->optionAll == 'NO'){
                $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse))->where('apNameperiod',trim($request->apNamePeriodUnique))->first();
                if($academicperiodValidate == null){
                    Academicperiod::create([
                        'apNameperiod' => trim($request->apNamePeriodUnique),
                        'apDateInitial' => trim($request->apDateInitialUnique),
                        'apDateFinal' => trim($request->apDateFinalUnique),
                        'apCourse_id' => trim($request->apCourse),
                        'apStatus' => trim($request->apStatusUnique)
                    ]);
                    $course = Course::find(trim($request->apCourse));
                    return redirect()->route('academicperiod')->with('SuccessSaveAcademicperiod', 'Se ha definido el ' . trim($request->apNamePeriodUnique) . ' para el curso ' . $course->name . ' correctamente');
                }else{
                    $course = Course::find(trim($request->apCourse));
                    return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'Ya existe el ' . trim($request->apNamePeriodUnique) . ' para el curso ' . $course->name);
                }
            }
                
    	}catch(Exception $ex){
    		return redirect()->route('academicperiod')->with('SecondarySaveAcademicperiod', 'No es posible definir los periodos ahora, comuniquese con el administrador');
    	}
    }

    function updateAcademicperiod(Request $request){
        try{
            //dd($request->all());
            $academicperiodValidate = Academicperiod::where('apCourse_id',trim($request->apCourse_idEdit))
                                        ->where('apNameperiod',trim($request->apNameperiodEdit))
                                        ->whereDate('apDateInitial','>=',trim($request->apDateInitialEdit))
                                        ->whereDate('apDateFinal','<=',trim($request->apDateFinalEdit))
                                        ->where('apId','!=',trim($request->apIdEdit))
                                        ->first();
            if($academicperiodValidate == null){
                $academicperiod =  Academicperiod::find(trim($request->apIdEdit));
                $academicperiod->apNamePeriod = trim($request->apNameperiodEdit);
                $academicperiod->apDateInitial = trim($request->apDateInitialEdit);
                $academicperiod->apDateFinal = trim($request->apDateFinalEdit);
                $academicperiod->apCourse_id = trim($request->apCourse_idEdit);
                $academicperiod->apStatus = trim($request->apStatusEdit);
                $academicperiod->save();
                return redirect()->route('academicperiod')->with('PrimaryUpdateAcademicperiod', 'Se han guardado los cambios correctamente para el periodo ' . trim($request->apNameperiodEdit));
            }else{
                return redirect()->route('academicperiod')->with('SecondaryUpdateAcademicperiod', 'Ya existe un periodo diferente para este curso que se cruza con el rango de fechas seleccionado');
            }
        }catch(Exception $ex){
            return redirect()->route('academicperiod')->with('SecondaryUpdateAcademicperiod', 'Ya existe un periodo diferente para este curso que se cruza con el rango de fechas seleccionado');
        }
    }

    function deleteAcademicperiod(Request $request){
        try{
            $academicperiodDelete = Academicperiod::find($request->apIdDelete);
            $namePeriod = $academicperiodDelete->apNameperiod . ' del curso ' . $request->nameCourseDelete;
            $academicperiodDelete->delete();
            return redirect()->route('academicperiod')->with('WarningDeleteAcademicperiod', 'Registro ' . $namePeriod . ', Eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('academicperiod')->with('SecondaryDeleteAcademicperiod', 'No es posible eliminar el registro ahora, Comuníquese con el administrador');
        }
    }
}
