@extends('modules.evaluation')

@section('academicModules')
<div class="col-md-12">
  <div class="row py-3 border-top border-bottom">
    <div class="col-md-6">
      <h4>BOLETINES ESCOLARES</h4>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de boletines escolares -->
      @if(session('SuccessSaveBulletin'))
      <div class="alert alert-success">
        {{ session('SuccessSaveBulletin') }}
      </div>
      @endif
      @if(session('SecondarySaveBulletin'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveBulletin') }}
      </div>
      @endif
    </div>
  </div>
  <div class="row py-3 border-top border-bottom">
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">ALUMNO:</small>
        <select name="pcStudent" class="form-control form-control-sm select2" required>
          <option value="">Seleccione un alumno...</option>
          @foreach($students as $student)
          @if ($student->status == 'ACTIVO')
          <option value="{{ $student->id }}">{{ $student->nameStudent }}</option>
          @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <small class="text-muted">PERIODO:</small>
        <select name="pcPeriod" class="form-control form-control-sm select2" required>
          <option value="">Seleccione un periodo...</option>
          <!-- Option dinamicos de seleccion del estudiante -->
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">NUMERO DE IDENTIFICACION:</small>
        <input type="text" name="infoIdStudent" class="form-control form-control-sm" disabled>
      </div>
      <div class="form-group">
        <small class="text-muted">CURSO:</small>
        <input type="hidden" name="infoIdCourse" class="form-control form-control-sm" disabled>
        <input type="text" name="infoNameCourse" class="form-control form-control-sm" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 p-4 d-flex justify-content-center">
      <div class="spinner-border" align="center" role="status">
        <span class="sr-only" align="center">Loading...</span>
      </div>
    </div>
  </div>
  <div class="row infoEmpty" style="display: none;">
    <div class="col-md-12 p-4 d-flex justify-content-center">
      <h5 style="color: red; font-weight: bold;">SIN OBSERVACIONES DE PERIODO</h5>
    </div>
  </div>
  <div class="row border-top mt-3 py-3 px-3 infoGeneral" style="display: none;">
    <div class="col-md-12 border" style="background: #DBDBDB;">
      <div class="row text-center">
        <div class="col-md-6 p-3">
          <h5><b>INFORMACION GENERAL DEL BOLETIN: </b></h5>
        </div>
        <div class="col-md-6 p-3">
          <form action="{{ route('bulletins.pdf') }}" method="GET">
            <input type="hidden" name="buStudent_id" class="form-control form-control-sm" readonly>
            <input type="hidden" name="buCourse_id" class="form-control form-control-sm" readonly>
            <input type="hidden" name="buPeriod_id" class="form-control form-control-sm" readonly>
            <button type="submit" class="btn btn-outline-tertiary  form-control-sm">
              DESCARGAR BOLETIN <i class="fas fa-file-pdf"></i>
            </button>
          </form>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12 tablesDetails">
          <!-- Here tables dinamics -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('.spinner-border').css('display', 'none');
  });

  $('select[name=pcStudent]').on('change', function(e) {
    var studentSelected = e.target.value;
    $('input[name=infoIdStudent]').val('');
    $('input[name=infoNameCourse]').val('');
    $('input[name=infoIdCourse]').val('');
    $('select[name=pcPeriod]').empty();
    $('select[name=pcPeriod]').append("<option value=''>Seleccione un periodo...</option>");
    $('.infoGeneral').css('display', 'none');
    $('.infoEmpty').css('display', 'none');
    $('.spinner-border').css('display', 'none');
    if (studentSelected != '') {
      $.get("{{ route('getInfoBasicStudentPeriodClosing') }}", {
        studentSelected: studentSelected
      }, function(response) {
        var count = Object.keys(response).length;
        if (count > 0) {
          $('input[name=infoIdStudent]').val(response[0]['documentStudent']);
          $('input[name=infoNameCourse]').val(response[0]['nameCourse']);
          $('input[name=infoIdCourse]').val(response[0]['idCourse']);
          for (var i = 0; i < count; i++) {
            $('select[name=pcPeriod]').append('<option value=' + response[i]['apId'] + '>' + response[i]['apNameperiod'] + '</option>');
          }
        }
      });
    }
  });

  $('select[name=pcPeriod]').on('change', function(e) {
    var periodSelected = e.target.value;
    var courseSelected = $('input[name=infoIdCourse]').val();
    var studentSelected = $('select[name=pcStudent] option:selected').val();
    $('.tablesDetails').empty();
    $('.infoGeneral').css('display', 'none');
    $('.spinner-border').css('display', 'flex');
    $('.infoEmpty').css('display', 'none');
    if (periodSelected != '' && studentSelected != '') {
      $('input[name=pcPeriod]').val(periodSelected);
      $.get("{{ route('getObservationsBulletin') }}", {
        periodSelected: periodSelected,
        studentSelected: studentSelected,
        courseSelected: courseSelected
      }, function(objectObservations) {
        if (objectObservations != 'N/A') {
          var count = Object.keys(objectObservations).length;
          var contentAll = '';
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              var contentIntelligence = '';
              if (objectObservations[i][2] != 'N/A') {
                for (var r = 0; r < objectObservations[i][2].length; r++) {
                  contentIntelligence += "<tr>" +
                    "<td class='text-center'>" + objectObservations[i][2][r][0] + "</td>" +
                    "<td class='text-center'>" + objectObservations[i][2][r][1] + "</td>" +
                    "</tr>";
                }
              } else {
                contentIntelligence += "<tr>" +
                  "<td colspan='2' class='text-center'>SIN OBSERVACIONES</td>" +
                  "</tr>";
              }

              contentAll += "<table class='table table-bordered mt-3' width='100%' style='background: #FFFFFF;' data-intelligence='" + objectObservations[i][0] + "'>" +
                "<thead>" +
                "<tr>" +
                "<th colspan='2' class='text-center'>" + objectObservations[i][1] + "</th>" +
                "</tr>" +
                "<tr>" +
                "<th class='text-center'>NUMERO</th>" +
                "<th class='text-center'>OBSERVACION</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody>" +
                "<tr>" +
                contentIntelligence +
                "</tr>" +
                "</tbody>" +
                "</table>";
            }
            $('input[name=buCourse_id]').val(courseSelected);
            $('input[name=buPeriod_id]').val(periodSelected);
            $('input[name=buStudent_id]').val(studentSelected);
            $('.tablesDetails').append(contentAll);
            $('.infoGeneral').css('display', 'flex');
            $('.spinner-border').css('display', 'none');
          }
        } else {
          $('.spinner-border').css('display', 'none');
          $('.infoEmpty').css('display', 'flex');
          setTimeout(function() {
            $('.infoEmpty').css('display', 'none');
          }, 3000);
        }

      });
    }
  });
</script>
@endsection