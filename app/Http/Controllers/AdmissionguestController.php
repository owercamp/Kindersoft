<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\City;
use App\Models\Health;
use App\Models\Location;
use App\Models\Bloodtype;
use App\Models\Document;
use App\Models\Formadmission;
use App\Models\DocumentEnroll;

class AdmissionguestController extends Controller
{
  public function __construct()
  {
    // $this->middleware('guest');
  }

  function registerTo()
  {
    $citys = City::all();
    $healths = Health::all();
    $locations = Location::all();
    $bloodtypes = Bloodtype::all();
    $typeDocuments = Document::all();
    return view('modules.admissionModule.guest.form', compact('healths', 'citys', 'locations', 'bloodtypes', 'typeDocuments'));
  }

  function saveAdmission(Request $request)
  {
    /******
     * 
     * TRATAMIENTO DE INFORMACION INGRESA EN EL FORMULARIO, REEMPLAZANDO COMAS POR PUNTOS
     * 
     */
    
    $direccionAcudiente1 = str_replace(',','.',$request->addressattendant1);
    $direccionAcudiente2 = str_replace(',','.',$request->addressattendant2);
    $formacionAcudiente1 = str_replace(',','.',$request->typeprofessionattendant1);
    $formacionAcudiente2 = str_replace(',','.',$request->typeprofessionattendant2);
    $nombreEmpresaAcudiente1 = str_replace(',','.',$request->bussinessattendant1);
    $nombreEmpresaAcudiente2 = str_replace(',','.',$request->bussinessattendant2);
    $direccionEmpresaAcudiente1 = str_replace(',','.',$request->addressbussinessattendant1);
    $direccionEmpresaAcudiente2 = str_replace(',','.',$request->addressbussinessattendant2);

    /******
     * 
     * VALIDACION REGISTRO EXISTENTE PARA ACTUALIZAR O CREAR UNO NUEVO
     * 
     */

    $validateform = Formadmission::where('numerodocumento', trim($request->numberdocument))->first();
    if ($validateform == null) {
      $namephoto = "photodefault.png";
      if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        // $name = $rut->getClientOriginalName();
        $extension = $photo->extension();
        Storage::disk('kindersoft')->putFileAs('admisiones/fotosaspirantes/', $photo, trim($request->numberdocument) . '_photo.' . $extension);
        $namephoto = trim($request->numberdocument) . '_photo.' . $extension;
      }
      $datefechanacimiento = Date('Y-m-d', strtotime(
        trim($request->year) . '-' . trim($request->month) . '-' . trim($request->day)
      ));
      $datefechaingreso = Date('Y-m-d', strtotime(
        trim($request->yearentry) . '-' . trim($request->monthentry) . '-' . trim($request->dayentry)
      ));
      $datefechaingresoaudiente1 = Date('Y-m-d', strtotime(trim($request->dateentryattendant1)));
      $datefechaingresoaudiente2 = Date('Y-m-d', strtotime(trim($request->dateentryattendant2)));
      $newAdmission = Formadmission::create([
        'foto' => $namephoto,
        'nombres' => $this->upper($request->firstname),
        'apellidos' => $this->upper($request->lastname),
        'genero' => $this->upper($request->gender),
        'fechanacimiento' => $datefechanacimiento,
        'tipodocumento' => trim($request->typedocument),
        'numerodocumento' => trim($request->numberdocument),
        'nacionalidad' => $this->upper($request->nationality),
        'mesesgestacion' => trim($request->monthbord),
        'tiposangre' => trim($request->bloodtype),
        'tipoparto' => trim($request->typebord),
        'enfermedades' => $this->fu($request->healthbad),
        'tratamientos' => $this->fu($request->medical),
        'alergias' => $this->fu($request->descripcionalergias),
        'asistenciaterapias' => trim($request->terapia),
        'cual' => $this->fu($request->whatterapia),
        'health' => trim($request->health),
        'programa' => trim($request->typeprogram),
        'numerohermanos' => trim($request->brothers),
        'lugarqueocupa' => trim($request->placebrother),
        'conquienvive' => $this->upper($request->withlive),
        'otroscuidados' => $this->fu($request->other),
        'nombreacudiente1' => $this->ucwords($request->nameattendant1),
        'documentoacudiente1' => trim($request->documentattendant1),
        'docacu1' => trim($request->typedocumentattendant1),
        'direccionacudiente1' => trim($direccionAcudiente1),
        'barrioacudiente1' => trim($request->barrioattendant1),
        'localidadacudiente1' => trim($request->localidadattendant1),
        'celularacudiente1' => trim($request->celularattendant1),
        'whatsappacudiente1' => trim($request->whatsappattendant1),
        'correoacudiente1' => $this->lower($request->emailattendant1),
        'formacionacudiente1' => trim($formacionAcudiente1),
        'tituloacudiente1' => $this->upper($request->tituloattendant1),
        'tipoocupacionacudiente1' => trim($request->typeworkattendant1),
        'empresaacudiente1' => $this->upper($nombreEmpresaAcudiente1),
        'direccionempresaacudiente1' => $this->upper($direccionEmpresaAcudiente1),
        'ciudadempresaacudiente1' => trim($request->citybussinessattendant1),
        'barrioempresaacudiente1' => trim($request->barrioempresaattendant1),
        'localidadempresaacudiente1' => trim($request->localidadempresaattendant1),
        'cargoempresaacudiente1' => $this->upper($request->positionattendant1),
        'fechaingresoempresaacudiente1' => $datefechaingresoaudiente1,
        'rhacu1' => trim($request->bloodtypeattendant1),
        'sexoacudiente1' => trim($request->sexattendant1),
        'nombreacudiente2' => $this->ucwords($request->nameattendant2),
        'documentoacudiente2' => trim($request->documentattendant2),
        'docacu2' => trim($request->typedocumentattendant2),
        'direccionacudiente2' => trim($direccionAcudiente2),
        'barrioacudiente2' => trim($request->barrioattendant2),
        'localidadacudiente2' => trim($request->localidadattendant2),
        'celularacudiente2' => trim($request->celularattendant2),
        'whatsappacudiente2' => trim($request->whatsappattendant2),
        'correoacudiente2' => $this->lower($request->emailattendant2),
        'formacionacudiente2' => trim($formacionAcudiente2),
        'tituloacudiente2' => $this->upper($request->tituloattendant2),
        'tipoocupacionacudiente2' => trim($request->typeworkattendant2),
        'empresaacudiente2' => $this->upper($nombreEmpresaAcudiente2),
        'direccionempresaacudiente2' => $this->upper($direccionEmpresaAcudiente2),
        'ciudadempresaacudiente2' => trim($request->citybussinessattendant2),
        'barrioempresaacudiente2' => trim($request->barrioempresaattendant2),
        'localidadempresaacudiente2' => trim($request->localidadempresaattendant2),
        'cargoempresaacudiente2' => $this->upper($request->positionattendant2),
        'fechaingresoempresaacudiente2' => $datefechaingresoaudiente2,
        'rhacu2' => trim($request->bloodtypeattendant2),
        'sexoacudiente2' => trim($request->sexattendant2),
        'nombreemergencia' => $this->ucwords($request->nameemergency),
        'documentoemergencia' => trim($request->documentemergency),
        'direccionemergencia' => $this->upper($request->addressemergency),
        'barrioemergencia' => trim($request->barrioemergency),
        'localidademergencia' => trim($request->localidademergency),
        'celularemergencia' => trim($request->celularemergency),
        'whatsappemergencia' => trim($request->whatsappemergency),
        'parentescoemergencia' => $this->fu($request->relationemergency),
        'correoemergencia' => $this->lower($request->emailemergency),
        'nombreautorizado1' => $this->ucwords($request->nameautorized1),
        'documentoautorizado1' => trim($request->documentautorized1),
        'parentescoautorizado1' => trim($request->relationautorized1),
        'nombreautorizado2' => $this->ucwords($request->nameautorized2),
        'documentoautorizado2' => trim($request->documentautorized2),
        'parentescoautorizado2' => trim($request->relationautorized2),
        'fechaingreso' => $datefechaingreso,
        'expectatives_likechild' => $this->fu($request->expectatives_likechild),
        'expectatives_activityschild' => $this->fu($request->expectatives_activityschild),
        'expectatives_toychild' => $this->fu($request->expectatives_toychild),
        'expectatives_aspectchild' => $this->fu($request->expectatives_aspectchild),
        'expectatives_dreamforchild' => $this->fu($request->expectatives_dreamforchild),
        'expectatives_learnchild' => $this->fu($request->expectatives_learnchild),
        'cultural_eventfamily' => $this->fu($request->cultural_eventfamily),
        'cultural_supportculturefamily' => $this->fu($request->cultural_supportculturefamily),
        'cultural_gardenlearnculture' => $this->fu($request->cultural_gardenlearnculture),
        'cultural_shareculturefamily' => $this->fu($request->cultural_shareculturefamily)
      ]);
      return redirect()->route('registerGuest')->with('SuccessAdmission', 'Se ha registrado el formulario para el niño/niña (' . $newAdmission->nombres . ' '  . $newAdmission->apellidos . ') con número de documento (' . $newAdmission->numerodocumento . '), CORRECTAMENTE!!');
    } else {
      $search = Formadmission::find($validateform->fmId);
      // $namephoto = "photodefault.png";
      if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        // $name = $rut->getClientOriginalName();
        $extension = $photo->extension();
        Storage::disk('kindersoft')->putFileAs('admisiones/fotosaspirantes/', $photo, trim($request->numberdocument) . '_photo.' . $extension);
        $namephoto = trim($request->numberdocument) . '_photo.' . $extension;
      }
      $datefechanacimiento = Date('Y-m-d', strtotime(
        trim($request->year) . '-' . trim($request->month) . '-' . trim($request->day)
      ));
      $datefechaingreso = Date('Y-m-d', strtotime(
        trim($request->yearentry) . '-' . trim($request->monthentry) . '-' . trim($request->dayentry)
      ));
      $datefechaingresoaudiente1 = Date('Y-m-d', strtotime(trim($request->dateentryattendant1)));
      $datefechaingresoaudiente2 = Date('Y-m-d', strtotime(trim($request->dateentryattendant2)));

