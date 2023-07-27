@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">MODIFICACION DE ALUMNO: <br><b>{{ $student->threename }} {{ $student->fourname }}, {{ $student->firstname }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('students') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formStudentUpdate" action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">

        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE DOCUMENTO: *</small>
                @php $namedocument = 'N/A'; @endphp
                <select class="form-control form-control-sm" name="typedocument_id_edit" required="required">
                  <option value="">Seleccione tipo...</option>
                  @foreach($documents as $document)
                  @if($document->id == $student->typedocument_id)
                  @php $namedocument = $document->type; @endphp
                  <option value="{{ $document->id }}" selected="selected">{{ $document->type }}</option>
                  @else
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endif
                  @endforeach
                </select>
                <small class="text-muted">Actualmente es <b>{{ $namedocument }}</b></small>
              </div>
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO: *</small>
                <input type="text" pattern="[0-9]{1,12}" name="numberdocument_edit" class="form-control form-control-sm" value="{{ $student->numberdocument }}" required>
                <small class="text-muted">Actualmente es <b>{{ $student->numberdocument }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">NOMBRES:</small>
                <input type="text" name="firstname_edit" class="form-control form-control-sm" value="{{ $student->firstname }}" required>
                <small class="text-muted">Actualmente es <b>{{ $student->firstname }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">PRIMER APELLIDO:</small>
                <input type="text" name="threename_edit" class="form-control form-control-sm" required value="{{ $student->threename }}">
                <small class="text-muted">Actualmente es <b>{{ $student->threename }}</b></small>
              </div>
              <div class="col-md-6">
                <small class="text-muted">SEGUNDO APELLIDO:</small>
                <input type="text" name="fourname_edit" class="form-control form-control-sm" required value="{{ $student->fourname }}">
                @if($student->fourname == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $student->fourname }}</b></small>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE SANGRE:</small>
                <select class="form-control form-control-sm" name="bloodtype_id_edit" required>
                  <option value="">Seleccione grupo...</option>
                  @php $namebloodtypes = '' @endphp
                  @foreach($bloodtypes as $bloodtype)
                  @if($bloodtype->id == $student->bloodtype_id)
                  @php $namebloodtypes = $bloodtype->group . " " . $bloodtype->type @endphp
                  <option value="{{ $bloodtype->id }}" selected="selected">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @else
                  <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @endif
                  @endforeach
                </select>
                @if($namebloodtypes === '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $namebloodtypes }}</b></small>
                @endif
              </div>
              <div class="col-md-6">
                <small class="text-muted">GENERO:</small>
                <select class="form-control form-control-sm" id="gender_edit" name="gender_edit" required>
                  <option value="">Seleccione genero...</option>
                  <option value="MASCULINO">MASCULINO</option>
                  <option value="FEMENINO">FEMENINO</option>
                  <option value="INDEFINIDO">INDEFINIDO</option>
                </select>
                <input type="hidden" id="genderActual" value="{{ $student->gender }}">
                <small class="text-muted">Actualmente es <b>{{ $student->gender }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">FECHA DE NACIMIENTO:</small>
                <input type="text" name="birthdate_edit" id="birthdate_edit" class="form-control form-control-sm datepicker" value="{{ $student->birthdate }}" required>
                @if($student->birthdate == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $student->birthdate }}</b></small>
                @endif
              </div>
              <input type="hidden" id="yearsold_hidden" value="{{ $student->yearsold }}">
              <div class="col-md-6">
                <small class="text-muted">EDAD:</small>
                <input type="text" name="yearsold_edit" id="yearsold_edit" class="form-control form-control-sm" readonly>
                <small id="smallyear" class="text-muted">Actualmente es <b></b></small>
              </div>
            </div>
          </div>
        </div><!-- Fin panel izquierdo superior -->

        <div class="col-md-6 border-left">
          <div class="form-group text-center">
            <small class="text-muted">FOTO ACTUAL: {{ $student->numberdocument}}</small><br>
            <input type="hidden" name="photo_hidden" class="form-control form-control-sm" value="{{ $student->photo }}" required>
            <img class="img-thumbnail" src="{{ asset('storage/admisiones/fotosaspirantes/'.$MyPhoto)}}" style="width: 3cm; height: 4cm;">
          </div>
          <div class="form-group text-center">
            <small class="text-muted">CAMBIAR FOTO:</small>
            <div class="custom-file">
              <input type="file" name="photo" lang="es" title="Unicamente con extensión .jpg .jpeg o .png" accept="image/jpeg">
            </div>
          </div>
          <div class="form-group">
            <small for="cityhome_id_edit" class="text-muted">CIUDAD:</small>
            <select class="form-control form-control-sm" id="cityhome_id_edit" name="cityhome_id_edit" required>
              <option value="">Seleccione una ciudad...</option>
              @php $namecity = '' @endphp
              @foreach($citys as $city)
              @if($city->id == $student->cityhome_id)
              @php $namecity = $city->name @endphp
              <option value="{{ $city->id }}" selected="selected">{{ $city->name }}</option>
              @else
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">LOCALIDAD:</small>
                <input type="hidden" id="locationhome_id_hidden" value="{{ $student->locationhome_id }}">
                <select class="form-control form-control-sm" id="locationhome_id_edit" name="locationhome_id_edit" required>
                  <option value="">Seleccione una localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO:</small>
                <input type="hidden" id="dictricthome_id_hidden" value="{{ $student->dictricthome_id }}">
                <select class="form-control form-control-sm" id="dictricthome_id_edit" name="dictricthome_id_edit" required>
                  <option value="">Seleccione un barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">DIRECCIÓN:</small>
            <input type="text" name="address_edit" class="form-control form-control-sm" required value="{{ $student->address }}">
            @if($student->address == '')
            <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
            @else
            <small class="text-muted">Actualmente es <b>{{ $student->address }}</b></small>
            @endif
          </div>
          <div class="form-group">
            <small class="text-muted">AFILIACIÓN A CENTRO DE SALUD:</small>
            <select class="form-control form-control-sm" name="health_id_edit" required>
              <option value="">Seleccione ciudad...</option>
              @php $namecity = '' @endphp
              @foreach($healths as $health)
              @if($health->id == $student->health_id)
              @php $namehealth = $health->entity . " - " . $health->type @endphp
              <option value="{{ $health->id }}" selected="selected">{{ $health->entity . " - " . $health->type }}</option>
              @else
              <option value="{{ $health->id }}">{{ $health->entity . " - " . $health->type }}</option>
              @endif
              @endforeach
            </select>
            @if($namehealth == '')
            <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
            @else
            <small class="text-muted">Actualmente es <b>{{ $namehealth }}</b></small>
            @endif
          </div>
          <div class="form-group">
            <small class="text-muted">¿SALUD ADICIONAL?:</small>
            <select class="form-control form-control-sm" name="additionalHealt_edit" id="additionalHealt_edit" required>
              <option value="">Seleccione...</option>
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
            <input type="hidden" id="healthAditionalActual" value="{{ $student->additionalHealt }}">
            <small class="text-muted">Actualmente es <b>{{ $student->additionalHealt }}</b></small>
          </div>
        </div><!-- Fin panel derecho superior -->
      </div>

      <div class="row border-top">
        <div class="col-md-12 form-group">
          <small class="text-muted">DESCRIPCIÓN DE SALUD ADICIONAL:</small>
          <input type="hidden" id="additionalHealtDescription_hidden" value="{{ $student->additionalHealtDescription }}">
          <textarea class="form-control form-control-sm" name="additionalHealtDescription_edit" id="additionalHealtDescription_edit">{{ $student->additionalHealtDescription }}</textarea>
          @if($student->additionalHealtDescription == '')
          <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
          @else
          <small class="text-muted">Actualmente es <b>{{ $student->additionalHealtDescription }}</b></small>
          @endif
        </div>
      </div>

    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6 text-center">
          <button type="submit" id="saveAttendant" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIOS</button>
        </div>
        <div class="col-md-6 text-center">
          <div class="messageAttendant alert">
            @if(count($errors) > 0)
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
            @endif
          </div>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {

    var valueGenderActual = $('#genderActual').val();
    $("#gender_edit option[value=" + valueGenderActual + "]").attr("selected", true);

    var valuehealthAditionalActual = $('#healthAditionalActual').val();
    $("#additionalHealt_edit option[value=" + valuehealthAditionalActual + "]").attr("selected", true);

    var cityhome_id = $("select[name=cityhome_id_edit]").val();
    if (cityhome_id > 0) {
      fullSelectHome(cityhome_id);
    }

    var aditionalHealth = $("select[name=additionalHealt_edit]").val();

    if (aditionalHealth == 'SI') {
      $('#additionalHealtDescription_edit').attr('readonly', false);
    } else {
      $('#additionalHealtDescription_edit').attr('readonly', true);
      $('#additionalHealtDescription_edit').val('');
    }

    $("#additionalHealt_edit").on("change", function(e) {
      var value = e.target.value;
      if (value == 'NO') {
        $('#additionalHealtDescription_edit').attr('readonly', true);
        $('#additionalHealtDescription_edit').val('');
      } else {
        $('#additionalHealtDescription_edit').attr('readonly', false);
        $('#additionalHealtDescription_edit').val($('#additionalHealtDescription_hidden').val());
      }
    });

    $("#cityhome_id_edit").on("change", function(e) {
      var cityhome_id = e.target.value;
      $.get("{{ route('edit.sublocation') }}", {
        cityhome_id: cityhome_id
      }, function(locationObject) {
        var count = Object.keys(locationObject).length //total de localidades devueltas
        $('#locationhome_id_edit').empty();
        $('#locationhome_id_edit').append("<option value=''>Seleccione localidad...</option>");
        $('#dictricthome_id_edit').empty();
        $('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
        for (var i = 0; i < count; i++) {
          $('#locationhome_id_edit').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
        }
      });
    });
    $("#locationhome_id_edit").on("change", function(e) {
      var locationhome_id = e.target.value;
      $.get("{{ route('edit.subdistrict') }}", {
        locationhome_id: locationhome_id
      }, function(districtObject) {
        var count = Object.keys(districtObject).length //total de barrios devueltos
        $('#dictricthome_id_edit').empty();
        $('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
        for (var i = 0; i < count; i++) {
          $('#dictricthome_id_edit').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
        }
      });
    });

    var year = $('#yearsold_hidden').val();
    var subyear = year.split('-');
    $('#yearsold_edit').val(subyear[0]);
    $('#monthold_edit').val(subyear[1]);
    $('#smallyear').append('<b>' + subyear[0] + '</b>');
    $('#smallmonth').append('<b>' + subyear[1] + '</b>');


    $('#birthdate_edit').on('change', function() {
      calculateBirthdate($('#birthdate_edit').val());
    });

  });

  function fullSelectHome(value) {
    $.get("{{ route('edit.sublocation') }}", {
      cityhome_id: value
    }, function(locationObject) {
      var count = Object.keys(locationObject).length //total de localidades devueltas
      $('#locationhome_id_edit').empty();
      $('#locationhome_id_edit').append("<option value=''>Seleccione localidad...</option>");
      var locationhome_id_hidden = $('#locationhome_id_hidden').val();
      for (var i = 0; i < count; i++) {
        if (locationhome_id_hidden != '') {
          if (locationhome_id_hidden == locationObject[i]['id']) {
            $('#locationhome_id_edit').append("<option value=" + locationObject[i]['id'] + " selected>" + locationObject[i]['name'] + "</option>");
          } else {
            $('#locationhome_id_edit').append("<option value=" + locationObject[i]['id'] + ">" + locationObject[i]['name'] + "</option>");
          }
        } else {
          $('#locationhome_id_edit').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
        }
      }
      var locationhome_id_result = $('select[id=locationhome_id_edit]').val();
      $.get("{{ route('edit.subdistrict') }}", {
        locationhome_id: locationhome_id_result
      }, function(districtObject) {
        var count = Object.keys(districtObject).length //total de barrios devueltos
        $('#dictricthome_id_edit').empty();
        $('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
        var dictricthome_id_hidden = $('#dictricthome_id_hidden').val();
        for (var i = 0; i < count; i++) {
          if (dictricthome_id_hidden != '') {
            if (dictricthome_id_hidden == districtObject[i]['id']) {
              $('#dictricthome_id_edit').append("<option value=" + districtObject[i]['id'] + " selected>" + districtObject[i]['name'] + "</option>");
            } else {
              $('#dictricthome_id_edit').append("<option value=" + districtObject[i]['id'] + ">" + districtObject[i]['name'] + "</option>");
            }
          } else {
            $('#dictricthome_id_edit').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
          }
        }
      });
    });
  }

  function calculateBirthdate(date) {

    //if(validate_date(date)==true){
    if (date != '') {
      var values = date.split("/");
      var day = values[2];
      var mount = values[1];
      var year = values[0];
      var now = new Date();
      var yearNow = now.getYear()
      var mountNow = now.getMonth() + 1;
      var dayNow = now.getDate();

      var old = (yearNow + 1900) - year;
      if (mountNow < mount) {
        old--;
      }
      if ((mount == mountNow) && (dayNow < day)) {
        old--;
      }
      if (old > 1900) {
        old -= 1900;
      }

      var mounts = 0;
      if (mountNow > mount) {
        mounts = mountNow - mount;
      }
      if (mountNow < mount) {
        mounts = 12 - (mount - mountNow);
      }
      if (mountNow == mount && day > dayNow) {
        mounts = 11;
      }

      var days = 0;
      if (dayNow > day) {
        days = dayNow - day
      }
      if (dayNow < day) {
        lastDayMount = new Date(yearNow, mountNow, 0);
        days = lastDayMount.getDate() - (day - dayNow);
      }

      $('#yearsold_edit').val('');
      $('#yearsold_edit').val(old);
      $('#monthold_edit').val('');
      $('#monthold_edit').val(mounts);
      //$('#dayold').val(days);

    } else {
      console.log("La fecha " + date + " es incorrecta");

    }

  }
</script>
@endsection