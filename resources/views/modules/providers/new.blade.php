@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">REGISTRAR NUEVO PROVEEDOR</h6>
        @if(count($errors) > 0)
        <div class="messageProvider alert alert-danger">
          @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif
        @if(session('SuccessSaveProvider'))
        <div class="alert alert-success">
          {{ session('SuccessSaveProvider') }}
        </div>
        @endif
        @if(session('SecondarySaveProvider'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveProvider') }}
        </div>
        @endif
      </div>
      <div class="col-md-6">
        <a href="{{ route('providers') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formNewProvider" action="{{ route('provider.save') }}" method="POST">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <small class="text-muted">TIPO DE DOCUMENTO: *</small>
            <select class="form-control form-control-sm select2" name="typedocument_id" id="typedocument_id" required value="{{ old('typedocument_id') }}">
              <option value="">Seleccione tipo...</option>
              @foreach($documents as $document)
              <option value="{{ $document->id }}">{{ $document->type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO: *</small>
                <input type="number" name="numberdocument" class="form-control form-control-sm" required value="{{ old('numberdocument') }}">
              </div>
              <div class="col-md-6">
                <small class="text-muted">CODIGO DE VERIFICACION:</small>
                <input type="number" name="numbercheck" id="numbercheck" class="form-control form-control-sm" required value="{{ old('numbercheck') }}" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">RAZON SOCIAL: *</small>
            <input type="text" name="namecompany" class="form-control form-control-sm" required value="{{ old('namecompany') }}">
          </div>

        </div><!-- fin panel izquierdo 1 -->

        <div class="col-md-6 border-left">
          <div class="form-group">
            <small class="text-muted">CIUDAD: *</small>
            <select class="form-control form-control-sm select2" id="cityhome_id" name="cityhome_id" required value="{{ old('cityhome_id') }}">
              <option value="">Seleccione ciudad...</option>
              @foreach($citys as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">LOCALIDAD: *</small>
                <select class="form-control form-control-sm select2" id="locationhome_id" name="locationhome_id" value="{{ old('locationhome_id') }}" required>
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO: *</small>
                <select class="form-control form-control-sm select2" id="dictricthome_id" name="dictricthome_id" value="{{ old('dictricthome_id') }}" required>
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">DIRECCIÓN: *</small>
            <input type="text" name="address" class="form-control form-control-sm" required value="{{ old('address') }}">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <small class="text-muted">TELEFONO 1: *</small>
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

      </div><!-- Fin de fila -->

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
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6 text-center">
          <button type="submit" class="btn btn-outline-success form-control-sm">GUARDAR PROVEEDOR</button>
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

    $('#typedocument_id').on('change', function() {
      var typedocument = $('#typedocument_id option:selected').text();
      if (typedocument == 'NIT') {
        $('#numbercheck').attr('readonly', false);
        $('#numbercheck').attr('required', true);
      } else {
        $('#numbercheck').attr('readonly', true);
        $('#numbercheck').attr('required', false);
        $('#numbercheck').val('');
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
  });
</script>

@endsection