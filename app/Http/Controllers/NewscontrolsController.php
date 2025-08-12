<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Course;
use App\Models\Garden;
use App\Models\Feeding;
use App\Models\Journey;
use App\Models\Student;
use App\Models\Supplie;
use App\Models\Uniform;
use App\Models\Presence;
use App\Models\Extratime;
use App\Models\Transport;
use App\Models\Assistance;
use App\Models\Eventdiary;
use App\Models\Sphincters;
use App\Models\Autorization;
use App\Models\Legalization;
use Illuminate\Http\Request;
use App\Models\Eventcreation;
use App\Models\HealthControl;
use App\Models\FeedingControl;
use App\Models\Extracurricular;
use Illuminate\Support\Facades\DB;

class NewscontrolsCOntroller extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	/*-----------------------------------
	 - CONTROL DE ALIMENTACION -
	 -----------------------------------*/
	function feedingsControlTo()
	{
		$datenow = Date('Y-m-d');
		$hour = Date('G');
		if ($hour < 5) {
			$datenow = Date('Y-m-d', strtotime($datenow . ' - 1 days'));
		}
		$feedingsControl = FeedingControl::where('fcDate', $datenow)->distinct('fcLegalization_id')->get();
		// dd($feedingsControl);
		$result = array();
		foreach ($feedingsControl as $feeding) {
			$dates = legalization::select(
				'legalizations.*',
				DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
				'students.yearsold',
				'grades.name as grade',
				DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
				'attendants.phoneone',
				'attendants.emailone'
			)
				->join('students', 'students.id', 'legStudent_id')
				->join('attendants', 'attendants.id', 'legAttendantfather_id')
				->join('grades', 'grades.id', 'legGrade_id')
				->where('legId', $feeding->fcLegalization_id)->first();

			if ($dates != null) {
				array_push($result, [
					$dates->legId,
					$dates->nameStudent,
					$dates->yearsold,
					$dates->grade,
					$dates->nameAttendant,
					$dates->phoneone,
					$dates->emailone,
					$feeding->fcNews
				]);
			}
			else {
				$dates = legalization::select(
					'legalizations.*',
					DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
					'students.yearsold',
					'grades.name as grade',
					DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
					'attendants.phoneone',
					'attendants.emailone'
				)
					->join('students', 'students.id', 'legStudent_id')
					->join('attendants', 'attendants.id', 'legAttendantmother_id')
					->join('grades', 'grades.id', 'legGrade_id')
					->where('legId', $feeding->fcLegalization_id)->first();

				if ($dates != null) {
					array_push($result, [
						$dates->legId,
						$dates->nameStudent,
						$dates->yearsold,
						$dates->grade,
						$dates->nameAttendant,
						$dates->phoneone,
						$dates->emailone,
						$feeding->fcNews
					]);
				}
			}
		}
		$grades = Grade::all();
		return view('modules.newscontrols.feedingsControl', compact('result', 'datenow', 'grades'));
	}

	function newFeedings(Request $request)
	{
		try {
			// dd($request->all());
			/*
			 $request->newControl_DateHidden
			 $request->newControl_Date
			 $request->newControl_Grade
			 $request->newControl_Course
			 $request->newControl_Student
			 $request->newControl_type
			 $request->newControl_NewFeedings
			 */
			$hour = Date('G');
			if ($hour < 5) {
				$date = trim($request->newControl_DateHidden);
			}
			else {
				$date = Date('Y-m-d');
			}
			$legalization = Legalization::select('legalizations.legId')
				->where('legStudent_id', trim($request->newControl_Student))
				->where('legGrade_id', trim($request->newControl_Grade))
				->first();
			$student = Student::find(trim($request->newControl_Student));
			$nameStudent = $student->firstname . ' ' . $student->threename . ' ' . $student->fourname;
			// VALIDAR SI EXISTE YA NOVEDADES PARA EL ALUMNO Y FECHA SELECCIONADA
			$validateFeeding = FeedingControl::where('fcDate', $date)
				->where('fcLegalization_id', $legalization->legId)
				->first();
			// dd($legalization->legId);
			$joinTypenew = trim($request->newControl_type) . '=|=' . trim($request->newControl_NewFeedings);
			if ($validateFeeding != null) {
				$validateFeeding->fcNews .= '==' . $joinTypenew;
				$validateFeeding->save();
				return redirect()->route('feedings.control')->with('PrimaryUpdateFeedings', 'NOVEDAD AGREGADA CORRECTAMENTE PARA ALUMNO: ' . $nameStudent);
			}
			else {
				FeedingControl::create([
					'fcDate' => $date,
					'fcLegalization_id' => $legalization->legId,
					'fcNews' => $joinTypenew
				]);
				return redirect()->route('feedings.control')->with('SuccessCreateFeedings', 'NOVEDAD CREADA CORRECTAMENTE PARA ALUMNO: ' . $nameStudent);
			}
		}
		catch (Exception $ex) {
			return redirect()->route('feedings.control')->with('SecondaryCreateFeedings', 'NO ES POSIBLE AÑADIR NOVEDADES AHORA A LA BASE DE DATOS');
		}
	}
	/*-----------------------------------
	 # CONTROL DE ALIMENTACION #
	 -----------------------------------*/


	/*-----------------------------------
	 - CONTROL DE ESFINTERES -
	 -----------------------------------*/
	function sphinctersControlTo()
	{
		$datenow = Date('Y-m-d');
		$hour = Date('G');
		if ($hour < 5) {
			$datenow = Date('Y-m-d', strtotime($datenow . ' - 1 days'));
		}
		$sphincters = Sphincters::where('spDate', $datenow)->distinct('spLegalization_id')->get();
		$result = array();
		foreach ($sphincters as $sphincter) {
			$dates = legalization::select(
				'legalizations.*',
				DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
				'students.yearsold',
				'grades.name as grade',
				DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
				'attendants.phoneone',
				'attendants.emailone'
			)
				->join('students', 'students.id', 'legStudent_id')
				->join('attendants', 'attendants.id', 'legAttendantfather_id')
				->join('grades', 'grades.id', 'legGrade_id')
				->where('legId', $sphincter->spLegalization_id)->first();

			if ($dates != null) {
				array_push($result, [
					$dates->legId,
					$dates->nameStudent,
					$dates->yearsold,
					$dates->grade,
					$dates->nameAttendant,
					$dates->phoneone,
					$dates->emailone,
					$sphincter->spNews
				]);
			}
			else {
				$dates = legalization::select(
					'legalizations.*',
					DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
					'students.yearsold',
					'grades.name as grade',
					DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
					'attendants.phoneone',
					'attendants.emailone'
				)
					->join('students', 'students.id', 'legStudent_id')
					->join('attendants', 'attendants.id', 'legAttendantmother_id')
					->join('grades', 'grades.id', 'legGrade_id')
					->where('legId', $sphincter->spLegalization_id)->first();

				if ($dates != null) {
					array_push($result, [
						$dates->legId,
						$dates->nameStudent,
						$dates->yearsold,
						$dates->grade,
						$dates->nameAttendant,
						$dates->phoneone,
						$dates->emailone,
						$sphincter->spNews
					]);
				}
			}
		}
		$grades = Grade::all();
		return view('modules.newscontrols.sphincters', compact('result', 'datenow', 'grades'));
	}

	function newSphincters(Request $request)
	{
		try {
			// dd($request->all());
			/*
			 $request->newControl_DateHidden
			 $request->newControl_Date
			 $request->newControl_Grade
			 $request->newControl_Course
			 $request->newControl_Student
			 $request->newControl_NewSphinters
			 */
			$hour = Date('G');
			if ($hour < 5) {
				$date = trim($request->newControl_DateHidden);
			}
			else {
				$date = Date('Y-m-d');
			}
			$legalization = Legalization::select('legalizations.legId')
				->where('legStudent_id', trim($request->newControl_Student))
				->where('legGrade_id', trim($request->newControl_Grade))
				->first();
			$student = Student::find(trim($request->newControl_Student));
			$nameStudent = $student->firstname . ' ' . $student->threename . ' ' . $student->fourname;
			// VALIDAR SI EXISTE YA NOVEDADES PARA EL ALUMNO Y FECHA SELECCIONADA
			$validateSphincter = Sphincters::where('spDate', $date)
				->where('spLegalization_id', $legalization->legId)
				->first();
			// dd($legalization->legId);
			if ($validateSphincter != null) {
				$validateSphincter->spNews .= '==' . trim($request->newControl_NewSphinters);
				$validateSphincter->save();
				return redirect()->route('sphincters')->with('PrimaryUpdateSphincters', 'NOVEDAD AGREGADA CORRECTAMENTE PARA ALUMNO: ' . $nameStudent);
			}
			else {
				Sphincters::create([
					'spDate' => $date,
					'spLegalization_id' => $legalization->legId,
					'spNews' => trim($request->newControl_NewSphinters)
				]);
				return redirect()->route('sphincters')->with('PrimarySuccessSphincters', 'NOVEDAD CREADA CORRECTAMENTE PARA ALUMNO:' . $nameStudent);
			}
		}
		catch (Exception $ex) {
			return redirect()->route('sphincters')->with('SecondarySuccessSphincters', 'NO ES POSIBLE AÑADIR NOVEDADES AHORA A LA BASE DE DATOS');
		}
	}
	/*-----------------------------------
	 # CONTROL DE ESFINTERES #
	 -----------------------------------*/

	/*-----------------------------------
	 - CONTROL DE ENFERMERIA -
	 -----------------------------------*/
	function healthsControlTo()
	{
		$datenow = Date('Y-m-d');
		$hour = Date('G');
		if ($hour < 5) {
			$datenow = Date('Y-m-d', strtotime($datenow . ' - 1 days'));
		}
		$healthsControl = HealthControl::where('hcDate', $datenow)->distinct('hcLegalization_id')->get();
		// dd($healthsControl);
		$result = array();
		foreach ($healthsControl as $health) {
			$dates = legalization::select(
				'legalizations.*',
				DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
				'students.yearsold',
				'grades.name as grade',
				DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
				'attendants.phoneone',
				'attendants.emailone'
			)
				->join('students', 'students.id', 'legStudent_id')
				->join('attendants', 'attendants.id', 'legAttendantfather_id')
				->join('grades', 'grades.id', 'legGrade_id')
				->where('legId', $health->hcLegalization_id)->first();

			if ($dates != null) {
				array_push($result, [
					$dates->legId,
					$dates->nameStudent,
					$dates->yearsold,
					$dates->grade,
					$dates->nameAttendant,
					$dates->phoneone,
					$dates->emailone,
					$health->hcNews
				]);
			}
			else {
				$dates = legalization::select(
					'legalizations.*',
					DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"),
					'students.yearsold',
					'grades.name as grade',
					DB::raw("CONCAT(attendants.firstname,' ',attendants.threename) AS nameAttendant"),
					'attendants.phoneone',
					'attendants.emailone'
				)
					->join('students', 'students.id', 'legStudent_id')
					->join('attendants', 'attendants.id', 'legAttendantmother_id')
					->join('grades', 'grades.id', 'legGrade_id')
					->where('legId', $health->hcLegalization_id)->first();

				if ($dates != null) {
					array_push($result, [
						$dates->legId,
						$dates->nameStudent,
						$dates->yearsold,
						$dates->grade,
						$dates->nameAttendant,
						$dates->phoneone,
						$dates->emailone,
						$health->hcNews
					]);
				}
			}
		}
		$grades = Grade::all();
		return view('modules.newscontrols.healthControl', compact('result', 'datenow', 'grades'));
	}

	function newHealths(Request $request)
	{
		try {
			// dd($request->all());
			/*
			 $request->newControl_DateHidden
			 $request->newControl_Date
			 $request->newControl_Grade
			 $request->newControl_Course
			 $request->newControl_Student
			 $request->newControl_NewHealths
			 */
			$hour = Date('G');
			if ($hour < 5) {
				$date = trim($request->newControl_DateHidden);
			}
			else {
				$date = Date('Y-m-d');
			}
			$legalization = Legalization::select('legalizations.legId')
				->where('legStudent_id', trim($request->newControl_Student))
				->where('legGrade_id', trim($request->newControl_Grade))
				->first();
			$student = Student::find(trim($request->newControl_Student));
			$nameStudent = $student->firstname . ' ' . $student->threename . ' ' . $student->fourname;
			// VALIDAR SI EXISTE YA NOVEDADES PARA EL ALUMNO Y FECHA SELECCIONADA
			$validateHealth = HealthControl::where('hcDate', $date)
				->where('hcLegalization_id', $legalization->legId)
				->first();
			// dd($legalization->legId);
			if ($validateHealth != null) {
				$validateHealth->hcNews .= '==' . trim($request->newControl_NewHealths);
				$validateHealth->save();
				return redirect()->route('health.control')->with('PrimaryUpdateHealths', 'NOVEDAD AGREGADA CORRECTAMENTE PARA ALUMNO: ' . $nameStudent);
			}
			else {
				HealthControl::create([
					'hcDate' => $date,
					'hcLegalization_id' => $legalization->legId,
					'hcNews' => trim($request->newControl_NewHealths)
				]);
				return redirect()->route('health.control')->with('SuccessCreateHealths', 'NOVEDAD CREADA CORRECTAMENTE PARA ALUMNO: ' . $nameStudent);
			}
		}
		catch (Exception $ex) {
			return redirect()->route('health.control')->with('SecondaryCreateHealths', 'NO ES POSIBLE AÑADIR NOVEDADES AHORA A LA BASE DE DATOS');
		}
	}
	/*-----------------------------------
	 # CONTROL DE ENFERMERIA #
	 -----------------------------------*/

	/*-----------------------------------
	 - REPORTES DIARIOS -
	 -----------------------------------*/

	function reportdailyTo()
	{
		return view('modules.newscontrols.reportdaily');
	}

	function reportdailyPdf(Request $request)
	{
		try {

			// $request->date_report
			// dd($request->all());

			$date = Date('Y-m-d', strtotime($request->date_report));
			
			$dates = Carbon::create($request->date_report)->locale('es')->isoFormat('LL');
			$day = Carbon::create($request->date_report)->locale('es')->dayName;
			$dateSearch = ucfirst($day) . " " . $dates;

			$assistances = Presence::with('student:id,firstname,threename,fourname','course:id,name')->where('pre_date',$dateSearch)->get();	
			$countPresent = Presence::with('student:id,firstname,threename,fourname','course:id,name')->where([['pre_date',$dateSearch],['pre_status','PRESENTE']])->count();	

			$idsPresents = '';
			$idsAbsents = '';
			$consolidated = array();
			//CARGA DE ALUMNOS PRESENTES
			$datesPresents = array();

			foreach ($assistances as $key => $assistance) {
				if ($assistance->pre_status == "PRESENTE") {
					/** ALMACENAMOS LOS ALUMNOS PRESENTES **/
					array_push($consolidated,[
						'ASISTENCIA',
						$assistance->course->name, //nombre del curso
						$countPresent,
						$assistance->student->firstname." ".$assistance->student->threename." ".$assistance->student->fourname, // nombre del estudiante
						$assistance->pre_harrival, // Hora Llegada
						$assistance->pre_hexit, // Hora Salida
					]);
					} else {
						/** ALMACENAMOS LOS ALUMNOS INASISTENTES **/
						array_push($consolidated,[
							'INASISTENCIA',
							$assistance->course->name, //nombre del curso
							$assistance->student->firstname." ".$assistance->student->threename." ".$assistance->student->fourname, // nombre del estudiante
						]);
					}
				}

			$studentsall = Student::all();
			foreach ($studentsall as $student) {
				$legalization = Legalization::where('legStudent_id', $student->id)->first();
				$details = array();
				if ($legalization != null) {
					// AUTORIZACIONES
					$autorization = Autorization::where('auDate', $date)->where('auStudent_id', $student->id)->first();
					if ($autorization != null) {
						$separatedItemsAutorized = explode('-', $autorization->auAutorized);
						for ($a = 0; $a < count($separatedItemsAutorized); $a++) {
							$separatedAutorizedIds = explode(':', $separatedItemsAutorized[$a]);
							if ($separatedAutorizedIds[0] == 'JORNADA') {
								$journey = Journey::find($separatedAutorizedIds[1]);
								if ($journey != null) {
									array_push($details, [
										'JORNADA',
										$journey->jouJourney
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'ALIMENTACION') {
								$feeding = Feeding::find($separatedAutorizedIds[1]);
								if ($feeding != null) {
									array_push($details, [
										'ALIMENTACION',
										$feeding->feeConcept
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'UNIFORME') {
								$uniform = Uniform::find($separatedAutorizedIds[1]);
								if ($uniform != null) {
									array_push($details, [
										'UNIFORME',
										$uniform->uniConcept
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'MATERIAL ESCOLAR') {
								$supplie = Supplie::find($separatedAutorizedIds[1]);
								if ($supplie != null) {
									array_push($details, [
										'MATERIAL ESCOLAR',
										$supplie->supConcept
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'TIEMPO EXTRA') {
								$extratime = Extratime::find($separatedAutorizedIds[1]);
								if ($extratime != null) {
									array_push($details, [
										'TIEMPO EXTRA',
										$extratime->extTConcept
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'EXTRACURRICULAR') {
								$extracurricular = Extracurricular::find($separatedAutorizedIds[1]);
								if ($extracurricular != null) {
									array_push($details, [
										'EXTRACURRICULAR',
										$extracurricular->extConcept . ' ' . $extracurricular->extIntensity
									]);
								}
							}
							else if ($separatedAutorizedIds[0] == 'TRANSPORTE') {
								$transport = Transport::find($separatedAutorizedIds[1]);
								if ($transport != null) {
									array_push($details, [
										'TRANSPORTE',
										$transport->traConcept
									]);
								}
							}
						}
					}
					//CONTROL DE ALIMENTACION
					$controlfeeding = FeedingControl::where('fcDate', $date)->where('fcLegalization_id', $legalization->legId)->first();
					if ($controlfeeding != null) {
						$separatedNews = explode('==', $controlfeeding->fcNews);
						for ($fc = 0; $fc < count($separatedNews); $fc++) {
							$separatedItems = explode('=|=', $separatedNews[$fc]);
							array_push($details, [
								'CONTROL DE ALIMENTACION',
								$separatedItems[0],
								$separatedItems[1]
							]);
						}
					}
					//CONTROL DE ESFINTERES
					$controlsphincter = Sphincters::where('spDate', $date)->where('spLegalization_id', $legalization->legId)->first();
					if ($controlsphincter != null) {
						$separatedNews = explode('==', $controlsphincter->spNews);
						for ($s = 0; $s < count($separatedNews); $s++) {
							array_push($details, [
								'CONTROL DE ESFINTERES',
								$separatedNews[$s]
							]);
						}
					}
					//CONTROL DE ENFERMERIA
					$controlhealth = HealthControl::where('hcDate', $date)->where('hcLegalization_id', $legalization->legId)->first();
					if ($controlhealth != null) {
						$separatedNews = explode('==', $controlhealth->hcNews);
						for ($h = 0; $h < count($separatedNews); $h++) {
							array_push($details, [
								'CONTROL DE ENFERMERIA',
								$separatedNews[$h]
							]);
						}
					}
				}
				if (count($details) > 0) {
					array_push($consolidated, [
						'DETALLES',
						$student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
						$details
					]);
				}
				else {
					array_push($consolidated, [
						'DETALLES',
						$student->firstname . ' ' . $student->threename . ' ' . $student->fourname,
						'SIN REGISTROS'
					]);
				}
			}

			// REPORTE DE EVENTOS (Independiente del alumno o legalización)
			$controlevents = Eventdiary::where('edDate', $date)->where('edStatus', 1)->get();
			foreach ($controlevents as $controlevent) {
				$creation = Eventcreation::find($controlevent->edCreation_id);
				array_push($consolidated, [
					'EVENTOS',
					$creation->crName,
					$controlevent->edDescription,
					$controlevent->edDescriptionout
				]);
			}
			// dd($consolidated);
			if (count($consolidated) > 0) {
				$garden = Garden::select('garden.*', 'citys.name as nameCity', 'locations.name as nameLocation')
					->join('citys', 'citys.id', 'garden.garCity_id')
					->join('locations', 'locations.id', 'garden.garLocation_id')
					->first();
				$pdf = \App::make('dompdf.wrapper');
				$namefile = 'REPORTE_DIARIO_' . Date('Y-m-d') . '.pdf';
				$pdf->loadView('modules.newscontrols.reportdailyPdf', compact('garden', 'consolidated', 'date'));
				//$pdf->setPaper("A6", "landscape");
				// return $pdf->stream();
				return $pdf->download($namefile);
			}
			else {
				return redirect()->route('reportDaily')->with('SecondaryReport', "NO SE PUEDE GENERAR PDF, NO HAY DATOS DE ASISTENCIAS PARA LA FECHA " . $this->returnDate($date) . " ");
			// return response()->json('SIN DATOS');
			}
		}
		catch (Exception $ex) {
		// Code exception ...
		}
	}

	// FUNCION PARA 
	function returnDate($date)
	{
		$mount = $date[5] . $date[6];
		$day = $date[8] . $date[9];
		$year = $date[0] . $date[1] . $date[2] . $date[3];
		switch ($mount) {
			case '01':
				return $day . ' DE ENERO DEL ' . $year;
			case '02':
				return $day . ' DE FEBRERO DEL ' . $year;
			case '03':
				return $day . ' DE MARZO DEL ' . $year;
			case '04':
				return $day . ' DE ABRIL DEL ' . $year;
			case '05':
				return $day . ' DE MAYO DEL ' . $year;
			case '06':
				return $day . ' DE JUNIO DEL ' . $year;
			case '07':
				return $day . ' DE JULIO DEL ' . $year;
			case '08':
				return $day . ' DE AGOSTO DEL ' . $year;
			case '09':
				return $day . ' DE SEPTIEMBRE DEL ' . $year;
			case '10':
				return $day . ' DE OCTUBRE DEL ' . $year;
			case '11':
				return $day . ' DE NOVIEMBRE DEL ' . $year;
			case '12':
				return $day . ' DE DICIEMBRE DEL ' . $year;
		}
	}
/*-----------------------------------
 - REPORTES DIARIOS -
 -----------------------------------*/
}
