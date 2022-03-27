@extends('modules.services')

@section('services')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">MODIFICACION DE JORNADA: <b>{{ $journey->jouJourney }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('journeys') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formJourneyUpdate" action="{{ route('journey.update', $journey->id) }}" method="POST">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-4 border-right">
          <div class="form-group">
            <div class="form-group">
              <small class="text-muted">NOMBRE/JORNADA:</small>
              <input type="text" name="jouJourney" class="form-control form-control-sm" value="{{ $journey->jouJourney }}" required>
              <small class="text-muted">Actualmente es <b>{{ $journey->jouJourney }}</b></small>
            </div>
            <div class="form-group justify-content-center" id="divBtn">
              <small class="text-muted">DIAS:</small>
              <a href="#" id="btn-addSelect" class="btn btn-outline-primary form-control-sm" title="AGREGAR DIA"><i class="fas fa-plus"></i></a>
              <a href="#" id="btn-remSelect" class="btn btn-outline-tertiary  form-control-sm" title="QUITAR DIA"><i class="fas fa-minus"></i></a>
            </div>
            <div class="form-group justify-content-center">
              <small class="text-muted">Actualmente es <b>{{ $journey->jouDays }}</b></small>
            </div>
            <input type="hidden" id="fullDays" name="fullDays" value="{{ $journey->jouDays }}" required>
            <div id="divSelects" class="form-group justify-content-center">
              <select class="form-control form-control-sm select2 my-2 jouDays" name="jouDays[]" required>
                <option value="">Seleccione dia...</option>
                <option value="LUNES">LUNES</option>
                <option value="MARTES">MARTES</option>
                <option value="MIERCOLES">MIERCOLES</option>
                <option value="JUEVES">JUEVES</option>
                <option value="VIERNES">VIERNES</option>
                <option value="SABADO">SABADO</option>
                <option value="DOMINGO">DOMINGO</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <small class="text-muted">HORA DE ENTRADA:</small>
            <input type="time" name="jouHourEntry" class="form-control form-control-sm" value="{{ $journey->jouHourEntry }}">
            <small class="text-muted">Actualmente es <b>{{ $journey->jouHourEntry }}</b></small>
          </div>
          <div class="form-group">
            <small class="text-muted">HORA DE SALIDA:</small>
            <input type="time" name="jouHourExit" class="form-control form-control-sm" value="{{ $journey->jouHourExit }}">
            <small class="text-muted">Actualmente es <b>{{ $journey->jouHourExit }}</b></small>
          </div>
        </div>

        <div class="col-md-4 border-left">
          <div class="form-group">
            <small class="text-muted">VALOR:</small>
            <input type="number" name="jouValue" class="form-control form-control-sm" value="{{ $journey->jouValue }}">
            <small class="text-muted">Actualmente es <b>{{ $journey->jouValue }}</b></small>
          </div>
          <div class="form-group">
            <button id="saveJourney" type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIOS</button>
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

    var days = $('#fullDays').val();

    var valuesDays = days.split(' - ');

    for (var i = 0; i < valuesDays.length; i++) {
      if (i == 0) {
        $(".jouDays:last option[value=" + valuesDays[i] + "]").attr("selected", true);
      } else {
        var select = $('.jouDays:first').clone();
        $('#divSelects').append(select);
        $(".jouDays:last option[value=" + valuesDays[i] + "]").attr("selected", true);
      }
    }

    $('#btn-addSelect').on('click', function() {
      var select = $('.jouDays:first').clone();
      $('#divSelects').append(select);
    });

    $('#btn-remSelect').on('click', function() {
      var count = $('.jouDays').length;
      if (count > 1) {
        $('.jouDays:last').remove();
        setSelects();
      }
    });

    $('#divSelects').on('change', '.jouDays', function() {
      setSelects();
    });
  });

  function setSelects() {
    var days = [].map.call($('.jouDays'), function(input) {
      return input.value;
    }).join(' - ');
    $('#fullDays').val('');
    $('#fullDays').val(days);
  }
</script>
@endsection