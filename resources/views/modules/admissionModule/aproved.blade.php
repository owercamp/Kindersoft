@extends('admissions')

@section('modulesAdmission')
<div class="row">
  <div class="col-md-12">
    <div class="row text-center border-bottom mb-4" style="font-size: 13px;">
      <div class="col-md-12">
        <!-- Mensajes de modificación de formularios -->
        @if(session('PrimaryForm'))
        <div class="alert alert-primary">
          {{ session('PrimaryForm') }}
        </div>
        @endif
        <!-- Mensajes de eliminación de formularios -->
        @if(session('WarningForm'))
        <div class="alert alert-warning">
          {{ session('WarningForm') }}
        </div>
        @endif
        <!-- Mensajes de errores de procesamiento de formularios -->
        @if(session('SecondaryForm'))
        <div class="alert alert-secondary">
          {{ session('SecondaryForm') }}
        </div>
        @endif
      </div>
    </div>
    <table id="tableDatatable" class="table table-hover text-center" width="100%">
      <thead>
        <tr>
          <th>NIÑO/NIÑA</th>
          <th>DOCUMENTO</th>
          <th>MESES DE GESTACION</th>
          <th>ACUDIENTE 1</th>
          <th>CONTACTO 1</th>
          <th>ACUDIENTE 2</th>
          <th>CONTACTO 2</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($forms as $form)
        <tr>
          <td>{{ $form->nombres . ' ' . $form->apellidos }}</td>
          <td>{{ $form->numerodocumento }}</td>
          <td>{{ $form->mesesgestacion }}</td>
          <td>{{ $form->nombreacudiente1 }}</td>
          <td>{{ $form->celularacudiente1 }}</td>
          <td>{{ $form->nombreacudiente2 }}</td>
          <td>{{ $form->celularacudiente2 }}</td>
          <td>
            <form action="{{ route('saveaprovedAdmission') }}" method="POST" style="display: inline-block;">
              @csrf
              <input type="hidden" name="fmId" value="{{ $form->fmId }}" class="form-control form-control-sm" required>
              <button type="submit" title="APROBAR FORMULARIO" class="btn btn-outline-success rounded-circle form-control-sm">
                <i class="fas fa-plus"></i>
              </button>
            </form>
            <a href="#" title="EDITAR FORMULARIO" class="btn btn-outline-primary rounded-circle form-control-sm editForm-link">
              <i class="fas fa-edit"></i>
              <!-- updateAdmission -->
              <span hidden>{{ $form->fmId }}</span>
              <span hidden>{{ $form->nombres }}</span>
              <span hidden>{{ $form->apellidos }}</span>
              <span hidden>{{ $form->genero }}</span>
              <span hidden>{{ $form->fechanacimiento }}</span>
              <span hidden>{{ $form->tipodocumento }}</span>
              <span hidden>{{ $form->numerodocumento }}</span>
              <span hidden>{{ $form->nacionalidad }}</span>
              <span hidden>{{ $form->mesesgestacion }}</span>
              <span hidden>{{ $form->tiposangre }}</span>
              <span hidden>{{ $form->tipoparto }}</span>
              <span hidden>{{ $form->enfermedades }}</span>
              <span hidden>{{ $form->tratamientos }}</span>
              <span hidden>{{ $form->alergias }}</span>
              <span hidden>{{ $form->asistenciaterapias }}</span>
              <span hidden>{{ $form->cual }}</span>
              <span hidden>{{ $form->health }}</span>
              <span hidden>{{ $form->programa }}</span>
              <span hidden>{{ $form->numerohermanos }}</span>
              <span hidden>{{ $form->lugarqueocupa }}</span>
              <span hidden>{{ $form->conquienvive }}</span>
              <span hidden>{{ $form->otroscuidados }}</span>
              <span hidden>{{ $form->nombreacudiente1 }}</span>
              <span hidden>{{ $form->documentoacudiente1 }}</span>
              <span hidden>{{ $form->direccionacudiente1 }}</span>
              <span hidden>{{ $form->barrioacudiente1 }}</span>
              <span hidden>{{ $form->localidadacudiente1 }}</span>
              <span hidden>{{ $form->celularacudiente1 }}</span>
              <span hidden>{{ $form->whatsappacudiente1 }}</span>
              <span hidden>{{ $form->correoacudiente1 }}</span>
              <span hidden>{{ $form->formacionacudiente1 }}</span>
              <span hidden>{{ $form->tituloacudiente1 }}</span>
              <span hidden>{{ $form->tipoocupacionacudiente1 }}</span>
              <span hidden>{{ $form->empresaacudiente1 }}</span>
              <span hidden>{{ $form->direccionempresaacudiente1 }}</span>
              <span hidden>{{ $form->ciudadempresaacudiente1 }}</span>
              <span hidden>{{ $form->barrioempresaacudiente1 }}</span>
              <span hidden>{{ $form->localidadempresaacudiente1 }}</span>
              <span hidden>{{ $form->cargoempresaacudiente1 }}</span>
              <span hidden>{{ $form->fechaingresoempresaacudiente1 }}</span>
              <span hidden>{{ $form->nombreacudiente2 }}</span>
              <span hidden>{{ $form->documentoacudiente2 }}</span>
              <span hidden>{{ $form->direccionacudiente2 }}</span>
              <span hidden>{{ $form->barrioacudiente2 }}</span>
              <span hidden>{{ $form->localidadacudiente2 }}</span>
              <span hidden>{{ $form->celularacudiente2 }}</span>
              <span hidden>{{ $form->whatsappacudiente2 }}</span>
              <span hidden>{{ $form->correoacudiente2 }}</span>
              <span hidden>{{ $form->formacionacudiente2 }}</span>
              <span hidden>{{ $form->tituloacudiente2 }}</span>
              <span hidden>{{ $form->tipoocupacionacudiente2 }}</span>
              <span hidden>{{ $form->empresaacudiente2 }}</span>
              <span hidden>{{ $form->direccionempresaacudiente2 }}</span>
              <span hidden>{{ $form->ciudadempresaacudiente2 }}</span>
              <span hidden>{{ $form->barrioempresaacudiente2 }}</span>
              <span hidden>{{ $form->localidadempresaacudiente2 }}</span>
              <span hidden>{{ $form->cargoempresaacudiente2 }}</span>
              <span hidden>{{ $form->fechaingresoempresaacudiente2 }}</span>
              <span hidden>{{ $form->nombreemergencia }}</span>
              <span hidden>{{ $form->documentoemergencia }}</span>
              <span hidden>{{ $form->direccionemergencia }}</span>
              <span hidden>{{ $form->barrioemergencia }}</span>
              <span hidden>{{ $form->localidademergencia }}</span>
              <span hidden>{{ $form->celularemergencia }}</span>
              <span hidden>{{ $form->whatsappemergencia }}</span>
              <span hidden>{{ $form->parentescoemergencia }}</span>
              <span hidden>{{ $form->correoemergencia }}</span>
              <span hidden>{{ $form->nombreautorizado1 }}</span>
              <span hidden>{{ $form->documentoautorizado1 }}</span>
              <span hidden>{{ $form->parentescoautorizado1 }}</span>
              <span hidden>{{ $form->nombreautorizado2 }}</span>
              <span hidden>{{ $form->documentoautorizado2 }}</span>
              <span hidden>{{ $form->parentescoautorizado2 }}</span>
              <span hidden>{{ $form->fechaingreso }}</span>
              <span hidden>{{ $form->expectatives_likechild }}</span>
              <span hidden>{{ $form->expectatives_activityschild }}</span>
              <span hidden>{{ $form->expectatives_toychild }}</span>
              <span hidden>{{ $form->expectatives_aspectchild }}</span>
              <span hidden>{{ $form->expectatives_dreamforchild }}</span>
              <span hidden>{{ $form->expectatives_learnchild }}</span>
              <span hidden>{{ $form->cultural_eventfamily }}</span>
              <span hidden>{{ $form->cultural_supportculturefamily }}</span>
              <span hidden>{{ $form->cultural_gardenlearnculture }}</span>
              <span hidden>{{ $form->cultural_shareculturefamily }}</span>
              @php
              if($form->foto == "photodefault.png" and $form->genero == "MASCULINO"){
              $foto = "niñodefault.jpg";
              }elseif($form->foto == "photodefault.png" and $form->genero == "FEMENINO"){
              $foto = "niñadefault.jpg";
              }else{
              $foto = $form->foto;
              }
              @endphp
              <img hidden src="{{ asset('storage/admisiones/fotosaspirantes/'.$foto) }}">
            </a>
            <a href="#" title="ELIMINAR FORMULARIO" class="btn btn-outline-tertiary rounded-circle  form-control-sm deleteForm-link">
              <i class="fas fa-trash-alt"></i>
              <!-- updateAdmission -->
              <span hidden>{{ $form->fmId }}</span>
              <span hidden>{{ $form->nombres }}</span>
              <span hidden>{{ $form->apellidos }}</span>
              <span hidden>{{ $form->numerodocumento }}</span>
              <span hidden>{{ $form->fechanacimiento }}</span>
              @php
              if($form->foto == "photodefault.png" and $form->genero == "MASCULINO"){
              $foto = "niñodefault.jpg";
              }elseif($form->foto == "photodefault.png" and $form->genero == "FEMENINO"){
              $foto = "niñadefault.jpg";
              }else{
              $foto = $form->foto;
              }
              @endphp
              <img hidden src="{{ asset('storage/admisiones/fotosaspirantes/'.$foto) }}">
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="editForm-modal">
  <div class="modal-dialog modal-lg" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h6>MODIFICACION DE FORMULARIO</h6>
      </div>
      <div class="modal-body">
        <form action="{{ route('updateAdmission') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row p-2">
            <div class="col-md-12 text-center d-flex flex-column justify-content-center align-items-center">
              <div class="row sectionPhoto img-thumbnail">
                <div class="col-md-12 text-center border d-flex flex-column justify-content-center align-items-center img-thumbnail" style="width: 3cm; height: 4cm; overflow: hidden;">
                  <small class="text-muted text-center titlePhoto">Seleccione fotografía</small>
                  <img hidden src="" id="previewPhoto" style="width: 3cm; height: 4cm;">
                </div>
              </div>
              <div class="row p-1">
                <div class="col-md-12 text-center">
                  <span class="text-muted">
                    Quitar foto
                    <input type="checkbox" name="notphoto" class="form-control form-control-sm">
                  </span>
                </div>
              </div>
              <div class="row text-center">
                <input type="file" id="photoSelected" name="photo" lang="es" placeholder="Unicamente con extensión jpeg" accept="image/jpeg">
              </div>
            </div>
          </div>
          <hr>
          <!-- NIÑO/NIÑA Y INFORMACION DE SALUD -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>NIÑO/NIÑA</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Nombres:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="firstname" maxlength="40" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Apellidos:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="lastname" maxlength="40" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Género:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <select name="gender" class="form-control form-control-sm select2" required>
                        <option value="">Seleccione ...</option>
                        <option value="MASCULINO">Masculino</option>
                        <option value="FEMENINO">Femenino</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <small>FECHA DE NACIMIENTO</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Dia:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <input type="text" name="day" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Mes:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <input type="text" name="month" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Año:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <input type="text" name="year" maxlength="4" class="form-control form-control-sm text-center" pattern="[0-9]{1,4}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Registro civil:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typedocument" value="REGISTRO CIVIL" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Pasaporte:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typedocument" value="PASAPORTE" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="numberdocument" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Nacionalidad:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="nationality" maxlength="40" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION DE SALUD</small>
                  </div>
                  <div class="form-group row p-1 m-0">
                    <small class="col-sm-4 p-1 m-0 text-muted">Meses de gestación:</small>
                    <div class="col-sm-2 p-1 m-0">
                      <input type="text" name="monthbord" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                    </div>
                    <small class="col-sm-3 p-1 m-0 text-muted">Tipo de sangre:</small>
                    <div class="col-sm-3 p-1 m-0">
                      <select class="form-control form-control-sm select2" name="bloodtype" required>
                        <option value="">Seleccione ...</option>
                        @foreach($bloodtypes as $bloodtype)
                        <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row p-1 m-0">
                    <small class="col-sm-4 p-1 m-0 text-muted">Tipo de Parto:</small>
                    <small class="col-sm-2 p-1 m-0 text-muted">Natural:</small>
                    <div class="col-sm-2 p-1 m-0">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typebord" class="" value="Natural" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-2 p-1 m-0 text-muted">Cesárea:</small>
                    <div class="col-sm-2 p-1 m-0">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typebord" class="" value="Cesárea" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-5 m-0 p-1 text-muted">Enfermedades actuales:</small>
                    <div class="col-sm-7 m-0 p-1">
                      <input type="text" name="healthbad" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-5 m-0 p-1 text-muted">Tratamientos médicos:</small>
                    <div class="col-sm-7 m-0 p-1">
                      <input type="text" name="medical" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-5 m-0 p-1 text-muted">Descripción de alergias:</small>
                    <div class="col-sm-7 m-0 p-1">
                      <input type="text" name="descripcionalergias" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-6 m-0 p-1 text-muted">Asiste o asistió a alguna terápia:</small>
                    <div class="col-sm-6 m-0 p-1">
                      <select name="terapia" class="form-control form-control-sm select2" required>
                        <option value="">Seleccione ...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Cuál?</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="whatterapia" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Afiliación salud:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <select name="health" class="form-control form-control-sm select2" required>
                        <option value="">Seleccione ...</option>
                        @foreach($healths as $h)
                        <option value="{{ $h->id }}">{{ $h->entity . ' - ' . $h->type }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- PROGRAMA A MATRICULAR Y CUIDADOS ESPECIALES -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>PROGRAMA A MATRICULAR</small>
                  </div>
                  <div class="form-group row m-0 p-0">
                    <ul class="col-sm-12 m-0 p-0 d-flex flex-column align-items-center m-0 p-1">
                      <li>
                        <small class="text-muted">JORNADA HASTA 12:30 PM</small>
                        <small class="text-muted">(</small>
                        <input type="radio" name="typeprogram" class="" value="JORNADA HASTA 12:30 PM" required>
                        <small class="text-muted">)</small>
                      </li>
                      <li>
                        <small class="text-muted">JORNADA HASTA 03:00 PM</small>
                        <small class="text-muted">(</small>
                        <input type="radio" name="typeprogram" class="" value="JORNADA HASTA 03:00 PM" required>
                        <small class="text-muted">)</small>
                      </li>
                      <li>
                        <small class="text-muted">JORNADA HASTA 05:00 PM</small>
                        <small class="text-muted">(</small>
                        <input type="radio" name="typeprogram" class="" value="JORNADA HASTA 05:00 PM" required>
                        <small class="text-muted">)</small>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>CUIDADOS ESPECIALES</small>
                  </div>
                  <div class="form-group row p-1 m-0">
                    <small class="col-sm-4 p-1 m-0 text-muted">Numero de hermanos:</small>
                    <div class="col-sm-2 p-1 m-0">
                      <input type="text" name="brothers" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                    </div>
                    <small class="col-sm-3 p-1 m-0 text-muted">Lugar que ocupa:</small>
                    <div class="col-sm-3 p-1 m-0">
                      <input type="text" name="placebrother" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                    </div>
                  </div>
                  <div class="form-group row p-1 m-0">
                    <small class="col-sm-4 p-1 m-0 text-muted">Con quien vive el niño:</small>
                    <div class="col-sm-8 p-1 m-0">
                      <input type="text" name="withlive" maxlength="40" class="form-control form-control-sm text-center" required>
                    </div>
                  </div>
                  <small class="m-0 p-1 text-muted">Otros cuidados:</small>
                  <div class="form-group row m-0 p-1">
                    <div class="col-sm-12 m-0 p-1">
                      <textarea name="other" maxlength="300" class="form-control form-control-sm" rows="3" required></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- INFORMACION ACUDIENTE 1 -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION ACUDIENTE 1</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Nombre completo:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="nameattendant1" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="documentattendant1" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Dirección residencia:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="addressattendant1" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Localidad:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="localidadattendant1" required>
                        <option value="">Seleccione ...</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Barrio:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="barrioattendant1" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Celular:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="celularattendant1" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Whatsapp:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="whatsappattendant1" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">E-Mail:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="email" name="emailattendant1" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Profesional:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant1" class="" value="Profesional" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Tecnólogo:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant1" class="" value="Tecnólogo" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Técnico:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant1" class="" value="Técnico" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Otro:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant1" class="" value="Otros" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Título:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="tituloattendant1" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION ACUDIENTE 1</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Dependiente Laboral:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeworkattendant1" class="" value="Dependiente Laboral" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-4 m-0 p-1 text-muted">Independiente Laboral:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeworkattendant1" class="" value="Independiente Laboral" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Empresa:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="bussinessattendant1" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Dirección empresa:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="addressbussinessattendant1" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Ciudad empresa:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="citybussinessattendant1" required>
                        <option value="">Seleccione ...</option>
                        @foreach($citys as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Localidad:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="localidadempresaattendant1" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Barrio:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="barrioempresaattendant1" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Cargo:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="positionattendant1" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-6 m-0 p-1 text-muted">Fecha de ingreso:</small>
                    <div class="col-sm-6 m-0 p-1">
                      <input type="text" name="dateentryattendant1" maxlength="50" class="form-control form-control-sm datepicker" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- INFORMACION ACUDIENTE 2 -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION ACUDIENTE 2</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Nombre completo:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="nameattendant2" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="documentattendant2" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Dirección residencia:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="addressattendant2" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Localidad:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="localidadattendant2" required>
                        <option value="">Seleccione ...</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Barrio:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="barrioattendant2" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Celular:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="celularattendant2" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Whatsapp:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="whatsappattendant2" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">E-Mail:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="email" name="emailattendant2" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Profesional:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant2" class="" value="Profesional" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Tecnólogo:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant2" class="" value="Tecnólogo" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Técnico:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant2" class="" value="Técnico" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-3 m-0 p-1 text-muted">Otro:</small>
                    <div class="col-sm-3 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeprofessionattendant2" class="" value="Otros" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Título:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="tituloattendant2" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION ACUDIENTE 2</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Dependiente Laboral:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeworkattendant2" class="" value="Dependiente Laboral" required>
                      <small class="text-muted">)</small>
                    </div>
                    <small class="col-sm-4 m-0 p-1 text-muted">Independiente Laboral:</small>
                    <div class="col-sm-2 m-0 p-1">
                      <small class="text-muted">(</small>
                      <input type="radio" name="typeworkattendant2" class="" value="Independiente Laboral" required>
                      <small class="text-muted">)</small>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Empresa:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="bussinessattendant2" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Dirección empresa:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="addressbussinessattendant2" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Ciudad empresa:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="citybussinessattendant2" required>
                        <option value="">Seleccione ...</option>
                        @foreach($citys as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Localidad:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="localidadempresaattendant2" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Barrio:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="barrioempresaattendant2" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Cargo:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="positionattendant2" maxlength="50" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-6 m-0 p-1 text-muted">Fecha de ingreso:</small>
                    <div class="col-sm-6 m-0 p-1">
                      <input type="text" name="dateentryattendant2" maxlength="50" class="form-control form-control-sm datepicker" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- EN CASO DE EMERGENCIA Y PERSONAS AUTORIZADAS -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>DATOS EN CASO DE EMERGENCIA</small>
                    <br>
                    <small>(Persona diferente a los acudientes)</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Nombre completo:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="nameemergency" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="documentemergency" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-4 m-0 p-1 text-muted">Dirección residencia:</small>
                    <div class="col-sm-8 m-0 p-1">
                      <input type="text" name="addressemergency" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Localidad:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="localidademergency" required>
                        <option value="">Seleccione ...</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Barrio:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <select class="form-control form-control-sm select2" name="barrioemergency" required>
                        <option value="">Seleccione ...</option>
                        <!-- dinamics -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Celular:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="celularemergency" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                    <small class="col-sm-2 m-0 p-1 text-muted">Whatsapp:</small>
                    <div class="col-sm-4 m-0 p-1">
                      <input type="text" name="whatsappemergency" maxlength="10" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">Parentesco:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="text" name="relationemergency" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-2 m-0 p-1 text-muted">E-Mail:</small>
                    <div class="col-sm-10 m-0 p-1">
                      <input type="email" name="emailemergency" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>PERSONAS AUTORIZADA PARA ENTREGAR Y RECOGER</small>
                    <br>
                    <small>(Diferentes a los padres y/o acudientes)</small>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Nombre completo:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="nameautorized1" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="documentautorized1" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Parentesco:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="relationautorized1" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Nombre completo:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="nameautorized2" maxlength="60" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">N° Documento:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="documentautorized2" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
                    </div>
                  </div>
                  <div class="form-group row m-0 p-1">
                    <small class="col-sm-3 m-0 p-1 text-muted">Parentesco:</small>
                    <div class="col-sm-9 m-0 p-1">
                      <input type="text" name="relationautorized2" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- EXPECTATIVAS Y CULTURA -->
          <div class="row p-2">
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION Y EXPECTATIVAS</small>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Qué es lo que más les gustaría que supiéramos de su hijo?</small>
                    <textarea type="text" name="expectatives_likechild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Cuáles son las actividades preferidas de su niño?</small>
                    <textarea type="text" name="expectatives_activityschild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Hay algún juguete que su hijo prefiera?</small>
                    <textarea type="text" name="expectatives_toychild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿En qué aspectos considera que se destaca su hijo?</small>
                    <textarea type="text" name="expectatives_aspectchild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Qué esperanzas y sueños tiene para su niño?</small>
                    <textarea type="text" name="expectatives_dreamforchild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Qué es lo que más desea que su niño aprenda con nuestro programa?</small>
                    <textarea type="text" name="expectatives_learnchild" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row p-2">
                <div class="squater col-md-12 p-3">
                  <div class="form-group text-center">
                    <small>INFORMACION CULTURAL</small>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Hay alguna tradición, celebración o canción que sea de especial importancia para su familia y su niño?</small>
                    <textarea type="text" name="cultural_eventfamily" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Cómo desearía que apoyáramos en el jardín los valores y la identidad culturar de su familia?</small>
                    <textarea type="text" name="cultural_supportculturefamily" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Cómo podemos aprender más acerca de su herencia y cultura?</small>
                    <textarea type="text" name="cultural_gardenlearnculture" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                  <div class="form-group">
                    <small class="text-muted">¿Estarían dispuestos a compartir algo acerca de la herencia cultural de su familia con nuestros niños y equipo?</small>
                    <textarea type="text" name="cultural_shareculturefamily" placeholder="Texto de 1 a 200 carácteres" maxlength="200" class="form-control form-control-sm" required></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- FECHA DE INGRESO -->
          <div class="row p-2">
            <div class="col-md-12 p-3">
              <div class="form-group row m-0 p-1">
                <small class="col-sm-3 m-0 p-1 text-muted">Fecha de ingreso:</small>
                <small class="col-sm-1 m-0 p-1 text-muted">DIA:</small>
                <div class="col-sm-2 m-0 p-1">
                  <input type="text" name="dayentry" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                </div>
                <small class="col-sm-1 m-0 p-1 text-muted">MES:</small>
                <div class="col-sm-2 m-0 p-1">
                  <input type="text" name="monthentry" maxlength="2" class="form-control form-control-sm text-center" pattern="[0-9]{1,2}" required>
                </div>
                <small class="col-sm-1 m-0 p-1 text-muted">AÑO:</small>
                <div class="col-sm-2 m-0 p-1">
                  <input type="text" name="yearentry" maxlength="4" class="form-control form-control-sm text-center" pattern="[0-9]{1,4}" required>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- FIRMAS -->
          <!-- <div class="row p-2">
				        	<div class="col-md-6 p-3">
								<div class="form-group text-center">
									<small class="text-muted">________________________________________________________</small><br>
									<small class="text-muted">Firma del acudiente 1</small>
								</div>
				        	</div>
				        	<div class="col-md-6 p-3">
								<div class="form-group text-center">
									<small class="text-muted">________________________________________________________</small><br>
									<small class="text-muted">Firma del acudiente 2</small>
								</div>
				        	</div>
				        </div>
				        <hr> -->
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info text-center alert-message" style="font-size: 13px; display: none; color: red;"></div>
            </div>
          </div>
          <div class="form-group text-center pt-2 border-top">
            <input type="hidden" name="fmId_Edit" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-success form-control-sm btn-updateAdmission">GUARDAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteForm-modal">
  <div class="modal-dialog modal-lg" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h6>ELIMINACION DE FORMULARIO</h6>
      </div>
      <div class="modal-body">
        <form action="{{ route('deleteAdmission') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12 d-flex flex-column justify-content-center align-items-center">
              <span class="names_delete"></span>
              <img src="" class="img-responsive photo_delete img-thumbnail" style="width: 3cm; height: 4cm;">
              <small class="text-muted">DOCUMENTO</small>
              <span class="numberdocument_delete"></span>
              <small class="text-muted">FECHA NACIMIENTO</small>
              <span class="datebirth_delete"></span>
            </div>
          </div>
          <div class="form-group text-center pt-2 border-top">
            <input type="hidden" name="fmId_Delete" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-tertiary  form-control-sm">ELIMINAR INFORMACION/FORMULARIO</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {});

  $('.sectionPhoto').on('click', function() {
    $('#photoSelected').click();
  });
  $('#photoSelected').on('change', function(e) {
    if (e.target.files[0]) {
      let file = URL.createObjectURL(e.target.files[0]);
      $('#previewPhoto').attr('src', file);
      $('#previewPhoto').attr('hidden', false);
      $('.titlePhoto').attr('hidden', true);
    }
  });

  $('select[name=localidadattendant1]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=barrioattendant1]').empty();
    $('select[name=barrioattendant1]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getDistrictFromAdmission') }}", {
        location_id: selected
      }, function(objectsDistricts) {
        var count = Object.keys(objectsDistricts).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=barrioattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=citybussinessattendant1]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=localidadempresaattendant1]').empty();
    $('select[name=localidadempresaattendant1]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getLocationFromAdmission') }}", {
        city_id: selected
      }, function(objectsLocations) {
        var count = Object.keys(objectsLocations).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=localidadempresaattendant1]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=localidadempresaattendant1]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=barrioempresaattendant1]').empty();
    $('select[name=barrioempresaattendant1]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getDistrictFromAdmission') }}", {
        location_id: selected
      }, function(objectsDistricts) {
        var count = Object.keys(objectsDistricts).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=barrioempresaattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=localidadattendant2]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=barrioattendant2]').empty();
    $('select[name=barrioattendant2]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getDistrictFromAdmission') }}", {
        location_id: selected
      }, function(objectsDistricts) {
        var count = Object.keys(objectsDistricts).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=barrioattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=citybussinessattendant2]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=localidadempresaattendant2]').empty();
    $('select[name=localidadempresaattendant2]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getLocationFromAdmission') }}", {
        city_id: selected
      }, function(objectsLocations) {
        var count = Object.keys(objectsLocations).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=localidadempresaattendant2]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=localidadempresaattendant2]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=barrioempresaattendant2]').empty();
    $('select[name=barrioempresaattendant2]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getDistrictFromAdmission') }}", {
        location_id: selected
      }, function(objectsDistricts) {
        var count = Object.keys(objectsDistricts).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=barrioempresaattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  $('select[name=localidademergency]').on('change', function(e) {
    var selected = e.target.value;
    $('select[name=barrioemergency]').empty();
    $('select[name=barrioemergency]').append("<option value=''>Seleccione ...</option>");
    if (selected != '') {
      $.get("{{ route('getDistrictFromAdmission') }}", {
        location_id: selected
      }, function(objectsDistricts) {
        var count = Object.keys(objectsDistricts).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=barrioemergency]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      });
    }
  });

  /*=================================================================================
  	/ Edición de contratistas \
  =================================================================================*/

  $('.editForm-link').on('click', function(e) {
    e.preventDefault();
    var photo = $(this).find('img:first').attr('src');
    // console.log(photo);
    var fmId = $(this).find('span:nth-child(2)').text();
    var nombres = $(this).find('span:nth-child(3)').text();
    var apellidos = $(this).find('span:nth-child(4)').text();
    var genero = $(this).find('span:nth-child(5)').text();
    var fechanacimiento = $(this).find('span:nth-child(6)').text();
    var tipodocumento = $(this).find('span:nth-child(7)').text();
    var numerodocumento = $(this).find('span:nth-child(8)').text();
    var nacionalidad = $(this).find('span:nth-child(9)').text();
    var mesesgestacion = $(this).find('span:nth-child(10)').text();
    var tiposangre = $(this).find('span:nth-child(11)').text();
    var tipoparto = $(this).find('span:nth-child(12)').text();
    var enfermedades = $(this).find('span:nth-child(13)').text();
    var tratamientos = $(this).find('span:nth-child(14)').text();
    var alergias = $(this).find('span:nth-child(15)').text();
    var asistenciaterapias = $(this).find('span:nth-child(16)').text();
    var cual = $(this).find('span:nth-child(17)').text();
    var health = $(this).find('span:nth-child(18)').text();
    var programa = $(this).find('span:nth-child(19)').text();
    var numerohermanos = $(this).find('span:nth-child(20)').text();
    var lugarqueocupa = $(this).find('span:nth-child(21)').text();
    var conquienvive = $(this).find('span:nth-child(22)').text();
    var otroscuidados = $(this).find('span:nth-child(23)').text();
    var nombreacudiente1 = $(this).find('span:nth-child(24)').text();
    var documentoacudiente1 = $(this).find('span:nth-child(25)').text();
    var direccionacudiente1 = $(this).find('span:nth-child(26)').text();
    var barrioacudiente1 = $(this).find('span:nth-child(27)').text();
    var localidadacudiente1 = $(this).find('span:nth-child(28)').text();
    var celularacudiente1 = $(this).find('span:nth-child(29)').text();
    var whatsappacudiente1 = $(this).find('span:nth-child(30)').text();
    var correoacudiente1 = $(this).find('span:nth-child(31)').text();
    var formacionacudiente1 = $(this).find('span:nth-child(32)').text();
    var tituloacudiente1 = $(this).find('span:nth-child(33)').text();
    var tipoocupacionacudiente1 = $(this).find('span:nth-child(34)').text();
    var empresaacudiente1 = $(this).find('span:nth-child(35)').text();
    var direccionempresaacudiente1 = $(this).find('span:nth-child(36)').text();
    var ciudadempresaacudiente1 = $(this).find('span:nth-child(37)').text();
    var barrioempresaacudiente1 = $(this).find('span:nth-child(38)').text();
    var localidadempresaacudiente1 = $(this).find('span:nth-child(39)').text();
    var cargoempresaacudiente1 = $(this).find('span:nth-child(40)').text();
    var fechaingresoempresaacudiente1 = $(this).find('span:nth-child(41)').text();
    var nombreacudiente2 = $(this).find('span:nth-child(42)').text();
    var documentoacudiente2 = $(this).find('span:nth-child(43)').text();
    var direccionacudiente2 = $(this).find('span:nth-child(44)').text();
    var barrioacudiente2 = $(this).find('span:nth-child(45)').text();
    var localidadacudiente2 = $(this).find('span:nth-child(46)').text();
    var celularacudiente2 = $(this).find('span:nth-child(47)').text();
    var whatsappacudiente2 = $(this).find('span:nth-child(48)').text();
    var correoacudiente2 = $(this).find('span:nth-child(49)').text();
    var formacionacudiente2 = $(this).find('span:nth-child(50)').text();
    var tituloacudiente2 = $(this).find('span:nth-child(51)').text();
    var tipoocupacionacudiente2 = $(this).find('span:nth-child(52)').text();
    var empresaacudiente2 = $(this).find('span:nth-child(53)').text();
    var direccionempresaacudiente2 = $(this).find('span:nth-child(54)').text();
    var ciudadempresaacudiente2 = $(this).find('span:nth-child(55)').text();
    var barrioempresaacudiente2 = $(this).find('span:nth-child(56)').text();
    var localidadempresaacudiente2 = $(this).find('span:nth-child(57)').text();
    var cargoempresaacudiente2 = $(this).find('span:nth-child(58)').text();
    var fechaingresoempresaacudiente2 = $(this).find('span:nth-child(59)').text();
    var nombreemergencia = $(this).find('span:nth-child(60)').text();
    var documentoemergencia = $(this).find('span:nth-child(61)').text();
    var direccionemergencia = $(this).find('span:nth-child(62)').text();
    var barrioemergencia = $(this).find('span:nth-child(63)').text();
    var localidademergencia = $(this).find('span:nth-child(64)').text();
    var celularemergencia = $(this).find('span:nth-child(65)').text();
    var whatsappemergencia = $(this).find('span:nth-child(66)').text();
    var parentescoemergencia = $(this).find('span:nth-child(67)').text();
    var correoemergencia = $(this).find('span:nth-child(68)').text();
    var nombreautorizado1 = $(this).find('span:nth-child(69)').text();
    var documentoautorizado1 = $(this).find('span:nth-child(70)').text();
    var parentescoautorizado1 = $(this).find('span:nth-child(71)').text();
    var nombreautorizado2 = $(this).find('span:nth-child(72)').text();
    var documentoautorizado2 = $(this).find('span:nth-child(73)').text();
    var parentescoautorizado2 = $(this).find('span:nth-child(74)').text();
    var fechaingreso = $(this).find('span:nth-child(75)').text();
    var expectatives_likechild = $(this).find('span:nth-child(76)').text();
    var expectatives_activityschild = $(this).find('span:nth-child(77)').text();
    var expectatives_toychild = $(this).find('span:nth-child(78)').text();
    var expectatives_aspectchild = $(this).find('span:nth-child(79)').text();
    var expectatives_dreamforchild = $(this).find('span:nth-child(80)').text();
    var expectatives_learnchild = $(this).find('span:nth-child(81)').text();
    var cultural_eventfamily = $(this).find('span:nth-child(82)').text();
    var cultural_supportculturefamily = $(this).find('span:nth-child(83)').text();
    var cultural_gardenlearnculture = $(this).find('span:nth-child(84)').text();
    var cultural_shareculturefamily = $(this).find('span:nth-child(85)').text();
    $('input[name=fmId_Edit]').val(fmId);
    $('input[name=firstname]').val(nombres);
    $('input[name=lastname]').val(apellidos);
    $('select[name=gender]').val(genero);
    var separatedDate = fechanacimiento.split('-');
    $('input[name=day]').val(separatedDate[2]);
    $('input[name=month]').val(separatedDate[1]);
    $('input[name=year]').val(separatedDate[0]);
    checkSelected($('input[name=typedocument]'), tipodocumento);
    $('input[name=numberdocument]').val(numerodocumento);
    $('input[name=nationality]').val(nacionalidad);
    $('input[name=monthbord]').val(mesesgestacion);
    $('select[name=bloodtype]').val(tiposangre);
    checkSelected($('input[name=typebord]'), tipoparto);
    $('input[name=healthbad]').val(enfermedades);
    $('input[name=medical]').val(tratamientos);
    $('input[name=descripcionalergias]').val(alergias);
    $('select[name=terapia]').val(asistenciaterapias);
    $('input[name=whatterapia]').val(cual);
    $('select[name=health]').val(health);
    checkSelected($('input[name=typeprogram]'), programa);
    $('input[name=brothers]').val(numerohermanos);
    $('input[name=placebrother]').val(lugarqueocupa);
    $('input[name=withlive]').val(conquienvive);
    $('textarea[name=other]').val(otroscuidados);
    $('input[name=nameattendant1]').val(nombreacudiente1);
    $('input[name=documentattendant1]').val(documentoacudiente1);
    $('input[name=addressattendant1]').val(direccionacudiente1);
    $('select[name=localidadattendant1]').val(localidadacudiente1);
    $('textarea[name=expectatives_likechild]').val(expectatives_likechild);
    $('textarea[name=expectatives_activityschild]').val(expectatives_activityschild);
    $('textarea[name=expectatives_toychild]').val(expectatives_toychild);
    $('textarea[name=expectatives_aspectchild]').val(expectatives_aspectchild);
    $('textarea[name=expectatives_dreamforchild]').val(expectatives_dreamforchild);
    $('textarea[name=expectatives_learnchild]').val(expectatives_learnchild);
    $('textarea[name=cultural_eventfamily]').val(cultural_eventfamily);
    $('textarea[name=cultural_supportculturefamily]').val(cultural_supportculturefamily);
    $('textarea[name=cultural_gardenlearnculture]').val(cultural_gardenlearnculture);
    $('textarea[name=cultural_shareculturefamily]').val(cultural_shareculturefamily);
    $('select[name=barrioattendant1]').empty();
    $('select[name=barrioattendant1]').append("<option value=''>Seleccione ...</option>");
    $.get("{{ route('getDistrictFromAdmission') }}", {
      location_id: localidadacudiente1
    }, function(objectsDistricts) {
      var count = Object.keys(objectsDistricts).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsDistricts[i]['id'] == barrioacudiente1) {
            $('select[name=barrioattendant1]').append("<option value=" + objectsDistricts[i]['id'] + " selected>" + objectsDistricts[i]['name'] + "</option>");
          } else {
            $('select[name=barrioattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      }
    });

    $('input[name=celularattendant1]').val(celularacudiente1);
    $('input[name=whatsappattendant1]').val(whatsappacudiente1);
    $('input[name=emailattendant1]').val(correoacudiente1);
    checkSelected($('input[name=typeprofessionattendant1]'), formacionacudiente1);
    $('input[name=tituloattendant1]').val(tituloacudiente1);
    checkSelected($('input[name=typeworkattendant1]'), tipoocupacionacudiente1);
    $('input[name=bussinessattendant1]').val(empresaacudiente1);
    $('input[name=addressbussinessattendant1]').val(direccionempresaacudiente1);

    $('select[name=citybussinessattendant1]').val(ciudadempresaacudiente1);
    $('select[name=localidadempresaattendant1]').empty();
    $('select[name=localidadempresaattendant1]').append("<option value=''>Seleccione ...</option>");
    $('select[name=barrioempresaattendant1]').empty();
    $('select[name=barrioempresaattendant1]').append("<option value=''>Seleccione ...</option>");
    $.get("{{ route('getLocationFromAdmission') }}", {
      city_id: ciudadempresaacudiente1
    }, function(objectsLocations) {
      var count = Object.keys(objectsLocations).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsLocations[i]['id'] == localidadempresaacudiente1) {
            $('select[name=localidadempresaattendant1]').append("<option value=" + objectsLocations[i]['id'] + " selected>" + objectsLocations[i]['name'] + "</option>");
          } else {
            $('select[name=localidadempresaattendant1]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
          }
        }
      }
    });
    $.get("{{ route('getDistrictFromAdmission') }}", {
      location_id: localidadempresaacudiente1
    }, function(objectsDistricts) {
      var count = Object.keys(objectsDistricts).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsDistricts[i]['id'] == barrioempresaacudiente1) {
            $('select[name=barrioempresaattendant1]').append("<option value=" + objectsDistricts[i]['id'] + " selected>" + objectsDistricts[i]['name'] + "</option>");
          } else {
            $('select[name=barrioempresaattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      }
    });
    $('input[name=positionattendant1]').val(cargoempresaacudiente1);
    $('input[name=dateentryattendant1]').val(fechaingresoempresaacudiente1);
    $('input[name=nameattendant2]').val(nombreacudiente2);
    $('input[name=documentattendant2]').val(documentoacudiente2);
    $('input[name=addressattendant2]').val(direccionacudiente2);

    $('select[name=localidadattendant2]').val(localidadacudiente2);
    $('select[name=barrioattendant2]').empty();
    $('select[name=barrioattendant2]').append("<option value=''>Seleccione ...</option>");
    $.get("{{ route('getDistrictFromAdmission') }}", {
      location_id: localidadacudiente2
    }, function(objectsDistricts) {
      var count = Object.keys(objectsDistricts).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsDistricts[i]['id'] == barrioacudiente2) {
            $('select[name=barrioattendant2]').append("<option value=" + objectsDistricts[i]['id'] + " selected>" + objectsDistricts[i]['name'] + "</option>");
          } else {
            $('select[name=barrioattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      }
    });

    $('input[name=celularattendant2]').val(celularacudiente2);
    $('input[name=whatsappattendant2]').val(whatsappacudiente2);
    $('input[name=emailattendant2]').val(correoacudiente2);
    checkSelected($('input[name=typeprofessionattendant2]'), formacionacudiente2);
    $('input[name=tituloattendant2]').val(tituloacudiente2);
    checkSelected($('input[name=typeworkattendant2]'), tipoocupacionacudiente2);
    $('input[name=bussinessattendant2]').val(empresaacudiente2);
    $('input[name=addressbussinessattendant2]').val(direccionempresaacudiente2);

    $('select[name=citybussinessattendant2]').val(ciudadempresaacudiente2);
    $('select[name=localidadempresaattendant2]').empty();
    $('select[name=localidadempresaattendant2]').append("<option value=''>Seleccione ...</option>");
    $('select[name=barrioempresaattendant2]').empty();
    $('select[name=barrioempresaattendant2]').append("<option value=''>Seleccione ...</option>");
    $.get("{{ route('getLocationFromAdmission') }}", {
      city_id: ciudadempresaacudiente2
    }, function(objectsLocations) {
      var count = Object.keys(objectsLocations).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsLocations[i]['id'] == localidadempresaacudiente2) {
            $('select[name=localidadempresaattendant2]').append("<option value=" + objectsLocations[i]['id'] + " selected>" + objectsLocations[i]['name'] + "</option>");
          } else {
            $('select[name=localidadempresaattendant2]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
          }
        }
      }
    });
    $.get("{{ route('getDistrictFromAdmission') }}", {
      location_id: localidadempresaacudiente2
    }, function(objectsDistricts) {
      var count = Object.keys(objectsDistricts).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsDistricts[i]['id'] == barrioempresaacudiente2) {
            $('select[name=barrioempresaattendant2]').append("<option value=" + objectsDistricts[i]['id'] + " selected>" + objectsDistricts[i]['name'] + "</option>");
          } else {
            $('select[name=barrioempresaattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      }
    });

    $('input[name=positionattendant2]').val(cargoempresaacudiente2);
    $('input[name=dateentryattendant2]').val(fechaingresoempresaacudiente2);
    $('input[name=nameemergency]').val(nombreemergencia);
    $('input[name=documentemergency]').val(documentoemergencia);
    $('input[name=addressemergency]').val(direccionemergencia);

    $('select[name=localidademergency]').val(localidademergencia);
    $('select[name=barrioemergency]').empty();
    $('select[name=barrioemergency]').append("<option value=''>Seleccione ...</option>");
    $.get("{{ route('getDistrictFromAdmission') }}", {
      location_id: localidademergencia
    }, function(objectsDistricts) {
      var count = Object.keys(objectsDistricts).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (objectsDistricts[i]['id'] == barrioemergencia) {
            $('select[name=barrioemergency]').append("<option value=" + objectsDistricts[i]['id'] + " selected>" + objectsDistricts[i]['name'] + "</option>");
          } else {
            $('select[name=barrioemergency]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
          }
        }
      }
    });

    $('input[name=celularemergency]').val(celularemergencia);
    $('input[name=whatsappemergency]').val(whatsappemergencia);
    $('input[name=relationemergency]').val(parentescoemergencia);
    $('input[name=emailemergency]').val(correoemergencia);
    $('input[name=nameautorized1]').val(nombreautorizado1);
    $('input[name=documentautorized1]').val(documentoautorizado1);
    $('input[name=relationautorized1]').val(parentescoautorizado1);
    $('input[name=nameautorized2]').val(nombreautorizado2);
    $('input[name=documentautorized2]').val(documentoautorizado2);
    $('input[name=relationautorized2]').val(parentescoautorizado2);
    var separatedDateentry = fechaingreso.split('-');
    $('input[name=dayentry]').val(separatedDateentry[2]);
    $('input[name=monthentry]').val(separatedDateentry[1]);
    $('input[name=yearentry]').val(separatedDateentry[0]);
    $('#previewPhoto').attr('hidden', false);
    $('#previewPhoto').attr('src', photo);
    $('#editForm-modal').modal();
  });

  $('.btn-updateAdmission').on('click', function(e) {
    let año = parseInt($('input[name=year]').val());
    let mes = parseInt($('input[name=month]').val());
    let dia = parseInt($('input[name=day]').val());
    let añoingreso = parseInt($('input[name=yearentry]').val());
    let mesingreso = parseInt($('input[name=monthentry]').val());
    let diaingreso = parseInt($('input[name=dayentry]').val());
    if (existe(año, mes, dia)) {
      if (existe(añoingreso, mesingreso, diaingreso)) {
        $(this).submit();
      } else {
        e.preventDefault();
        $('.alert-message').css('display', 'flex');
        $('.alert-message').append('La (fecha de ingreso) no existe');
        setTimeout(function() {
          $('.alert-message').css('display', 'none');
          $('.alert-message').empty();
        }, 5000);
      }
    } else {
      e.preventDefault();
      $('.alert-message').css('display', 'flex');
      $('.alert-message').append('La (fecha de nacimiento del niño/niña) no existe');
      setTimeout(function() {
        $('.alert-message').css('display', 'none');
        $('.alert-message').empty();
      }, 5000);
    }

  });

  function checkSelected(elemento, value) {
    let validate = false;
    elemento.each(function(index) {
      if (elemento[index].value == value) {
        elemento[index].checked = true;
      }
    });
  }

  function existe(año, mes, dia) {
    let fecha = new Date(año, mes, '0');
    return mes > 0 && mes < 13 && año > 0 && año < 32768 && dia > 0 && dia <= (new Date(año, mes, 0)).getDate();
  }
  /*=================================================================================
  	/ Eliminación de contratistas \
  =================================================================================*/

  $('.deleteForm-link').on('click', function(e) {
    e.preventDefault();
    var photo = $(this).find('img:first').attr('src');
    var fmId = $(this).find('span:nth-child(2)').text();
    var nombres = $(this).find('span:nth-child(3)').text();
    var apellidos = $(this).find('span:nth-child(4)').text();
    var numerodocumento = $(this).find('span:nth-child(5)').text();
    var fechanacimiento = $(this).find('span:nth-child(6)').text();
    $('input[name=fmId_Delete]').val(fmId);
    $('.names_delete').text(nombres + ' ' + apellidos);
    $('.photo_delete').attr('src', photo);
    $('.numberdocument_delete').text(numerodocumento);
    $('.datebirth_delete').text(fechanacimiento);
    $('#deleteForm-modal').modal();
  });
</script>
@endsection