@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">REGISTRAR NUEVO COLABORADOR</h6>
        @if(count($errors) > 0)
        <div class="alert alert-secondary">
          @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif
        @if(session('SuccessSaveCollaborator'))
        <div class="alert alert-success">
          {{ session('SuccessSaveCollaborator') }}
        </div>
        @endif
        @if(session('SecondarySaveCollaborator'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveCollaborator') }}
        </div>
        @endif
      </div>
      <div class="col-md-6">
        <a href="{{ route('collaborators') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formCollaboratorNew" action="{{ route('collaborator.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="typedocument_id" class="text-muted">TIPO DE DOCUMENTO: *</small>
                <select class="form-control form-control-sm select2" name="typedocument_id" required>
                  <option value="">Seleccione tipo...</option>
                  @foreach($documents as $document)
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small for="numberdocument" class="text-muted">NÚMERO DE DOCUMENTO: *</small>
                <input type="number" name="numberdocument" class="form-control form-control-sm" required value="{{ old('numberdocument') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small for="firstname" class="text-muted">NOMBRES: *</small>
                <input type="text" name="firstname" class="form-control form-control-sm" required value="{{ old('firstname') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">FOTOGRAFIA:</small>
                <div class="custom-file">
                  <input type="file" name="photo" lang="es" placeholder="Unicamente con extensión .jpg o .jpeg" accept="image/jpg,image/jpeg">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="threename" class="text-muted">PRIMER APELLIDO: *</small>
                <input type="text" name="threename" class="form-control form-control-sm" required value="{{ old('threename') }}">
              </div>
              <div class="col-md-6">
                <small for="fourname" class="text-muted">SEGUNDO APELLIDO: *</small>
                <input type="text" name="fourname" class="form-control form-control-sm" required value="{{ old('fourname') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="bloodtype_id" class="text-muted">TIPO DE SANGRE: *</small>
                <select class="form-control form-control-sm select2" name="bloodtype_id" required>
                  <option value="">Seleccione grupo...</option>
                  @foreach($bloodtypes as $bloodtype)
                  <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small for="gender" class="text-muted">GENERO: *</small>
                <select class="form-control form-control-sm select2" name="gender" required>
                  <option value="">Seleccione genero...</option>
                  <option value="MASCULINO">MASCULINO</option>
                  <option value="FEMENINO">FEMENINO</option>
                  <option value="INDEFINIDO">INDEFINIDO</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="profession_id" class="text-muted">PROFESION: *</small>
            <select class="form-control form-control-sm select2" name="profession_id" required>
              <option value="">Seleccione profesión...</option>
              @foreach($professions as $profession)
              <option value="{{ $profession->id }}">{{ $profession->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">CARGO:</small>
                <div class="custom-file">
                  <input type="text" name="position" maxlength="30" class="form-control form-control-sm" required>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 border-left">
          <div class="form-group">
            <small for="cityhome_id" class="text-muted">CIUDAD: *</small>
            <select class="form-control form-control-sm select2" id="cityhome_id" name="cityhome_id" required>
              <option value="">Seleccione ciudad...</option>
              @foreach($citys as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="locationhome_id" class="text-muted">LOCALIDAD: *</small>
                <select class="form-control form-control-sm select2" id="locationhome_id" name="locationhome_id" required>
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small for="districthome_id" class="text-muted">BARRIO: *</small>
                <select class="form-control form-control-sm select2" id="dictricthome_id" name="dictricthome_id" required>
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="address" class="text-muted">DIRECCIÓN: *</small>
            <input type="text" name="address" class="form-control form-control-sm" required value="{{ old('address') }}">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <small for="phoneone" class="text-muted">TELEFONO 1: *</small>
                <input type="number" name="phoneone" class="form-control form-control-sm" required value="{{ old('phoneone') }}">
              </div>
              <div class="col-md-4">
                <small for="phonetwo" class="text-muted">TELEFONO 2:</small>
                <input type="number" name="phonetwo" class="form-control form-control-sm" value="{{ old('phonetwo') }}">
              </div>
              <div class="col-md-4">
                <small for="whatsapp" class="text-muted">WHATSAPP:</small>
                <input type="number" name="whatsapp" class="form-control form-control-sm" value="{{ old('whatsapp') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="emailone" class="text-muted">CORREO ELECTRÓNICO 1: *</small>
            <input type="email" name="emailone" class="form-control form-control-sm" required value="{{ old('emailone') }}">
          </div>
          <div class="form-group">
            <small for="emailtwo" class="text-muted">CORREO ELECTRÓNICO 2:</small>
            <input type="email" name="emailtwo" class="form-control form-control-sm" value="{{ old('emailtwo') }}">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">FIRMA DIGITAL:</small>
                <div class="custom-file">
                  <input type="file" name="firm" lang="es" placeholder="Unicamente con extensión .jpg .jpeg o .png" accept="image/jpg,image/jpeg,image/png">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <button type="submit" id="saveCollaborator" class="btn btn-outline-success form-control-sm">GUARDAR COLABORADOR</button>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $("#cityhome_id").on("change", function(e) {
      var cityhome_id = e.target.value;
      $.get("{{ route('edit.sublocation') }}", {
        cityhome_id: cityhome_id
      }, function(locationObject) {
        var count = Object.keys(locationObject).length //total de localidades devueltas
        $('#locationhome_id').empty();
        $('#locationhome_id').append("<option value=''>Seleccione localidad...</option>");
        $('#dictricthome_id').empty();
        $('#dictricthome_id').append("<option value=''>Seleccione barrio...</option>");
        for (var i = 0; i < count; i++) {
          $('#locationhome_id').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
        }
      });
    });
    $("#locationhome_id").on("change", function(e) {
      var locationhome_id = e.target.value;
      $.get("{{ route('edit.subdistrict') }}", {
        locationhome_id: locationhome_id
      }, function(districtObject) {
        var count = Object.keys(districtObject).length //total de barrios devueltos
        $('#dictricthome_id').empty();
        $('#dictricthome_id').append("<option value=''>Seleccione barrio...</option>");
        for (var i = 0; i < count; i++) {
          $('#dictricthome_id').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
        }
      });
    });
  });
</script>
@endsection