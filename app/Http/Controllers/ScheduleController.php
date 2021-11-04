<?php

namespace App\Http\Controllers;

use App\Mail\MessageInfoDaily;
use App\Models\AcademicCircularFile;
use App\Models\AdministrativeCircularFile;
use App\Models\Collaborator;
use App\Models\Course;
use App\Models\Formadmission;
use App\Models\Garden;
use App\Models\InfoDaily;
use App\Models\Schedule;
use App\Models\ScheduleContext;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  // vista plantillas de saludo
  public function greetingTemplateTo()
  {
    $data = Schedule::all();
    return view('modules.schedules.greeting', compact('data'));
  }

  public function greetingSave(Request $request)
  {
    if ($request != null) {
      Schedule::create([
        'sch_body' => $request->greetingText
      ]);
      return redirect()->route('greetingTemplate')->with('SuccessCreation', 'Saludo creado exitosamente');
    } else {
      return redirect()->route('greetingTemplate')->with('SecondaryCreation', 'Error al crear el saludo');
    }
  }

  public function greetingEdit(Request $request)
  {
    $search = Schedule::where('sch_id', $request->greetingNumberEdit)->first();
    if ($search != null) {
      $search->sch_body = $request->greetingTextEdit;
      $search->save();
      return redirect()->route('greetingTemplate')->with('PrimaryCreation', 'Saludo Actualizado satisfactoriamente');
    } else {
      return redirect()->route('greetingTemplate')->with('SecondaryCreation', 'Error al actualizar el registro');
    }
  }

  public function greetingDelete(Request $request)
  {
    $search = Schedule::where('sch_id', $request->greetingNumberDelete)->first();
    if ($search != null) {
      Schedule::findOrFail($request->greetingNumberDelete)->delete();
      DB::statement('ALTER TABLE schedules AUTO_INCREMENT=1');
      return redirect()->route('greetingTemplate')->with('WarningCreation', 'Saludo eliminado satisfactoriamente');
    } else {
      return redirect()->route('greetingTemplate')->with('SecondaryCreation', 'Error al eliminar el registro');
    }
  }

  // vista del contexto
  public function contextTemplateTo()
  {
    $data = ScheduleContext::all();
    return view('modules.schedules.context', compact('data'));
  }

  public function contextSave(Request $request)
  {
    if ($request != null) {
      ScheduleContext::create([
        'sch_body' => $request->contextText
      ]);
      return redirect()->route('contextTemplate')->with('SuccessCreation', 'Saludo creado exitosamente');
    } else {
      return redirect()->route('contextTemplate')->with('SecondaryCreation', 'Error al crear el saludo');
    }
  }

  public function contextEdit(Request $request)
  {
    $search = ScheduleContext::where('sch_id', $request->contextNumberEdit)->first();
    if ($search != null) {
      $search->sch_body = $request->contextTextEdit;
      $search->save();
      return redirect()->route('contextTemplate')->with('PrimaryCreation', 'Saludo Actualizado satisfactoriamente');
    } else {
      return redirect()->route('contextTemplate')->with('SecondaryCreation', 'Error al actualizar el registro');
    }
  }

  public function contextDelete(Request $request)
  {
    $search = ScheduleContext::where('sch_id', $request->contextNumberDelete)->first();
    if ($search != null) {
      ScheduleContext::findOrFail($request->contextNumberDelete)->delete();
      DB::statement('ALTER TABLE schedule_contexts AUTO_INCREMENT= 1');
      return redirect()->route('contextTemplate')->with('WarningCreation', 'Saludo eliminado satisfactoriamente');
    } else {
      return redirect()->route('contextTemplate')->with('SecondaryCreation', 'Error al eliminar el registro');
    }
  }

  // vista de la informqación diaria
  public function dailyInformationTo()
  {
    $date = Carbon::now()->locale('es')->timezone('America/Bogota');
    $day = $date->dayName;
    $dateNoDay = $date->isoFormat('LL');
    $myDate = $day . ", " . $dateNoDay;

    $Courses = Course::all();
    $Hellos = Schedule::all();
    $Context = ScheduleContext::all();
    $cirAdministrative = AdministrativeCircularFile::select('administrative_circular_file.*', 'bodycircular.*')
      ->join('bodycircular', 'bodycircular.bcId', 'administrative_circular_file.acf_cirBody_id')->get();
    $cirAcademic = AcademicCircularFile::select('academic_circular_files.*', 'bodycircular.*')
      ->join('bodycircular', 'bodycircular.bcId', 'academic_circular_files.acf_cirBody_id')->get();
    return view('modules.schedules.daily', compact('myDate', 'Courses', 'Hellos', 'Context', 'cirAdministrative', 'cirAcademic'));
  }

  public function dailyInformationToSave(Request $request)
  {
    $date = Carbon::now()->locale('es')->timezone('America/Bogota')->isoFormat('LL');
    $day = Carbon::now()->locale('es')->timezone('America/Bogota')->dayName;
    $fulldate = $day . ", " . $date;
    $administrative = AdministrativeCircularFile::findOrFail($request->cirAdministrative)
      ->join('bodycircular', 'bodycircular.bcId', 'administrative_circular_file.acf_cirBody_id')
      ->join('collaborators', 'collaborators.id', 'administrative_circular_file.acf_cirFrom')->get();
    $academic = AcademicCircularFile::findOrFail($request->cirAcademic)
      ->join('bodycircular', 'bodycircular.bcId', 'academic_circular_files.acf_cirBody_id')
      ->join('collaborators', 'collaborators.id', 'academic_circular_files.acf_cirFrom')->get();
    $hi = Schedule::findOrFail($request->myHi);
    $cont = $request->Context;
    if (is_numeric($cont)) {
      $cont1 = ScheduleContext::findOrFail($request->Context);
      $cont = $cont1->sch_body;
    }
    $Emails = [];
    $AttendantsMail = mb_split(",", $request->emailAttendants);
    foreach ($AttendantsMail as $Mail) {
      if ($Mail != "") {
        array_push($Emails, $Mail);
      }
    }
    $files = $request->file('archives');
    $NamesFiles = [];
    $NameFiles = [];
    foreach ($files as $file) {
      $date = date("Y-m-d");
      $fileName = $file->getClientOriginalName();
      array_push($NamesFiles, $date . DIRECTORY_SEPARATOR . $file->getClientOriginalName()); // este es para almacenar para luego buscar
      array_push($NameFiles, $fileName);
      Storage::disk('kindersoft')->putFileAs(DIRECTORY_SEPARATOR . "Documents" . DIRECTORY_SEPARATOR . $date . DIRECTORY_SEPARATOR, $file, $fileName);
    }

    $garden = Garden::select(
      'garden.*',
      'citys.name AS garNameCity',
      'locations.name AS garNameLocation',
      'districts.name AS garNameDistrict'
    )
      ->join('citys', 'citys.id', 'garden.garCity_id')
      ->join('locations', 'locations.id', 'garden.garLocation_id')
      ->join('districts', 'districts.id', 'garden.garDistrict_id')
      ->first();

    $code = $administrative[0]['acf_cirNumber'];
    $date = Carbon::createFromDate($administrative[0]['acf_cirDate'])->locale('es')->timezone('America/Bogota')->isoFormat('LL');
    $to = $administrative[0]['acf_cirTo'];
    $message = $administrative[0]['acf_cirBody'];
    $from = Collaborator::findOrFail($administrative[0]['acf_cirFrom']);

    $pdfAdministrative = App::make('dompdf.wrapper');
    $namefile = 'CIRCULAR_ADMINISTRATIVA.pdf';
    $pdfAdministrative->loadView('modules.letters.circularAdministrativePdf', compact("code", "date", "to", "message", "from", "garden"));
    $pdfOutputAdministrative = $pdfAdministrative->output();

    $code = $academic[0]['acf_cirNumber'];
    $date = Carbon::createFromDate($academic[0]['acf_cirDate'])->locale('es')->timezone('America/Bogota')->isoFormat('LL');
    $to = $academic[0]['acf_cirTo'];
    $message = $academic[0]['acf_cirBody'];
    $from = Collaborator::findOrFail($academic[0]['acf_cirFrom']);

    $pdfAcademic = App::make('dompdf.wrapper');
    $nameFiles = 'CIRCULAR_ACADEMICA.pdf';
    $pdfAcademic->loadView('modules.letters.circularAcademicPdf', compact("code", "date", "to", "message", "from", "garden"));
    $pdfOutputAcademic = $pdfAcademic->output();

    $NamesArray = json_encode($NamesFiles);
    array_push($NameFiles, $nameFiles);
    array_push($NameFiles, $namefile);
    $NameArray = json_encode($NameFiles);

    InfoDaily::create([
      "id_fulldate" => $fulldate,
      "id_hi" => $hi->sch_body,
      "id_cont" => $cont,
      "id_NamesFiles" => $NamesArray,
      "id_NamesSin" => $NameArray
    ]);

    Mail::to($Emails)->send(new MessageInfoDaily($pdfOutputAcademic, $nameFiles, $pdfOutputAdministrative, $namefile, $files, $hi, $cont, $NameFiles));

    return back()->with("SuccessMail", "SuccessMail");
  }

  public function emailers(Request $request)
  {
    $emails = [];
    $documents = $request->data;
    foreach ($documents as $value) {
      $email = Formadmission::where("numerodocumento", $value)->get();
      array_push($emails, $email);
    }
    return $emails;
  }

  // vista del archivo de agenda
  public function scheduleFileTo()
  {
    $archive = InfoDaily::all();
    return view('modules.schedules.file', compact("archive"));
  }
  public function dailyInformationToDelete(Request $request)
  {
    $deleted = InfoDaily::findOrFail($request->DelID)->delete();
    DB::statement("alter table info_dailies auto_increment=1");
    if (!$deleted) {
      return "deleled";
    }
    return "not deleted";
  }
}
