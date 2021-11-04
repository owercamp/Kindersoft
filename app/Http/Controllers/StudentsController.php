<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NewStudentRequest;

use Spatie\Flash\Message;

use App\Models\Student;
use App\Models\Document;
use App\Models\Bloodtype;
use App\Models\Health;
use App\Models\City;
use App\Models\Location;
use App\Models\District;
use App\Models\Legalization;
use Carbon\Carbon;
use Exception;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index()
    {
        $students = Student::all();
        foreach ($students as $key) {
            $id = $key->id;
            $birthDate = $key->birthdate;
            $birtDates = Carbon::createFromDate($birthDate);
            $now = Carbon::now()->format('Y-m-d');
            $year = $birtDates->diffInYears($now, true);
            $month = $birtDates->addYear($year)->diffInMonths($now, true);
            $day = $birtDates->addMonth($month)->diffInDays($now, true);
            $student = Student::find($id);
            if ($student != null) {
                $all = sprintf("%'.02d\n", $year) . ' años, ' . sprintf("%'.02d\n", $month) . ' meses, ' . sprintf("%'.02d\n", $day) . ' dias.';
                $student->yearsold = $all;
                $student->save();
            }
        }
        return view('modules.students.index', compact('students'));
    }

    function editStudent($id)
    {
        $student = Student::find($id);
        $MyPhoto = $student->numberdocument . "_photo.jpeg";
        $ph = Storage::disk('kindersoft')->exists('admisiones/fotosaspirantes/' . $MyPhoto);
        if (!$ph) {
            if ($student->gender == "MASCULINO") {
                $MyPhoto = 'niñodefault.jpg';
            } elseif ($student->gender == "FEMENINO") {
                $MyPhoto = 'niñadefault.jpg';
            }
        }
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $healths = Health::all();
        $citys = City::all();
        return view('modules.students.edit', compact('student', 'documents', 'bloodtypes', 'healths', 'citys', 'MyPhoto'));
    }

    function updateStudent(Request $request, $id)
    {
        try {
            //dd($request->all());
            $studentUpdate = Student::where('typedocument_id', trim($request->typedocument_id_edit))
                ->where('numberdocument', trim($request->numberdocument_edit))
                ->where('id', '!=', $id)
                ->first();
            if ($studentUpdate == null) {
                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo');
                    $namephoto = $photo->getClientOriginalName();
                    Storage::disk('kindersoft')->putFileAs('students', $photo, $namephoto);
                    $student = Student::find($id);
                    $student->typedocument_id = $request->typedocument_id_edit;
                    $student->numberdocument = $request->numberdocument_edit;
                    $student->firstname = mb_strtoupper(trim($request->firstname_edit));
                    $student->threename = mb_strtoupper(trim($request->threename_edit));
                    $student->fourname = mb_strtoupper(trim($request->fourname_edit));
                    $student->birthdate = $request->birthdate_edit;
                    $student->yearsold = $request->yearsold_edit . '-' . $request->monthold_edit;
                    $student->photo = $namephoto;
                    $student->address = mb_strtoupper(trim($request->address_edit));
                    $student->cityhome_id = $request->cityhome_id_edit;
                    $student->locationhome_id = $request->locationhome_id_edit;
                    $student->dictricthome_id = $request->dictricthome_id_edit;
                    $student->bloodtype_id = $request->bloodtype_id_edit;
                    $student->gender = mb_strtoupper(trim($request->gender_edit));
                    $student->health_id = $request->health_id_edit;
                    $student->additionalHealt = mb_strtoupper(trim($request->additionalHealt_edit));
                    $student->additionalHealtDescription = mb_strtoupper(trim($request->additionalHealtDescription_edit));
                    $student->save();
                    return redirect()->route('students')->with('PrimaryUpdateStudent', 'Alumn@ con ID: ' . $request->numberdocument_edit . ' actualizado correctamente');
                } else {
                    $student = Student::find($id);
                    $student->typedocument_id = $request->typedocument_id_edit;
                    $student->numberdocument = $request->numberdocument_edit;
                    $student->firstname = mb_strtoupper(trim($request->firstname_edit));
                    $student->threename = mb_strtoupper(trim($request->threename_edit));
                    $student->fourname = mb_strtoupper(trim($request->fourname_edit));
                    $student->birthdate = $request->birthdate_edit;
                    $student->yearsold = $request->yearsold_edit . '-' . $request->monthold_edit;
                    $student->address = mb_strtoupper(trim($request->address_edit));
                    $student->cityhome_id = $request->cityhome_id_edit;
                    $student->locationhome_id = $request->locationhome_id_edit;
                    $student->dictricthome_id = $request->dictricthome_id_edit;
                    $student->bloodtype_id = $request->bloodtype_id_edit;
                    $student->gender = mb_strtoupper(trim($request->gender_edit));
                    $student->health_id = $request->health_id_edit;
                    $student->additionalHealt = mb_strtoupper(trim($request->additionalHealt_edit));
                    $student->additionalHealtDescription = mb_strtoupper(trim($request->additionalHealtDescription_edit));
                    $student->save();
                    return redirect()->route('students')->with('PrimaryUpdateStudent', 'Alumn@ con ID: ' . $request->numberdocument_edit . ' actualizado correctamente');
                }
            } else {
                return redirect()->route('students')->with('SecondaryUpdateStudent', 'Alumn@ con ID: ' . $request->numberdocument_edit . ' NO ACTUALIZADO, Ya existe un estudiante con el numero de identificación ingresado');
            }
        } catch (Exception $ex) {
            return redirect()->route('students')->with('SecondaryUpdateStudent', 'Error!!, No fue posible actualizar el registro');
        }
    }

    function deleteStudent($id)
    {
        try {
            $student = Student::find($id);
            $names = $student->firstname . " con ID: " . $student->numberdocument;
            $student->delete();
            return redirect()->route('students')->with('WarningDeleteStudent', 'Registro ' . $names . ' eliminado correctamente');
        } catch (Exception $ex) {
            return redirect()->route('students')->with('SecondaryDeleteStudent', 'Error!!, No fue posible eliminar el registro');
        }
    }

    function activeStudent($id)
    {
        $active = Student::find($id);
        $validContractDayStudent = Legalization::where('legStudent_id', trim($id))
            ->whereDate('legDateFinal', '>=', Carbon::now()->format('Y-m-d'))
            ->first();
        if ($validContractDayStudent == null) {
            $inactive = Student::find($id);
            if ($inactive != null) {
                $inactive->status = "INACTIVO";
                $inactive->save();
                return redirect()->route('students')->with('SecondaryUpdateStudent', 'Estado del alumno ' . $this->upper($inactive->firstname) . ' ' . $this->upper($inactive->threename) . ' fue actualizado a: INACTIVO');
            } else {
                return redirect()->route('students')->with('SecondaryUpdateStudent', 'Error al actualizar el estado del alumno');
            }
        } else {
            return redirect()->route('students')->with('SecondaryUpdateStudent', 'El alumno ' . $this->upper($active->firstname) . ' ' . $this->upper($active->threename) . ' cuenta con contratos relacionados');
        }
    }

    function inactiveStudent($id)
    {
        $active = Student::find($id);
        $validContractDay = Legalization::where('legStudent_id', trim($id))
            ->whereDate('legDateFinal', '>=', Carbon::now()->format('Y-m-d'))
            ->first();
        if ($validContractDay == null) {
            $inactive = Student::find($id);
            if ($inactive != null) {
                $inactive->status = "ACTIVO";
                $inactive->save();
                return redirect()->route('students')->with('SecondaryUpdateStudent', 'Estado del alumno ' . $this->upper($inactive->firstname) . ' ' . $this->upper($inactive->threename) . ' fue actualizado a: ACTIVO');
            } else {
                return redirect()->route('students')->with('SecondaryUpdateStudent', 'Error al actualizar el estado del alumno');
            }
        } else {
            return redirect()->route('students')->with('SecondaryUpdateStudent', 'El alumno ' . $this->upper($active->firstname) . ' ' . $this->upper($active->threename) . ' cuenta con contratos relacionados');
        }
    }

    function newStudent(Request $request)
    {
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $healths = Health::all();
        $citys = City::all();
        return view('modules.students.new', compact('documents', 'bloodtypes', 'healths', 'citys'));
    }

    function saveStudent(Request $request)
    {
        try {
            $studentSave = Student::where('typedocument_id', trim($request->typedocument_id))
                ->where('numberdocument', trim($request->numberdocument))
                ->first();
            if ($studentSave == null) {
                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo');
                    $namephoto = $photo->getClientOriginalName();
                    Storage::disk('kindersoft')->putFileAs('students', $photo, $namephoto);
                    Student::create([
                        'typedocument_id' => $request->typedocument_id,
                        'numberdocument' => $request->numberdocument,
                        'photo' => $namephoto,
                        'firstname' => mb_strtoupper(trim($request->firstname)),
                        'threename' => mb_strtoupper(trim($request->threename)),
                        'fourname' => mb_strtoupper(trim($request->fourname)),
                        'birthdate' => $request->birthdate,
                        'yearsold' => $request->yearsold . "-" . $request->monthold,
                        'address' => mb_strtoupper(trim($request->address)),
                        'cityhome_id' => $request->cityhome_id,
                        'locationhome_id' => $request->locationhome_id,
                        'dictricthome_id' => $request->dictricthome_id,
                        'bloodtype_id' => $request->bloodtype_id,
                        'gender' => mb_strtoupper(trim($request->gender)),
                        'health_id' => $request->health_id,
                        'additionalHealt' => mb_strtoupper(trim($request->additionalHealt)),
                        'additionalHealtDescription' => mb_strtoupper(trim($request->additionalHealtDescription))
                    ]);
                    return redirect()->route('student.new')->with('SuccessSaveStudent', 'Registro con ID: ' . $request->numberdocument . ' creado correctamente');
                } else {
                    Student::create([
                        'typedocument_id' => $request->typedocument_id,
                        'numberdocument' => $request->numberdocument,
                        'photo' => 'studentdefault.png',
                        'firstname' => mb_strtoupper(trim($request->firstname)),
                        'threename' => mb_strtoupper(trim($request->threename)),
                        'fourname' => mb_strtoupper(trim($request->fourname)),
                        'birthdate' => $request->birthdate,
                        'yearsold' => $request->yearsold . "-" . $request->monthold,
                        'address' => mb_strtoupper(trim($request->address)),
                        'cityhome_id' => $request->cityhome_id,
                        'locationhome_id' => $request->locationhome_id,
                        'dictricthome_id' => $request->dictricthome_id,
                        'bloodtype_id' => $request->bloodtype_id,
                        'gender' => mb_strtoupper(trim($request->gender)),
                        'health_id' => $request->health_id,
                        'additionalHealt' => mb_strtoupper(trim($request->additionalHealt)),
                        'additionalHealtDescription' => mb_strtoupper(trim($request->additionalHealtDescription))
                    ]);
                    return redirect()->route('student.new')->with('SuccessSaveStudent', 'Registro con ID: ' . $request->numberdocument . ' creado correctamente');
                }
            } else {
                return redirect()->route('student.new')->with('SecondarySaveStudent', 'Ya existe un estudiante con el numero de identificación ingresado');
            }
        } catch (Exception $ex) {
            return redirect()->route('student.new')->with('SecondarySaveStudent', 'No es posible crear el registro ahora, comuniquese con el administrador');
        }
    }

    function detailsStudent($id)
    {
        $student = Student::find($id);
        $MyPhoto = $student->numberdocument . "_photo.jpeg";
        $ph = Storage::disk('kindersoft')->exists('admisiones/fotosaspirantes/' . $MyPhoto);
        if (!$ph) {
            if ($student->gender == "MASCULINO") {
                $MyPhoto = 'niñodefault.jpg';
            } elseif ($student->gender == "FEMENINO") {
                $MyPhoto = 'niñadefault.jpg';
            }
        }
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $healths = Health::all();
        $citys = City::all();
        $locations = Location::all();
        $districts = District::all();
        return view('modules.students.details', compact('student', 'documents', 'bloodtypes', 'healths', 'citys', 'locations', 'districts', 'MyPhoto'));
    }
}
