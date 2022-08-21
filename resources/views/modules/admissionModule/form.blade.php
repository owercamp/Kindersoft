@extends('admissions')

@section('modulesAdmission')
<div class="row p-4">
  <div class="col-md-12">
    <div class="row text-center" style="font-size: 13px;">
      <div class="col-md-12">
        @if(session('SuccessAdmission'))
        <div class="alert alert-success">
          {{ session('SuccessAdmission') }}
        </div>
        @endif
        @if(session('SecondaryAdmission'))
        <div class="alert alert-secondary">
          {{ session('SecondaryAdmission') }}
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr>
        <form action="{{ route('list.documents.pdf') }}" method="GET" style="display: inline-block;">
          @csrf
          <input type="hidden" name="eventList" value="list" class="form-control form-control-sm" required>
          <button type="submit" title="DESCARGAR PDF" class="btn btn-outline-danger form-control-sm">
            <i class="fas fa-file-pdf"></i> LISTADO DE DOCUMENTOS
          </button>
        </form>
        <form action="{{ route('saveauthAdmission') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row p-2">
            <div class="col-md-10 d-flex flex-column align-items-center">
              <h4 style="color: #1200FF; text-shadow: 1px 1px 1px #000000;">FORMULARIO DE MATRICULA</h4>
              <h5 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">ADMISION</h5>
              @if(config('app.name') == "Dream Home By Creatyvia")
              <h6 style="color: #1200FF;">Año lectivo {{ (date('m') >= 07 ? date('Y') : date('Y') - 1) }} - {{ (date('m') >= 07 ? date('Y') + 1 : date('Y') )}}</h6>
              <input type="hidden" aria-hidden="true" name="school_period" value="{{ (date('m') >= 07 ? date('Y') : date('Y') - 1) }} - {{ (date('m') >= 07 ? date('Y') + 1 : date('Y') )}}">
              <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO B</h6>
              @elseif(config('app.name') == "Colchildren Kindergarten")
              <h6 style="color: #1200FF;">Año lectivo {{ date('Y') + 1 }}</h6>
              <input type="hidden" aria-hidden="true" name="school_period" value="{{ date('Y') + 1 }}">
              <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO A</h6>
              @endif
            </div>
            <div class="col-md-2 text-center d-flex flex-column justify-content-center align-items-center">
              <div class="row sectionPhoto">
                <div class="col-md-12 text-center border d-flex flex-column justify-content-center align-items-center" style="width: 150px; height: 150px; overflow: hidden;">
                  <small class="text-muted text-center titlePhoto">Seleccione fotografía</small>
                  <img hidden src="" id="previewPhoto" style="width: 100%; height: auto;" required>
                </div>
              </div>
              <div class="row text-center">
                <input type="file" id="photoSelected" name="photo" lang="es" placeholder="Unicamente con extensión jpeg " accept="image/jpeg" required>
              </div>
            </div>
          </div>
          <hr>
          @include('modules.admissionModule.partial.formPartial')
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('.alert-message').css('display', 'none');
  });

  $('.btn-again').on('click', function(e) {
    e.preventDefault();
    location.reload();
  });

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

  $('.btn-sendform').on('click', function(e) {
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

  function existe(año, mes, dia) {
    let fecha = new Date(año, mes, '0');
    return mes > 0 && mes < 13 && año > 0 && año < 32768 && dia > 0 && dia <= (new Date(año, mes, 0)).getDate();
  }
</script>
@endsection