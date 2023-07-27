@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">MODIFICACION DE PROVEEDOR: <b>{{ $provider->namecompany }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('providers') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formProviderUpdate" action="{{ route('provider.update', $provider->id) }}" method="POST">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">

        <div class="col-md-6 border-right">
          <div class="form-group">
            <small class="text-muted">TIPO DE DOCUMENTO: *</small>
            <select class="form-control form-control-sm" name="typedocument_id_edit" id="typedocument_id_edit" required>
              <option value="">Seleccione tipo...</option>
              @php $namedocument = '' @endphp
              @foreach($documents as $document)
              @if($document->id == $provider->typedocument_id)
              @php $namedocument = $document->type @endphp
              <option value="{{ $document->id }}" selected>{{ $document->type }}</option>
              @else
              <option value="{{ $document->id }}">{{ $document->type }}</option>
              @endif
              @endforeach
            </select>
            <small class="text-muted">Actualmente es <b>{{ $namedocument }}</b></small>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO: *</small>
                <input type="text" pattern="[0-9]{1,12}" name="numberdocument_edit" class="form-control form-control-sm" value="{{ $provider->numberdocument }}" required>
                <small class="text-muted">Actualmente es <b>{{ $provider->numberdocument }}</b></small>
              </div>
              <div class="col-md-6">
                <small class="text-muted">CODIGO DE VERIFICACIÓN: </small>
                <input type="hidden" id="numbercheck_hidden" value="{{ $provider->numbercheck }}">
                <input type="text" name="numbercheck_edit" id="numbercheck_edit" class="form-control form-control-sm" value="{{ $provider->numbercheck }}" readonly>
                @if($provider->numbercheck == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $provider->numbercheck }}</b></small>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">RAZON SOCIAL: *</small>
            <input type="text" name="namecompany_edit" class="form-control form-control-sm" value="{{ $provider->namecompany }}" required>
            <small class="text-muted">Actualmente es <b>{{ $provider->namecompany }}</b></small>
          </div>
        </div><!-- Fin panel izquierdo superior -->

        <div class="col-md-6 border-left">
          <div class="form-group">
            <small class="text-muted">CIUDAD: *</small>
            <select class="form-control form-control-sm" id="cityhome_id_edit" name="cityhome_id_edit" required="required">
              <option value="">Seleccione ciudad...</option>
              @php $namecity = '' @endphp
              @foreach($citys as $city)
              @if($city->id == $provider->cityhome_id)
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
                <small class="text-muted">LOCALIDAD: *</small>
                <input type="hidden" id="locationhome_id_hidden" value="{{ $provider->locationhome_id }}">
                <select class="form-control form-control-sm" id="locationhome_id_edit" name="locationhome_id_edit" required>
                  <option value="">Seleccione localidad...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">BARRIO: *</small>
                <input type="hidden" id="dictricthome_id_hidden" value="{{ $provider->dictricthome_id }}">
                <select class="form-control form-control-sm" id="dictricthome_id_edit" name="dictricthome_id_edit" required>
                  <option value="">Seleccione barrio...</option>
                  <!-- Options dinamics -->
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">DIRECCIÓN: *</small>
            <input type="text" name="address_edit" class="form-control form-control-sm" required value="{{ $provider->address }}">
            <small class="text-muted">Actualmente es <b>{{ $provider->address }}</b></small>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <small class="text-muted">TELEFONO 1: *</small>
                <input type="number" name="phoneone_edit" class="form-control form-control-sm" required value="{{ $provider->phoneone }}">
                <small class="text-muted">Actualmente es <b>{{ $provider->phoneone }}</b></small>
              </div>
              <div class="col-md-4">
                <small class="text-muted">TELEFONO 2:</small>
                <input type="number" name="phonetwo_edit" class="form-control form-control-sm" value="{{ $provider->phonetwo }}">
                @if($provider->phonetwo == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $provider->phonetwo }}</b></small>
                @endif
              </div>
              <div class="col-md-4">
                <small class="text-muted">WHATSAPP:</small>
                <input type="number" name="whatsapp_edit" class="form-control form-control-sm" value="{{ $provider->whatsapp }}">
                @if($provider->whatsapp == '')
                <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
                @else
                <small class="text-muted">Actualmente es <b>{{ $provider->whatsapp }}</b></small>
                @endif
              </div>
            </div>
          </div>
        </div><!-- Fin panel derecho superior -->
      </div>

      <div class="row border-top">
        <div class="col-md-12 form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">CORREO ELECTRÓNICO 1: *</small>
              <input type="email" name="emailone_edit" class="form-control form-control-sm" value="{{ $provider->emailone }}" required>
              @if($provider->emailone == '')
              <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
              @else
              <small class="text-muted">Actualmente es <b>{{ $provider->emailone }}</b></small>
              @endif
            </div>
            <div class="col-md-6">
              <small class="text-muted">CORREO ELECTRÓNICO 2:</small>
              <input type="email" name="emailtwo_edit" class="form-control form-control-sm" value="{{ $provider->emailtwo }}">
              @if($provider->emailtwo == '')
              <small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
              @else
              <small class="text-muted">Actualmente es <b>{{ $provider->emailtwo }}</b></small>
              @endif
            </div>
          </div>
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

    var typedocument_selected = $('#typedocument_id_edit option:selected').text();
    console.log(typedocument_selected);
    if (typedocument_selected == 'NIT') {
      $('#numbercheck_edit').attr('readonly', false);
      $('#numbercheck_edit').val($('#numbercheck_hidden').val());
    } else {
      $('#numbercheck_edit').attr('readonly', true);
      $('#numbercheck_edit').val('');
    }

    $('#typedocument_id_edit').on('change', function() {
      var typedocument = $('#typedocument_id_edit option:selected').text();
      if (typedocument == 'NIT') {
        $('#numbercheck_edit').attr('readonly', false);
        $('#numbercheck_edit').attr('required', true);
        $('#numbercheck_edit').val($('#numbercheck_hidden').val());
      } else {
        $('#numbercheck_edit').attr('readonly', true);
        $('#numbercheck_edit').attr('required', false);
        $('#numbercheck_edit').val('');
      }
    });

    var cityhome_id = $("select[name=cityhome_id_edit]").val();
    if (cityhome_id > 0) {
      fullSelectHome(cityhome_id);
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
</script>
@endsection