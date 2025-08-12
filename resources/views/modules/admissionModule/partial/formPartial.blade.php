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
            <input type="text" name="firstname" maxlength="40" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-2 m-0 p-1 text-muted">Apellidos:</small>
          <div class="col-sm-10 m-0 p-1">
            <input type="text" name="lastname" maxlength="40" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="radio" name="typedocument" class="" value="REGISTRO CIVIL" required>
            <small class="text-muted">)</small>
          </div>
          <small class="col-sm-3 m-0 p-1 text-muted">Pasaporte:</small>
          <div class="col-sm-3 m-0 p-1">
            <small class="text-muted">(</small>
            <input type="radio" name="typedocument" class="" value="PASAPORTE" required>
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
            <input type="text" name="nationality" maxlength="40" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
              <small class="text-muted">JORNADA HASTA 12:00 PM</small>
              <small class="text-muted">(</small>
              <input type="radio" name="typeprogram" class="" value="JORNADA HASTA 12:00 PM" required>
              <small class="text-muted">)</small>
            </li>
            <li>
              <small class="text-muted">JORNADA HASTA 03:00 PM</small>
              <small class="text-muted">(</small>
              <input type="radio" name="typeprogram" class="" value="JORNADA HASTA 03:00 PM" required>
              <small class="text-muted">)</small>
            </li>
            <li>
              <small class="text-muted">JORNADA HASTA LAS 05:00 PM</small>
              <small class="text-muted">(</small>
              <input type="radio" name="typeprogram" class="" value="JORNADA HASTA LAS 05:00 PM" required>
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
            <input type="text" name="nameattendant1" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-2 m-0 p-1 text-muted">N° Documento:</small>
          <div class="col-sm-3 m-0 p-1">
            <input type="text" name="documentattendant1" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
          </div>
          <small class="col-sm-3 m-0 p-1 text-muted">Tipo Documento:</small>
          <div class="col-sm-4 m-0 p-1">
            <select name="typedocumentattendant1" class="form-control form-control-sm select2" required>
              <option value="">seleccione...</option>
              @foreach($typeDocuments as $document)
              @if($document->type != "NO REPORTA")
              <option value="{{ $document->id }}">{{ $document->type }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-4 m-0 p-1 text-muted">Dirección residencia:</small>
          <div class="col-sm-8 m-0 p-1">
            <input type="text" name="addressattendant1" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
          <small class="col-sm-1 m-0 p-1 text-muted">E-Mail:</small>
          <div class="col-sm-6 m-0 p-1">
            <input type="email" name="emailattendant1" class="form-control form-control-sm" required>
          </div>
          <small class="col-sm-2 m-0 p-1 text-muted">Sexo:</small>
          <div class="col-sm-3 m-0 p-1">
            <select name="sexattendant1" class="form-control form-control-sm select2" required>
              <option value="">seleccione...</option>
              <option value="MASCULINO">MASCULINO</option>
              <option value="FEMENINO">FEMENINO</option>
            </select>
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
          <small class="col-sm-1 m-0 p-1 text-muted">Título:</small>
          <div class="col-sm-6 m-0 p-1">
            <input type="text" name="tituloattendant1" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
          <small class="col-sm-2 m-0 p-1 text-muted">Tipo de Sangre</small>
          <select name="bloodtypeattendant1" class="col-sm-3 m-0 p-1 form-control form-control-sm select2" required>
            <option value="">seleccione...</option>
            @foreach($bloodtypes as $item)
            @if($item->group != "NO REPORTADA")
            <option value="{{ $item->id}}">{{ $item->group }} {{ $item->type }}</option>
            @endif
            @endforeach
          </select>
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
            <input type="text" name="bussinessattendant1" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-3 m-0 p-1 text-muted">Dirección empresa:</small>
          <div class="col-sm-9 m-0 p-1">
            <input type="text" name="addressbussinessattendant1" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="positionattendant1" maxlength="50" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="nameattendant2" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-2 m-0 p-1 text-muted">N° Documento:</small>
          <div class="col-sm-3 m-0 p-1">
            <input type="text" name="documentattendant2" maxlength="15" class="form-control form-control-sm" pattern="[0-9]{1,15}" required>
          </div>
          <small class="col-sm-3 m-0 p-1 text-muted">Tipo Documento:</small>
          <div class="col-sm-4 m-0 p-1">
            <select name="typedocumentattendant2" class="form-control form-control-sm select2" required>
              <option value="">seleccione...</option>
              @foreach($typeDocuments as $document)
              @if($document->type != "NO REPORTA")
              <option value="{{ $document->id }}">{{ $document->type }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-4 m-0 p-1 text-muted">Dirección residencia:</small>
          <div class="col-sm-8 m-0 p-1">
            <input type="text" name="addressattendant2" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
          <small class="col-sm-1 m-0 p-1 text-muted">E-Mail:</small>
          <div class="col-sm-6 m-0 p-1">
            <input type="email" name="emailattendant2" class="form-control form-control-sm" required>
          </div>
          <small class="col-sm-2 m-0 p-1 text-muted">Sexo:</small>
          <div class="col-sm-3 m-0 p-1">
            <select name="sexattendant2" class="form-control form-control-sm select2" required>
              <option value="">seleccione...</option>
              <option value="MASCULINO">MASCULINO</option>
              <option value="FEMENINO">FEMENINO</option>
            </select>
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
        <!-- crear los nuevos campos en la base de datos en la tabla Formadmission y revisar rutina de almacenamiento -->
        <div class="form-group row m-0 p-1">
          <small class="col-sm-1 m-0 p-1 text-muted">Título:</small>
          <div class="col-sm-6 m-0 p-1">
            <input type="text" name="tituloattendant2" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
          <small class="col-sm-2 m-0 p-1 text-muted">Tipo de Sangre</small>
          <select name="bloodtypeattendant2" class="col-sm-3 m-0 p-1 form-control form-control-sm select2" required>
            <option value="">seleccione...</option>
            @foreach($bloodtypes as $item)
            @if($item->group != "NO REPORTADA")
            <option value="{{ $item->id}}">{{ $item->group }} {{ $item->type }}</option>
            @endif
            @endforeach
          </select>
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
            <input type="text" name="bussinessattendant2" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-3 m-0 p-1 text-muted">Dirección empresa:</small>
          <div class="col-sm-9 m-0 p-1">
            <input type="text" name="addressbussinessattendant2" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="positionattendant2" maxlength="50" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="nameemergency" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="addressemergency" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="relationemergency" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="nameautorized1" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="relationautorized1" style="text-transform: uppercase;" class="form-control form-control-sm" required>
          </div>
        </div>
        <div class="form-group row m-0 p-1">
          <small class="col-sm-3 m-0 p-1 text-muted">Nombre completo:</small>
          <div class="col-sm-9 m-0 p-1">
            <input type="text" name="nameautorized2" maxlength="60" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
            <input type="text" name="relationautorized2" style="text-transform: uppercase;" class="form-control form-control-sm" required>
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
<hr>
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-info text-center alert-message" style="font-size: 13px; display: none; color: red;"></div>
  </div>
</div>
<hr>
<button class="btn btn-outline-success btn-block btn-sendform">ENVIAR</button>
<hr>