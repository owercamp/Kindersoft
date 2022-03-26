<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    $myExpresions = array(",", ".");

    $direccionAcudiente1 = str_replace($myExpresions, "", $request->addressattendant1);
    $direccionAcudiente2 = str_replace($myExpresions, "", $request->addressattendant2);
    $formacionAcudiente1 = str_replace($myExpresions, "", $request->typeprofessionattendant1);
    $formacionAcudiente2 = str_replace($myExpresions, "", $request->typeprofessionattendant2);
    $nombreEmpresaAcudiente1 = str_replace($myExpresions, "", $request->bussinessattendant1);
    $nombreEmpresaAcudiente2 = str_replace($myExpresions, "", $request->bussinessattendant2);
    $direccionEmpresaAcudiente1 = str_replace($myExpresions, "", $request->addressbussinessattendant1);
    $direccionEmpresaAcudiente2 = str_replace($myExpresions, "", $request->addressbussinessattendant2);
    $nombreAlumno = str_replace($myExpresions,"",$request->firstname);
    $apellidoAlumno = str_replace($myExpresions,"",$request->lastname);
    $nacionalidad = str_replace($myExpresions,"",$request->nationality);
    $tituloAcudiente1 = str_replace($myExpresions,"",$request->tituloattendant1);
    $tituloAcudiente2 = str_replace($myExpresions,"",$request->tituloattendant2);
    $cargoAcudiente1 = str_replace($myExpresions,"",$request->positionattendant1);
    $cargoAcudiente2 = str_replace($myExpresions,"",$request->positionattendant2);

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
      
      $formAdmission = new Formadmission;
      $formAdmission->foto = $namephoto;
      $formAdmission->nombres = $this->upper($nombreAlumno);
      $formAdmission->apellidos = $this->upper($apellidoAlumno);
      $formAdmission->genero = $this->upper($request->gender);
      $formAdmission->fechanacimiento = $datefechanacimiento;
      $formAdmission->tipodocumento = trim($request->typedocument);
      $formAdmission->numerodocumento = trim($request->numberdocument);
      $formAdmission->nacionalidad = $this->upper($nacionalidad);
      $formAdmission->mesesgestacion = trim($request->monthbord);
      $formAdmission->tiposangre = trim($request->bloodtype);
      $formAdmission->tipoparto = trim($request->typebord);
      $formAdmission->enfermedades = $this->fu($request->healthbad);
      $formAdmission->tratamientos = $this->fu($request->medical);
      $formAdmission->alergias = $this->fu($request->descripcionalergias);
      $formAdmission->asistenciaterapias = trim($request->terapia);
      $formAdmission->cual = $this->fu($request->whatterapia);
      $formAdmission->health = trim($request->health);
      $formAdmission->programa = trim($request->typeprogram);
      $formAdmission->numerohermanos = trim($request->brothers);
      $formAdmission->lugarqueocupa = trim($request->placebrother);
      $formAdmission->lugarqueocupa = trim($request->placebrother);
      $formAdmission->conquienvive = $this->upper($request->withlive);
      $formAdmission->otroscuidados = $this->fu($request->other);
      $formAdmission->nombreacudiente1 = $this->ucwords($request->nameattendant1);
      $formAdmission->documentoacudiente1 = trim($request->documentattendant1);
      $formAdmission->docacu1 = trim($request->typedocumentattendant1);
      $formAdmission->direccionacudiente1 = trim($direccionAcudiente1);
      $formAdmission->barrioacudiente1 = trim($request->barrioattendant1);
      $formAdmission->localidadacudiente1 = trim($request->localidadattendant1);
      $formAdmission->celularacudiente1 = trim($request->celularattendant1);
      $formAdmission->celularacudiente1 = trim($request->celularattendant1);
      $formAdmission->whatsappacudiente1 = trim($request->whatsappattendant1);
      $formAdmission->correoacudiente1 = $this->lower($request->emailattendant1);
      $formAdmission->formacionacudiente1 = trim($formacionAcudiente1);
      $formAdmission->tituloacudiente1 = $this->upper($tituloAcudiente1);
      $formAdmission->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
      $formAdmission->empresaacudiente1 = $this->upper($nombreEmpresaAcudiente1);
      $formAdmission->direccionempresaacudiente1 = $this->upper($direccionEmpresaAcudiente1);
      $formAdmission->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
      $formAdmission->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
      $formAdmission->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
      $formAdmission->cargoempresaacudiente1 = $this->upper($cargoAcudiente1);
      $formAdmission->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
      $formAdmission->rhacu1 = trim($request->bloodtypeattendant1);
      $formAdmission->sexoacudiente1 = trim($request->sexattendant1);
      $formAdmission->nombreacudiente2 = $this->ucwords($request->nameattendant2);
      $formAdmission->documentoacudiente2 = trim($request->documentattendant2);
      $formAdmission->docacu2 = trim($request->typedocumentattendant2);
      $formAdmission->direccionacudiente2 = trim($direccionAcudiente2);
      $formAdmission->barrioacudiente2 = trim($request->barrioattendant2);
      $formAdmission->localidadacudiente2 = trim($request->localidadattendant2);
      $formAdmission->celularacudiente2 = trim($request->celularattendant2);
      $formAdmission->whatsappacudiente2 = trim($request->whatsappattendant2);
      $formAdmission->correoacudiente2 = $this->lower($request->emailattendant2);
      $formAdmission->formacionacudiente2 = trim($formacionAcudiente2);
      $formAdmission->tituloacudiente2 = $this->upper($tituloAcudiente2);
      $formAdmission->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
      $formAdmission->empresaacudiente2 = $this->upper($nombreEmpresaAcudiente2);
      $formAdmission->direccionempresaacudiente2 = $this->upper($direccionEmpresaAcudiente2);
      $formAdmission->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
      $formAdmission->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
      $formAdmission->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
      $formAdmission->cargoempresaacudiente2 = $this->upper($cargoAcudiente2);
      $formAdmission->fechaingresoempresaacudiente2 = $datefechaingresoaudiente2;
      $formAdmission->rhacu2 = trim($request->bloodtypeattendant2);
      $formAdmission->sexoacudiente2 = trim($request->sexattendant2);
      $formAdmission->nombreemergencia = $this->ucwords($request->nameemergency);
      $formAdmission->documentoemergencia = trim($request->documentemergency);
      $formAdmission->direccionemergencia = $this->upper($request->addressemergency);
      $formAdmission->barrioemergencia = trim($request->barrioemergency);
      $formAdmission->localidademergencia = trim($request->localidademergency);
      $formAdmission->celularemergencia = trim($request->celularemergency);
      $formAdmission->whatsappemergencia = trim($request->whatsappemergency);
      $formAdmission->parentescoemergencia = $this->fu($request->relationemergency);
      $formAdmission->correoemergencia = $this->lower($request->emailemergency);
      $formAdmission->nombreautorizado1 = $this->ucwords($request->nameautorized1);
      $formAdmission->documentoautorizado1 = trim($request->documentautorized1);
      $formAdmission->parentescoautorizado1 = trim($request->relationautorized1);
      $formAdmission->nombreautorizado2 = $this->ucwords($request->nameautorized2);
      $formAdmission->documentoautorizado2 = trim($request->documentautorized2);
      $formAdmission->parentescoautorizado2 = trim($request->relationautorized2);
      $formAdmission->fechaingreso = $datefechaingreso;
      $formAdmission->expectatives_likechild = $this->fu($request->expectatives_likechild);
      $formAdmission->expectatives_activityschild = $this->fu($request->expectatives_activityschild);
      $formAdmission->expectatives_toychild = $this->fu($request->expectatives_toychild);
      $formAdmission->expectatives_aspectchild = $this->fu($request->expectatives_aspectchild);
      $formAdmission->expectatives_dreamforchild = $this->fu($request->expectatives_dreamforchild);
      $formAdmission->expectatives_learnchild = $this->fu($request->expectatives_learnchild);
      $formAdmission->cultural_eventfamily = $this->fu($request->cultural_eventfamily);
      $formAdmission->cultural_supportculturefamily = $this->fu($request->cultural_supportculturefamily);
      $formAdmission->cultural_gardenlearnculture = $this->fu($request->cultural_gardenlearnculture);
      $formAdmission->cultural_shareculturefamily = $this->fu($request->cultural_shareculturefamily);
      $formAdmission->save();
      return redirect()->route('registerGuest')->with('SuccessAdmission', 'Se ha registrado el formulario para el niño/niña (' . $formAdmission->nombres . ' '  . $formAdmission->apellidos . ') con número de documento (' . $formAdmission->numerodocumento . '), CORRECTAMENTE!!');
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
      $search->nombres = $this->upper($nombreAlumno);
      $search->apellidos = $this->upper($apellidoAlumno);
      $search->genero = $this->upper($request->gender);
      $search->fechanacimiento = $datefechanacimiento;
      $search->tipodocumento = trim($request->typedocument);
      $search->numerodocumento = trim($request->numberdocument);
      $search->nacionalidad = $this->upper($nacionalidad);
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
      $search->tituloacudiente1 = $this->upper($tituloAcudiente1);
      $search->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
      $search->empresaacudiente1 = $this->upper($nombreEmpresaAcudiente1);
      $search->direccionempresaacudiente1 = $this->upper($direccionEmpresaAcudiente1);
      $search->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
      $search->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
      $search->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
      $search->cargoempresaacudiente1 = $this->upper($cargoAcudiente1);
      $search->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
      $search->rhacu1 = trim($request->bloodtypeattendant1);
      $search->sexoacudiente1 = trim($request->sexattendant1);
      $search->nombreacudiente2 = $this->ucwords($request->nameattendant2);
      $search->documentoacudiente2 = trim($request->documentattendant2);
      $search->docacu2 = trim($request->typedocumentattendant2);
      $search->direccionacudiente2 = trim($direccionAcudiente2);
      $search->barrioacudiente2 = trim($request->barrioattendant2);
      $search->localidadacudiente2 = trim($request->localidadattendant2);
      $search->celularacudiente2 = trim($request->celularattendant2);
      $search->whatsappacudiente2 = trim($request->whatsappattendant2);
      $search->correoacudiente2 = $this->lower($request->emailattendant2);
      $search->formacionacudiente2 = trim($formacionAcudiente2);
      $search->tituloacudiente2 = $this->upper($tituloAcudiente2);
      $search->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
      $search->empresaacudiente2 = $this->upper($nombreEmpresaAcudiente2);
      $search->direccionempresaacudiente2 = $this->upper($direccionEmpresaAcudiente2);
      $search->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
      $search->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
      $search->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
      $search->cargoempresaacudiente2 = $this->upper($cargoAcudiente2);
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
