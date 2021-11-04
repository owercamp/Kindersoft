<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\City;
use App\Models\Location;
use App\Models\District;
use App\Models\Document;
use App\Models\Bloodtype;
use App\Models\Profession;
use App\Models\Health;
use App\Models\Grade;
use App\Models\Course;
use App\Models\Achievement;
use App\Models\Intelligence;
use App\Models\User;
use App\Models\Period;
use App\Models\ConsolideAchievement;

class AdministrativoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function databaseTo(){
    	return view('modules.database');
    }

    public function academicTo(){
        return view('modules.academic');
    }

    public function humansTo(){
        return view('modules.humans');
    }

    public function servicesTo(){
        return view('modules.services');
    }

    public function achievementTo(){
        $grades = Grade::all();
        $intelligences = Intelligence::all();
        return view('modules.consolide.indexAchievement', compact('grades','intelligences'));
    }

    public function newAchievementConsolide(Request $request){
        try{
            ConsolideAchievement::firstOrCreate([
                    'period_id' => $request->period_id, 
                    'achievement_id' => $request->achievement_id,
                    'course_id' => $request->course_id
                ],[
                    'period_id' => $request->period_id, 
                    'achievement_id' => $request->achievement_id,
                    'course_id' => $request->course_id
                ]
            );
            return redirect()->route('achievementsAcademics');
        }catch(Exception $ex){
            return redirect()->route('achievementsAcademics');
        }
    }
    
    public function achievementsAll(){
        try{
            $allConsolidated = ConsolideAchievement::select('consolide_achievements.id','grades.name as gradeName','periods.name as periodName','periods.initialDate','periods.finalDate','courses.name as courseName','achievements.name as achievementName','intelligences.type')
            ->join('periods','periods.id','=','consolide_achievements.period_id')
            ->join('grades','grades.id','=','periods.grade_id')
            ->join('courses','courses.id','=','consolide_achievements.course_id')
            ->join('achievements','achievements.id','=','consolide_achievements.achievement_id')
            ->join('intelligences','intelligences.id','=','achievements.intelligence_id')
            ->get();
            return view('modules.consolide.registrysConsolidated', compact('allConsolidated'));
        }catch(Exception $ex){
            return view('modules.consolide.registrysConsolidated');
        }
    }

    public function deleteConsolidatedEchievement($id){
        try{
            $registryForDelete = ConsolideAchievement::find($id);
            $registryForDelete->delete();
            return redirect()->route('consolidatedAchievements.all')->with('WarningDeleteAchievementConsolidated', 'Logro seleccionado, eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('consolidatedAchievements.all')->with('SecondaryDeleteAchievementConsolidated', 'Error!!, No es posible eliminar el logro establecido');
        }
    }

    public function editConsolidatedEchievement($id){
        try{
            $consolidated = ConsolideAchievement::select('consolide_achievements.id','grades.name as gradeName','periods.name as periodName','periods.initialDate','periods.finalDate','courses.name as courseName','achievements.name as achievementName','intelligences.type')
                ->join('periods','periods.id','=','consolide_achievements.period_id')
                ->join('grades','grades.id','=','periods.grade_id')
                ->join('courses','courses.id','=','consolide_achievements.course_id')
                ->join('achievements','achievements.id','=','consolide_achievements.achievement_id')
                ->join('intelligences','intelligences.id','=','achievements.intelligence_id')
                ->where('consolide_achievements.id',$id)
                ->get();
            $grades = Grade::all();
            $intelligences = Intelligence::all();
            return view('modules.consolide.editConsolidated', compact('consolidated','grades','intelligences'));
        }catch(Exception $ex){
            return view('modules.consolide.editConsolidated');
        }
    }
}
