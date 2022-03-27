@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">MODIFICACION DE COLABORADOR: <b>{{ $collaborator->firstname }} {{ $collaborator->threename }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('collaborators') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formCollaboratorUpdate" action="{{ route('collaborator.update', $collaborator->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="typedocument_id_edit" class="text-muted">TIPO DE DOCUMENTO: *</small>
                <select class="form-control form-control-sm select2" id="typedocument_id_edit" name="typedocument_id_edit" required="required">
                  <option value="">Seleccione tipo...</option>
                  @php $namedocument = '' @endphp
                  @foreach($documents as $document)
                  @if($document->id == $collaborator->typedocument_id)
                  @php $namedocument = $document->type @endphp
                  <option value="{{ $document->id }}" selected="selected">{{ $document->type }}</option>
                  @else
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endif
                  @endforeach
                </select>
                <small for="typedocument_id_edit" class="text-muted">Actualmente es <b>{{ $namedocument }}</b></small>
              </div>
              <div class="col-md-6">
                <small for="numberdocument_edit" class="text-muted">NÚMERO DE DOCUMENTO: *</small>
                <input type="number" name="numberdocument_edit" id="numberdocument_edit" class="form-control form-control-sm" value="{{ $collaborator->numberdocument }}" required>
                <small for="typedocument_id_edit" class="text-muted">Actualmente es <b>{{ $collaborator->numberdocument }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small for="firstname_edit" class="text-muted">NOMBRES: *</small>
                <input type="text" name="firstname_edit" id="firstname_edit" class="form-control form-control-sm" value="{{ $collaborator->firstname }}" required>
                <small for="firstname_edit" class="text-muted">Actualmente es <b>{{ $collaborator->firstname }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">PRIMER APELLIDO: *</small>
                <input type="text" name="threename_edit" class="form-control form-control-sm" required value="{{ $collaborator->threename }}">
                <small class="text-muted">Actualmente es <b>{{ $collaborator->threename }}</b></small>
              </div>
              <div class="col-md-6">
                <small class="text-muted">SEGUNDO APELLIDO: *</small>
                <input type="text" name="fourname_edit" class="form-control form-control-sm" required value="{{ $collaborator->fourname }}">
                @if($collaborator->fourname == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $collaborator->fourname }}</b></small>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 text-center">
                <small class="text-muted">FOTOGRAFIA:</small>
                <img src="{{ asset('storage/collaborators/'.$collaborator->photo) }}" class="img-thumbnail" alt="Foto" style="width: 150px; height: auto; text-align: center;">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="custom-file">
                  <input type="file" name="photo_edit" lang="es" placeholder="Unicamente con extensión .jpg o .jpeg" accept="image/jpg,image/jpeg">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="bloodtype_id_edit" class="text-muted">TIPO DE SANGRE: *</small>
                <select class="form-control form-control-sm select2" id="bloodtype_id_edit" name="bloodtype_id_edit" required>
                  <option value="">Seleccione grupo...</option>
                  @php $namebloodtypes = '' @endphp
                  @foreach($bloodtypes as $bloodtype)
                  @if($bloodtype->id == $collaborator->bloodtype_id)
                  @php $namebloodtypes = $bloodtype->group . " " . $bloodtype->type @endphp
                  <option value="{{ $bloodtype->id }}" selected="selected">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @else
                  <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @endif
                  @endforeach
                </select>
                @if($namebloodtypes === '')
                <small for="bloodtype_id_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small for="bloodtype_id_edit" class="text-muted">Actualmente es <b>{{ $namebloodtypes }}</b></small>
                @endif
              </div>
              <div class="col-md-6">
                <small for="gender_edit" class="text-muted">GENERO: *</small>
                <select class="form-control form-control-sm select2" id="gender_edit" name="gender_edit" required="required">
                  <option value="">Seleccione genero...</option>
                  <option value="MASCULINO">MASCULINO</option>
                  <option value="FEMENINO">FEMENINO</option>
                  <option value="INDEFINIDO">INDEFINIDO</option>
                </select>
                <input type="hidden" id="genderActual" value="{{ $collaborator->gender }}">
                <small id="genderActualView" for="gender_edit" class="text-muted">Actualmente es <b>{{ $collaborator->gender }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="profession_id_edit" class="text-muted">PROFESION:</small>
            <select class="form-control form-control-sm select2" id="profession_id_edit" name="profession_id_edit">
              <option value="">Seleccione profesión...</option>
              @php $namedocument = '' @endphp
              @foreach($professions as $profession)
              @if($profession->id == $collaborator->profession_id)
              @php $namedocument = $profession->title @endphp
              <option value="{{ $profession->id }}" selected="selected">{{ $profession->title }}</option>
              @else
              <option value="{{ $profession->id }}">{{ $profession->title }}</option>
              @endif
              @endforeach
            </select>
            @if($namebloodtypes === '')
            <small for="profession_id_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
            @else
            <small for="profession_id_edit" class="text-muted">Actualmente es <b>{{ $namedocument }}</b></small>
            @endif
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">CARGO:</small>
                <input type="text" name="position_edit" class="form-control form-control-sm" value="{{ $collaborator->position }}" required>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 border-left">
          <div class="form-group">
            <small for="cityhome_id_edit" class="text-muted">CIUDAD: *</small>
            <select class="form-control form-control-sm select2" id="cityhome_id_edit" name="cityhome_id_edit" required="required">
              <option value="">Seleccione ciudad...</option>
              @php $namecity = '' @endphp
              @foreach($citys as $city)
              @if($city->id == $collaborator->cityhome_id)
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
                <small for="locationhome_id_edit" class="text-muted">LOCALIDAD: * </small>
                <input type="hidden" id="locationhome_id_hidden" value="{{ $collaborator->locationhome_id }}">
                <select class="form-control form-control-sm select2" id="locationhome_id_edit" name="locationhome_id_edit" required>
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO: *</small>
                <input type="hidden" id="dictricthome_id_hidden" value="{{ $collaborator->dictricthome_id }}">
                <select class="form-control form-control-sm select2" id="dictricthome_id_edit" name="dictricthome_id_edit" required>
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
                <!-- @ if($collaborator->dictricthome_id == '')
										<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
									@ else
										<small class="text-muted">Referencia actual <b>{{ $collaborator->dictricthome_id }}</b></small>
									@ endif-->
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="address_edit" class="text-muted">DIRECCIÓN: *</small>
            <input type="text" name="address_edit" id="address_edit" class="form-control form-control-sm" required value="{{ $collaborator->address }}">
            <small for="address_edit" class="text-muted">Actualmente es <b>{{ $collaborator->address }}</b></small>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <small for="phoneone_edit" class="text-muted">TELEFONO 1: *</small>
                <input type="number" name="phoneone_edit" id="phoneone_edit" class="form-control form-control-sm" required value="{{ $collaborator->phoneone }}">
                @if($collaborator->phoneone == '')
                <small for="phoneone_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small for="phoneone_edit" class="text-muted">Actualmente es <b>{{ $collaborator->phoneone }}</b></small>
                @endif
              </div>
              <div class="col-md-4">
                <small for="phonetwo_edit" class="text-muted">TELEFONO 2:</small>
                <input type="number" name="phonetwo_edit" id="phonetwo_edit" class="form-control form-control-sm" value="{{ $collaborator->phonetwo }}">
                @if($collaborator->phonetwo == '')
                <small for="phonetwo_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small for="phonetwo_edit" class="text-muted">Actualmente es <b>{{ $collaborator->phonetwo }}</b></small>
                @endif
              </div>
              <div class="col-md-4">
                <small for="whatsapp_edit" class="text-muted">WHATSAPP:</small>
                <input type="number" name="whatsapp_edit" id="whatsapp_edit" class="form-control form-control-sm" value="{{ $collaborator->whatsapp }}">
                @if($collaborator->whatsapp == '')
                <small for="whatsapp_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small for="whatsapp_edit" class="text-muted">Actualmente es <b>{{ $collaborator->whatsapp }}</b></small>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="emailone_edit" class="text-muted">CORREO ELECTRÓNICO 1: *</small>
            <input type="email" name="emailone_edit" id="emailone_edit" class="form-control form-control-sm" value="{{ $collaborator->emailone }}" required>
            @if($collaborator->emailone == '')
            <small for="emailone_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
            @else
            <small for="emailone_edit" class="text-muted">Actualmente es <b>{{ $collaborator->emailone }}</b></small>
            @endif
          </div>
          <div class="form-group">
            <small for="emailtwo_edit" class="text-muted">CORREO ELECTRÓNICO 2:</small>
            <input type="email" name="emailtwo_edit" id="emailtwo_edit" class="form-control form-control-sm" value="{{ $collaborator->emailtwo }}">
            @if($collaborator->emailtwo == '')
            <small for="emailtwo_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
            @else
            <small for="emailtwo_edit" class="text-muted">Actualmente es <b>{{ $collaborator->emailtwo }}</b></small>
            @endif
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 text-center">
                <small class="text-muted">FIRMA DIGITAL:</small>
                @if($collaborator->firm != null)
                <img src="{{ asset('storage/firms/'.$collaborator->firm) }}" class="img-thumbnail" alt="Foto" style="width: 150px; height: auto; text-align: center;">
                @else
                <h6 class="text-muted">SIN FIRMA DIGITAL</h6>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="custom-file">
                  <input type="file" name="firm_edit" lang="es" placeholder="Unicamente con extensión .jpg o .jpeg" accept="image/jpg,image/jpeg">
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6 text-center">
          <button type="submit" id="saveCollaborator" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIOS</button>
        </div>
        <div class="col-md-6 text-center">
          <div class="message-collaborator alert">
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

    var cityhome_id = $("select[name=cityhome_id_edit]").val();
    if (cityhome_id > 0) {
      fullSelectLocation(cityhome_id);
    }


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

  });

  function fullSelectLocation(value) {
    $.get("{{ route('edit.sublocation') }}", {
      cityhome_id: value
    }, function(locationObject) {
      var count = Object.keys(locationObject).length //total de localidades devueltas
      $('#locationhome_id_edit').empty();
      $('#locationhome_id_edit').append("<option value=''>Seleccione localidad...</option>");
      $('#districthome_id_edit').empty();
      $('#districthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
      var locationhome_id_hidden = $('#locationhome_id_hidden').val();
      for (var i = 0; i < count; i++) {
        if (locationhome_id_hidden != '') {
          if (locationhome_id_hidden == locationObject[i]['id']) {
            $('#locationhome_id_edit').append("<option value=" + locationObject[i]['id'] + " selected='selected'>" + locationObject[i]['name'] + "</option>");
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
              $('#dictricthome_id_edit').append("<option value=" + districtObject[i]['id'] + " selected='selected'>" + districtObject[i]['name'] + "</option>");
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
</script>
@endsection