      $search->foto = $namephoto;
      $search->nombres = $this->upper($request->firstname);
      $search->apellidos = $this->upper($request->lastname);
      $search->genero = $this->upper($request->gender);
      $search->fechanacimiento = $datefechanacimiento;
      $search->tipodocumento = trim($request->typedocument);
      $search->numerodocumento = trim($request->numberdocument);
      $search->nacionalidad = $this->upper($request->nationality);
      $search->mesesgestacion = trim($request->monthbord);
      $search->tiposangre = trim($request->bloodtype);
      $search->tipoparto = trim($request->typebord);
      $search->enfermedades = $this->fu($request->healthbad);
      $search->tratamientos = $this->fu($request->medical);
      $search->alergias = $this->fu($request->descripcionalergias);
      $search->asistenciaterapias = trim($request->terapia);
      $search->cual = $this->fu($request->whatterapia);
      $search->health = trim($request->health);
      $search->programa = trim($request->typeprogram);
      $search->numerohermanos = trim($request->brothers);
      $search->lugarqueocupa = trim($request->placebrother);
      $search->lugarqueocupa = trim($request->placebrother);
      $search->conquienvive = $this->upper($request->withlive);
      $search->otroscuidados = $this->fu($request->other);
      $search->nombreacudiente1 = $this->ucwords($request->nameattendant1);
      $search->documentoacudiente1 = trim($request->documentattendant1);
      $search->docacu1 = trim($request->typedocumentattendant1);
      $search->direccionacudiente1 = trim($direccionAcudiente1);
      $search->barrioacudiente1 = trim($request->barrioattendant1);
      $search->localidadacudiente1 = trim($request->localidadattendant1);
      $search->celularacudiente1 = trim($request->celularattendant1);
      $search->celularacudiente1 = trim($request->celularattendant1);
      $search->whatsappacudiente1 = trim($request->whatsappattendant1);
      $search->correoacudiente1 = $this->lower($request->emailattendant1);
      $search->formacionacudiente1 = trim($formacionAcudiente1);
      $search->tituloacudiente1 = $this->upper($request->tituloattendant1);
      $search->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
      $search->empresaacudiente1 = $this->upper($nombreEmpresaAcudiente1);
      $search->direccionempresaacudiente1 = $this->upper($direccionEmpresaAcudiente1);
      $search->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
      $search->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
      $search->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
      $search->cargoempresaacudiente1 = $this->upper($request->positionattendant1);
      $search->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
      $search->rhacu1 = trim($request->bloodtypeattendant1);
      $search->sexoacudiente1 = trim($request->sexattendant1);
      $search->nombreacudiente2 = $this->ucwords($request->nameattendant2);
      $search->documentoacudiente2 = trim($request->documentattendant2);
      $search->docacu2 = trim($request->typedocumentattendant2);
      $search->direccionacudiente2 = trim($direccionAcudiente2);
      $search->barrioacudiente2 = trim($request->barrioattendant2);
      $search->barrioacudiente2 = trim($request->barrioattendant2);
      $search->localidadacudiente2 = trim($request->localidadattendant2);
      $search->celularacudiente2 = trim($request->celularattendant2);
      $search->whatsappacudiente2 = trim($request->whatsappattendant2);
      $search->correoacudiente2 = $this->lower($request->emailattendant2);
      $search->formacionacudiente2 = trim($formacionAcudiente2);
      $search->tituloacudiente2 = $this->upper($request->tituloattendant2);
      $search->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
      $search->empresaacudiente2 = $this->upper($nombreEmpresaAcudiente2);
      $search->direccionempresaacudiente2 = $this->upper($direccionEmpresaAcudiente2);
      $search->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
      $search->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
      $search->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
      $search->cargoempresaacudiente2 = $this->upper($request->positionattendant2);
      $search->fechaingresoempresaacudiente2 = $datefechaingresoaudiente2;
      $search->rhacu2 = trim($request->bloodtypeattendant2);
      $search->sexoacudiente2 = trim($request->sexattendant2);
      $search->nombreemergencia = $this->ucwords($request->nameemergency);
      $search->documentoemergencia = trim($request->documentemergency);
      $search->direccionemergencia = $this->upper($request->addressemergency);
      $search->barrioemergencia = trim($request->barrioemergency);
      $search->localidademergencia = trim($request->localidademergency);
      $search->celularemergencia = trim($request->celularemergency);
      $search->whatsappemergencia = trim($request->whatsappemergency);
      $search->parentescoemergencia = $this->fu($request->relationemergency);
      $search->correoemergencia = $this->lower($request->emailemergency);
      $search->nombreautorizado1 = $this->ucwords($request->nameautorized1);
      $search->documentoautorizado1 = trim($request->documentautorized1);
      $search->parentescoautorizado1 = trim($request->relationautorized1);
      $search->nombreautorizado2 = $this->ucwords($request->nameautorized2);
      $search->documentoautorizado2 = trim($request->documentautorized2);
      $search->parentescoautorizado2 = trim($request->relationautorized2);
      $search->fechaingreso = $datefechaingreso;
      $search->expectatives_likechild = $this->fu($request->expectatives_likechild);
      $search->expectatives_activityschild = $this->fu($request->expectatives_activityschild);
      $search->expectatives_toychild = $this->fu($request->expectatives_toychild);
      $search->expectatives_aspectchild = $this->fu($request->expectatives_aspectchild);
      $search->expectatives_dreamforchild = $this->fu($request->expectatives_dreamforchild);
      $search->expectatives_learnchild = $this->fu($request->expectatives_learnchild);
      $search->cultural_eventfamily = $this->fu($request->cultural_eventfamily);
      $search->cultural_supportculturefamily = $this->fu($request->cultural_supportculturefamily);
      $search->cultural_gardenlearnculture = $this->fu($request->cultural_gardenlearnculture);
      $search->cultural_shareculturefamily = $this->fu($request->cultural_shareculturefamily);
      $search->status = "PENDIENTE";
      $search->migracion = 0;
      $search->save();
      return redirect()->route('registerGuest')->with('SecondaryAdmission', 'Se ha registrado el formulario para el niño/niña (' . $search->nombres . ' '  . $search->apellidos . ') con número de documento (' . $search->numerodocumento . '), CORRECTAMENTE!!');
    }
  }


  function listDocumentsPdf(Request $request)
  {
    // dd($request->all());
    $documents = DocumentEnroll::where('deStatus', 'ACTIVO')->orderBy('dePosition')->get();
    $namefile = 'LISTADO_DE_DOCUMENTOS_REQUERIDOS_PARA_MATRICULA.pdf';
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadView('modules.admissionModule.guest.listDocumentsPdf', compact('documents'));
    return $pdf->download($namefile);
  }

  /* ===========================================================================================================
						FUNCIONES PARA CONVERTIR CADENAS DE TEXTO (Mayusculas/Minusculas/Solo primera en Mayuscula)
		=========================================================================================================== */

  function upper($string)
  {
    return mb_strtoupper(trim($string), 'UTF-8');
  }

  function lower($string)
  {
    return mb_strtolower(trim($string), 'UTF-8');
  }

  function fu($string)
  {
    return ucfirst(mb_strtolower(trim($string), 'UTF-8'));
  }

  function ucwords($string)
  {
    return ucwords(mb_strtolower(trim($string), 'UTF-8'));
  }
}
