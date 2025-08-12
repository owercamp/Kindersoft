@extends('modules.dailynews')

@section('logisticModules')
<div class="col-md-12">
  <div class="row p-4">
    <div class="col-md-6">
      <h4>REPORTES DIARIOS</h4>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de resultado de generar PDF de reporte diario -->
      @if(session('SuccessReport'))
      <div class="alert alert-success" style="font-size: 12px;">
        {{ session('SuccessReport') }}
      </div>
      @endif
      @if(session('SecondaryReport'))
      <div class="alert alert-secondary msg-return" style="font-size: 12px;">
        {{ session('SecondaryReport') }}
      </div>
      @endif
    </div>
  </div>
  <div class="row p-3 border-bottom">
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">FECHA DE CONSULTA:</small>
        <input type="text" name="dateReport" class="text-center form-control form-control-sm datepicker">
      </div>
    </div>
    <div class="col-md-6 pt-4">
      <div class="form-group form-inline">
        <button type="button" class="btn btn-outline-success form-control-sm btn-seeDates">CONSULTAR</button>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-md-12 text-center">
      <div class="spinner-border" align="center" role="status">
        <span class="sr-only" align="center">Procesando...</span>
      </div>
    </div>
  </div>
  <hr>
  <div class="row border p-4 sectionResult" style="display: none;">
    <div class="col-md-12 p-4 text-center">
      <h4 class="titleReport" style="color: #000; font-weight: bold;">REPORTE DEL </h4>
      <form action="{{ route('reportDaily.pdf') }}" method="GET">
        @csrf
        <input type="hidden" name="date_report" class="form-control form-control-sm text-center" readonly required>
        <button type="submit" class="btn btn-outline-tertiary  form-control-sm">DESCARGAR PDF</button>
      </form>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION GENERAL DE ASISTENCIAS</h6>
      <table class="table text-center tbl-assistances" width="100%" style="font-size: 12px;">
        <thead>
          <th>CURSO</th>
          <th>ASISTENCIAS</th>
          <th>INASISTENCIAS</th>
          <th>ESTADO</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-assistances" style="display: none;">NO EXISTEN REGISTROS DE ASISTENCIA</div>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION GENERAL DE NOVEDADES</h6>
      <table class="table text-center tbl-news" width="100%" style="font-size: 12px;">
        <thead>
          <th>ALUMNO</th>
          <th>NOVEDAD</th>
          <th>CONCEPTO</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-news" style="display: none;">NO EXISTEN REGISTROS DE NOVEDADES</div>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION DE CONTROL DE ALIMENTACION</h6>
      <table class="table text-center tbl-feeding" width="100%" style="font-size: 12px;">
        <thead>
          <th>ALUMNO</th>
          <th>TIPO</th>
          <th>OBSERVACION</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-feeding" style="display: none;">NO EXISTEN REGISTROS DE ALIMENTACION</div>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION DE CONTROL DE ESFINTERES</h6>
      <table class="table text-center tbl-sphincters" width="100%" style="font-size: 12px;">
        <thead>
          <th>ALUMNO</th>
          <th>OBSERVACION</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-sphincter" style="display: none;">NO EXISTEN REGISTROS DE ESFINTERES</div>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION DE CONTROL DE ENFERMERIA</h6>
      <table class="table text-center tbl-healths" width="100%" style="font-size: 12px;">
        <thead>
          <th>ALUMNO</th>
          <th>OBSERVACION</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-healths" style="display: none;">NO EXISTEN REGISTROS DE ENFERMERIA</div>
      <hr style="height: 10px; width: 100%; background-color: #ccc; box-shadow: 1px 1px 1px 1px #000;">
      <h6>INFORMACION DE EVENTOS</h6>
      <table class="table text-center tbl-events" width="100%" style="font-size: 12px;">
        <thead>
          <th>TIPO DE EVENTO</th>
          <th>EVENTO</th>
          <th>OBSERVACION</th>
        </thead>
        <tbody>
          <!-- dinamics rows -->
        </tbody>
      </table>
      <div class="alert alert-warning text-center msg-events" style="display: none;">NO EXISTEN REGISTROS DE EVENTOS CERRADOS</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('.spinner-border').css('display', 'none');
  });

  $('.btn-seeDates').on('click', function() {
    $('.sectionResult').css('display', 'none');
    $('.spinner-border').css('display', 'block');
    var dateSelected = $('input[name=dateReport]').val();
    if (dateSelected != '') {
      $('input[name=date_report]').val(dateSelected);
      $('.titleReport').text('REPORTE DEL ' + converterDateToString(dateSelected));
      $('.tbl-assistances tbody').empty();
      $('.tbl-news tbody').empty();
      $('.tbl-feeding tbody').empty();
      $('.tbl-sphincters tbody').empty();
      $('.tbl-healths tbody').empty();
      $('.tbl-events tbody').empty();
      $('.msg-assistances').css('display', 'none');
      $('.msg-news').css('display', 'none');
      $('.msg-feeding').css('display', 'none');
      $('.msg-sphincter').css('display', 'none');
      $('.msg-healths').css('display', 'none');
      $('.msg-events').css('display', 'none');
      $.get("{{ route('getReportDaily') }}", {
        dateSelected: dateSelected
      }, function(objectReport) {
        var count = Object.keys(objectReport).length;
        if (count > 0) {
          $('.msg-return').css('display', 'none');
          for (var i = 0; i < count; i++) {
            if (objectReport[i][0] == 'ASISTENCIA') {
              if (objectReport[i][4] == 1) {
                $('.tbl-assistances tbody').append(
                  "<tr>" +
                  "<td>" + objectReport[i][1] + "</td>" +
                  "<td>" + objectReport[i][2] + "</td>" +
                  "<td>" + objectReport[i][3] + "</td>" +
                  "<td><span class='badge badge-success'>COMPLETO</span></td>" +
                  "</tr>"
                );
              } else {
                $('.tbl-assistances tbody').append(
                  "<tr>" +
                  "<td>" + objectReport[i][1] + "</td>" +
                  "<td>" + objectReport[i][2] + "</td>" +
                  "<td>" + objectReport[i][3] + "</td>" +
                  "<td><span class='badge badge-warning'>SIN SALIDAS</span></td>" +
                  "</tr>"
                );
              }
            } else if (objectReport[i][0] == 'NOVEDAD') {
              $('.tbl-news tbody').append(
                "<tr>" +
                "<td>" + objectReport[i][1] + "</td>" +
                "<td>" + objectReport[i][2] + "</td>" +
                "<td>" + objectReport[i][3] + "</td>" +
                "</tr>"
              );
            } else if (objectReport[i][0] == 'ALIMENTACION') {
              $('.tbl-feeding tbody').append(
                "<tr>" +
                "<td>" + objectReport[i][1] + "</td>" +
                "<td>" + objectReport[i][2] + "</td>" +
                "<td>" + objectReport[i][3] + "</td>" +
                "</tr>"
              );
            } else if (objectReport[i][0] == 'ESFINTERES') {
              $('.tbl-sphincters tbody').append(
                "<tr>" +
                "<td>" + objectReport[i][1] + "</td>" +
                "<td>" + objectReport[i][2] + "</td>" +
                "</tr>"
              );
            } else if (objectReport[i][0] == 'ENFERMERIA') {
              $('.tbl-healths tbody').append(
                "<tr>" +
                "<td>" + objectReport[i][1] + "</td>" +
                "<td>" + objectReport[i][2] + "</td>" +
                "</tr>"
              );
            } else if (objectReport[i][0] == 'EVENTOS') {
              $('.tbl-events tbody').append(
                "<tr>" +
                "<td>" + objectReport[i][1] + "</td>" +
                "<td>" + objectReport[i][2] + "</td>" +
                "<td>" + objectReport[i][3] + "</td>" +
                "</tr>"
              );
            }
          }
          getNothing(
            $('.tbl-assistances tbody tr').length,
            $('.tbl-news tbody tr').length,
            $('.tbl-feeding tbody tr').length,
            $('.tbl-sphincters tbody tr').length,
            $('.tbl-healths tbody tr').length,
            $('.tbl-events tbody tr').length
          );
        } else {
          getNothing(0, 0, 0, 0, 0, 0);
        }
        $('.spinner-border').css('display', 'none');
      });
      $('.sectionResult').css('display', 'block');
    }
  });

  // VALIDAR CANTIDAD DE FILAS DE CADA TABLA PARA MOSTRAR O NO EL MENSAJE DE "NO HAY REGISTROS"
  function getNothing(countAssistances, countNews, countFeedings, countSphincters, countHealths, countEvents) {
    if (countAssistances > 0) {
      $('.msg-assistances').css('display', 'none');
    } else {
      $('.msg-assistances').css('display', 'block');
    }
    if (countNews > 0) {
      $('.msg-news').css('display', 'none');
    } else {
      $('.msg-news').css('display', 'block');
    }
    if (countFeedings > 0) {
      $('.msg-feeding').css('display', 'none');
    } else {
      $('.msg-feeding').css('display', 'block');
    }
    if (countSphincters > 0) {
      $('.msg-sphincter').css('display', 'none');
    } else {
      $('.msg-sphincter').css('display', 'block');
    }
    if (countHealths > 0) {
      $('.msg-healths').css('display', 'none');
    } else {
      $('.msg-healths').css('display', 'block');
    }
    if (countEvents > 0) {
      $('.msg-events').css('display', 'none');
    } else {
      $('.msg-events').css('display', 'block');
    }
  }

  function converterDateToString(date) {
    if (date != '') {
      // 0123/56/78
      var year = date.substring(0, 4);
      var mount = date.substring(5, 7);
      var day = date.substring(8, 10);
      switch (mount) {
        case '01':
          return day + ' DE ENERO DEL ' + year;
          break;
        case '02':
          return day + ' DE FEBRERO DEL ' + year;
          break;
        case '03':
          return day + ' DE MARZO DEL ' + year;
          break;
        case '04':
          return day + ' DE ABRIL DEL ' + year;
          break;
        case '05':
          return day + ' DE MAYO DEL ' + year;
          break;
        case '06':
          return day + ' DE JUNIO DEL ' + year;
          break;
        case '07':
          return day + ' DE JULIO DEL ' + year;
          break;
        case '08':
          return day + ' DE AGOSTO DEL ' + year;
          break;
        case '09':
          return day + ' DE SEPTIEMBRE DEL ' + year;
          break;
        case '10':
          return day + ' DE OCTUBRE DEL ' + year;
          break;
        case '11':
          return day + ' DE NOVIEMBRE DEL ' + year;
          break;
        case '12':
          return day + ' DE DICIEMBRE DEL ' + year;
          break;
        default:
          return date;
      }
    } else {
      return date;
    }
  }
</script>
@endsection