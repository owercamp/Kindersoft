@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">REGISTRAR NUEVO ACUDIENTE</h6>
        @if(count($errors) > 0)
        <div class="messageAttendant alert alert-secondary">
          @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif
        @if(session('SuccessSaveAttendant'))
        <div class="alert alert-success">
          {{ session('SuccessSaveAttendant') }}
        </div>
        @endif
        @if(session('SecondarySaveAttendant'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveAttendant') }}
        </div>
        @endif
      </div>
      <div class="col-md-6">
        <a href="{{ route('attendants') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formNewAttendant" action="{{ route('attendant.save') }}" method="POST">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE DOCUMENTO: *</small>
                <select class="form-control form-control-sm select2" name="typedocument_id" required value="{{ old('typedocument_id') }}">
                  <option value="">Seleccione tipo...</option>
                  @foreach($documents as $document)
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO:</small>
                <input type="number" name="numberdocument" class="form-control form-control-sm" required value="{{ old('numberdocument') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">NOMBRE/S:</small>
                <input type="text" name="firstname" class="form-control form-control-sm" required value="{{ old('firstname') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">APELLIDO/S:</small>
                <input type="text" name="threename" class="form-control form-control-sm" required value="{{ old('threename') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE SANGRE:</small>
                <select class="form-control form-control-sm select2" name="bloodtype_id" required value="{{ old('bloodtype_id') }}">
                  <option value="">Seleccione grupo...</option>
                  @foreach($bloodtypes as $bloodtype)
                  <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">GENERO:</small>
                <select class="form-control form-control-sm select2" name="gender" required value="{{ old('gender') }}">
                  <option value="">Seleccione genero...</option>
                  <option value="MASCULINO">MASCULINO</option>
                  <option value="FEMENINO">FEMENINO</option>
                  <option value="INDEFINIDO">INDEFINIDO</option>
                </select>
              </div>
            </div>
          </div>
        </div><!-- fin panel izquierdo 1 -->


        <div class="col-md-6 border-left">
          <div class="form-group">
            <small class="text-muted">CIUDAD:</small>
            <select id="cityhome_id" class="form-control form-control-sm select2" name="cityhome_id" required value="{{ old('cityhome_id') }}">
              <option value="">Seleccione ciudad...</option>
              @foreach($citys as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">LOCALIDAD:</small>
                <select id="locationhome_id" class="form-control form-control-sm select2" name="locationhome_id" required value="{{ old('locationhome_id') }}">
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO:</small>
                <select id="dictricthome_id" class="form-control form-control-sm select2" name="dictricthome_id" required value="{{ old('dictricthome_id') }}">
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">DIRECCIÓN:</small>
            <input type="text" name="address" id="address" class="form-control form-control-sm" required value="{{ old('address') }}">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <small class="text-muted">TELEFONO 1:</small>
                <input type="number" name="phoneone" class="form-control form-control-sm" required value="{{ old('phoneone') }}">
              </div>
              <div class="col-md-4">
                <small class="text-muted">TELEFONO 2:</small>
                <input type="number" name="phonetwo" class="form-control form-control-sm" value="{{ old('phonetwo') }}">
              </div>
              <div class="col-md-4">
                <small class="text-muted">WHATSAPP:</small>
                <input type="number" name="whatsapp" class="form-control form-control-sm" value="{{ old('whatsapp') }}">
              </div>
            </div>
          </div>
        </div><!-- Fin panel derecho 1 -->

      </div>
      <div class="row border-top border-bottom">
        <div class="col-md-12">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">CORREO ELECTRÓNICO 1: *</small>
                <input type="email" name="emailone" class="form-control form-control-sm" required value="{{ old('emailone') }}">
              </div>
              <div class="col-md-6">
                <small class="text-muted">CORREO ELECTRÓNICO 2:</small>
                <input type="email" name="emailtwo" class="form-control form-control-sm" value="{{ old('emailtwo') }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top">
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">PROFESION: *</small>
            <select class="form-control form-control-sm select2" name="profession_id" required value="{{ old('profession_id') }}">
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
                <input type="text" name="position" class="form-control form-control-sm" value="{{ old('position') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">FECHA DE INICIO:</small>
                <input type="text" name="antiquity" class="form-control form-control-sm datepicker" value="{{ old('antiquity') }}">
              </div>
              <div class="col-md-6">
                <small class="text-muted">ANTIGUEDAD EN AÑOS:</small>
                <input type="text" name="antiquity_years" class="form-control form-control-sm text-center" value="0" disabled>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">EMPRESA DONDE LABORA:</small>
            <input type="text" name="company" class="form-control form-control-sm" value="{{ old('company') }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">CIUDAD DE EMPRESA: *</small>
            <select id="citycompany_id" class="form-control form-control-sm select2" name="citycompany_id" required value="{{ old('citycompany_id') }}">
              <option value="">Seleccione ciudad...</option>
              @foreach($citys as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">LOCALIDAD DE EMPRESA:</small>
                <select id="locationcompany_id" class="form-control form-control-sm select2" name="locationcompany_id" value="{{ old('locationcompany_id') }}">
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO DE EMPRESA:</small>
                <select id="dictrictcompany_id" class="form-control form-control-sm select2" name="dictrictcompany_id" value="{{ old('dictrictcompany_id') }}">
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">DIRECCIÓN DE EMPRESA:</small>
            <input type="text" name="addresscompany" class="form-control form-control-sm" value="{{ old('addresscompany') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6 text-center">
          <button id="saveAttendant" type="submit" class="btn btn-outline-success form-control-sm">GUARDAR ACUDIENTE</button>
        </div>
        <div class="col-md-6 text-center">
          <div class="messageAttendant alert"></div>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
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
  $("#citycompany_id").on("change", function(e) {
    var citycompany_id = e.target.value;
    $.get("{{ route('edit.sublocation') }}", {
      cityhome_id: citycompany_id
    }, function(locationObject) {
      var count = Object.keys(locationObject).length //total de localidades devueltas
      $('#locationcompany_id').empty();
      $('#locationcompany_id').append("<option value=''>Seleccione localidad...</option>");
      $('#dictrictcompany_id').empty();
      $('#dictrictcompany_id').append("<option value=''>Seleccione barrio...</option>");
      for (var i = 0; i < count; i++) {
        $('#locationcompany_id').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
      }
    });
  });
  $("#locationcompany_id").on("change", function(e) {
    var locationcompany_id = e.target.value;
    $.get("{{ route('edit.subdistrict') }}", {
      locationhome_id: locationcompany_id
    }, function(districtObject) {
      var count = Object.keys(districtObject).length //total de barrios devueltos
      $('#dictrictcompany_id').empty();
      $('#dictrictcompany_id').append("<option value=''>Seleccione barrio...</option>");
      for (var i = 0; i < count; i++) {
        $('#dictrictcompany_id').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
      }
    });
  });
  $('input[name=antiquity]').on('change', function() {
    calculateYears($(this).val());
  });

  function calculateYears(date) {
    if (date != '') {
      var values = date.split("/");
      var day = values[2];
      var mount = values[1];
      var year = values[0];
      var now = new Date();
      var yearNow = now.getYear()
      var mountNow = now.getMonth() + 1;
      var dayNow = now.getDate();
      //Cálculo de años
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
      //Cálculo de meses
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
      //Cálculo de dias
      var days = 0;
      if (dayNow > day) {
        days = dayNow - day
      }
      if (dayNow < day) {
        lastDayMount = new Date(yearNow, mountNow, 0);
        days = lastDayMount.getDate() - (day - dayNow);
      }
      $('input[name=antiquity_years]').val(old);
      //$('input[name=antiquity_years]').val(mounts);
      //$('#dayold').val(days); //Opcional para mostrar dias también
    } else {
      console.log("La fecha " + date + " es incorrecta");
    }
  }
</script>
@endsection