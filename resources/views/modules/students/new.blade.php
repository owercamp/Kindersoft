@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">REGISTRAR NUEVO ALUMNO/A</h6>
        @if(count($errors) > 0)
        <div class="messageStudent alert alert-danger">
          @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif
        @if(session('SuccessSaveStudent'))
        <div class="alert alert-success">
          {{ session('SuccessSaveStudent') }}
        </div>
        @endif
        @if(session('SecondarySaveStudent'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveStudent') }}
        </div>
        @endif
      </div>
      <div class="col-md-6">
        <a href="{{ route('students') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formNewStudent" action="{{ route('student.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="typedocument_id" class="text-muted">TIPO DE DOCUMENTO:</small>
                <select class="form-control form-control-sm select2" name="typedocument_id" required value="{{ old('typedocument_id') }}">
                  <option value="">Seleccione tipo...</option>
                  @foreach($documents as $document)
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small for="numberdocument" class="text-muted">NÚMERO DE DOCUMENTO:</small>
                <input type="number" name="numberdocument" class="form-control form-control-sm" required value="{{ old('numberdocument') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">FOTO ALUMNO:</small>
                <div class="custom-file">
                  <input type="file" name="photo" lang="es" placeholder="Unicamente con extensión .jpg .jpeg o .png" accept="image/jpg,image/jpeg,image/png">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small for="firstname" class="text-muted">NOMBRES:</small>
                <input type="text" name="firstname" class="form-control form-control-sm" required value="{{ old('firstname') }}">
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
                <small for="bloodtype_id" class="text-muted">TIPO DE SANGRE:</small>
                <select class="form-control form-control-sm select2" name="bloodtype_id" required value="{{ old('bloodtype_id') }}">
                  <option value="">Seleccione grupo...</option>
                  @foreach($bloodtypes as $bloodtype)
                  <option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small for="gender" class="text-muted">GENERO:</small>
                <select class="form-control form-control-sm select2" name="gender" required value="{{ old('gender') }}">
                  <option value="">Seleccione genero...</option>
                  <option value="MASCULINO">MASCULINO</option>
                  <option value="FEMENINO">FEMENINO</option>
                  <option value="INDEFINIDO">INDEFINIDO</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="birthdate" class="text-muted">FECHA DE NACIMIENTO:</small>
                <input type="text" id="birthdate" name="birthdate" class="form-control form-control-sm datepicker" required>
              </div>
              <div class="col-md-3">
                <small for="yearsold" class="text-muted">AÑO/S:</small>
                <input type="text" name="yearsold" id="yearsold" class="form-control form-control-sm" required readonly>
              </div>
              <div class="col-md-3">
                <small for="monthold" class="text-muted">MES/ES:</small>
                <input type="text" name="monthold" id="monthold" class="form-control form-control-sm" required readonly>
              </div>
            </div>
          </div>
        </div><!-- fin panel izquierdo 1 -->


        <div class="col-md-6 border-left">
          <div class="form-group">
            <small for="cityhome_id" class="text-muted">CIUDAD:</small>
            <select class="form-control form-control-sm select2" id="cityhome_id" name="cityhome_id" required value="{{ old('cityhome_id') }}">
              <option value="">Seleccione una ciudad...</option>
              @foreach($citys as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small for="locationhome_id" class="text-muted">LOCALIDAD:</small>
                <select class="form-control form-control-sm select2" id="locationhome_id" name="locationhome_id" value="{{ old('locationhome_id') }}" required>
                  <option value="">Seleccione una localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small for="dictricthome_id" class="text-muted">BARRIO:</small>
                <select class="form-control form-control-sm select2" id="dictricthome_id" name="dictricthome_id" value="{{ old('dictricthome_id') }}" required>
                  <option value="">Seleccione un barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small for="address" class="text-muted">DIRECCIÓN:</small>
            <input type="text" name="address" class="form-control form-control-sm" value="{{ old('address') }}" required>
          </div>
          <div class="form-group">
            <small for="health_id" class="text-muted">TIPO DE AFILIACIÓN A SALUD:</small>
            <select class="form-control form-control-sm select2" name="health_id" value="{{ old('health_id') }}" required>
              <option value="">Seleccione centro de salud...</option>
              @foreach($healths as $health)
              <option value="{{ $health->id }}">{{ $health->entity }} - {{ $health->type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <small for="additionalHealt" class="text-muted">¿SALUD ADICIONAL?</small>
            <select class="form-control form-control-sm select2" id="additionalHealt" name="additionalHealt" value="{{ old('additionalHealt') }}" required>
              <option value="">Seleccione...</option>
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
          </div>
        </div><!-- Fin panel derecho 1 -->


      </div><!-- Fin de fila -->
      <div class="row border-top border-bottom">
        <div class="col-md-12 form-group">
          <small for="additionalHealtDescription" class="text-muted">DESCRIBA LA SALUD ADICIONAL QUE TIENE EL ESTUDIANTE:</small>
          <textarea class="form-control form-control-sm" id="additionalHealtDescription" name="additionalHealtDescription" readonly></textarea>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6 text-center">
          <button type="submit" class="btn btn-outline-success form-control-sm">GUARDAR ESTUDIANTE</button>
        </div>
        <div class="col-md-6 text-center">
          <div class="alert message"></div>
        </div>
      </div>

    </div>
  </form>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function() {

    $("#additionalHealt").on("change", function(e) {
      var value = e.target.value;
      if (value == 'NO' || value == '') {
        $('#additionalHealtDescription').attr('readonly', true);
        $('#additionalHealtDescription').val('');
      } else {
        $('#additionalHealtDescription').attr('readonly', false);
      }
    });

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

    $('#birthdate').on('change', function() {
      calculateBirthdate($('#birthdate').val());
    });

    $('#additionalHealt').on('change', function(e) {
      var selected = e.target.value;
      console.log(selected);
      if (selected == 'SI') {
        $('#additionalHealtDescription').attr('disable', false);
      } else {
        $('#additionalHealtDescription').attr('disable', 'disable');
      }
    });

  });

  function calculateBirthdate(date) {
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
      $('#yearsold').val(old);
      $('#monthold').val(mounts);
      //$('#dayold').val(days); //Opcional para mostrar dias también
    } else {
      console.log("La fecha " + date + " es incorrecta");
    }
  }
</script>
@endsection