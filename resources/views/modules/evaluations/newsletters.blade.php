@extends('modules.evaluation')

@section('academicModules')
<div class="col-md-12">
  <div class="row py-3 border-top border-bottom">
    <div class="col-md-6">
      <h3>INFORME DE PERIODO</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de boletines escolares -->
      @if(session('SuccessSaveNewletter'))
      <div class="alert alert-success">
        {{ session('SuccessSaveNewletter') }}
      </div>
      @endif
      @if(session('SecondarySaveNewletter'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveNewletter') }}
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
  <div class="row border-top mt-3 py-3 px-3 infoGeneral" style="display: none;">
    <div class="col-md-9 border-right">
      <div class="row">
        <div class="col-md-12 sections_bulletin"></div>
      </div>
      <h5><b>INFORMACION GENERAL DEL PERIODO: </b></h5>
      <hr>
      <h6><b>INTELIGENCIAS: </b></h6><br>
      <table class="table" width="100%">
        <thead>
          <th>INTELIGENCIA</th>
          <th>PROMEDIO</th>
        </thead>
        <tbody class="tbodyIntelligences">
          <!-- tr dinamics -->
        </tbody>
      </table>
      <hr>
      <canvas id="statisticBulletin" width="300" height="150"></canvas>
    </div>
    <div class="col-md-3">
      <form action="{{ route('newsletters.pdf') }}" method="GET" enctype="multipart/form-data">
        <input type="hidden" name="buStudent_id" class="form-control form-control-sm" readonly>
        <input type="hidden" name="buCourse_id" class="form-control form-control-sm" readonly>
        <input type="hidden" name="buPeriod_id" class="form-control form-control-sm" readonly>
        <input type="file" name="buGrafic_id" class="form-control form-control-sm" hidden readonly>
        <input type="hidden" name="buIntelligences" class="form-control form-control-sm" readonly>
        <button type="submit" class="btn btn-outline-tertiary  form-control-sm" style="width: 100%; height: 100%;">
          DESCARGAR INFORME
          <br>
          <br>
          <i class="fas fa-file-pdf" style="font-size: 100px; font-weight: bold; line-height: 100%;"></i>
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var canvas = document.getElementById('statisticBulletin');
  var ctx = document.getElementById('statisticBulletin').getContext('2d');
  var img = new Image();
  var statistic = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
        label: 'PROMEDIO',
        data: [

        ],
        backgroundColor: [
          '#ED7D32'
        ],
        borderColor: [
          '#ED7D32'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            // callback: function(value) {if (value % 1 === 0) {return value;}}
          }
        }]
      }
    }
  });

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
    var studentSelected = $('select[name=pcStudent] option:selected').val();
    var courseSelected = $('input[name=infoIdCourse]').val();
    $('.infoGeneral').css('display', 'none');
    $('.tbodyIntelligences').empty();
    $('.spinner-border').css('display', 'flex');
    if (periodSelected != '' && studentSelected != '' && courseSelected != '') {
      $.get(
        "{{ route('getReportPeriod') }}", {
          periodSelected: periodSelected,
          studentSelected: studentSelected,
          courseSelected: courseSelected
        },
        function(response) {
          var count = Object.keys(response).length;
          if (count > 0) {
            var labels = [];
            var data = [];
            var backgroundColor = [];
            var borderColor = [];
            statistic.data.datasets.length = 0;
            var allIntelligence = '';
            for (var i = 0; i < count; i++) {
              $('.tbodyIntelligences').append(
                "<tr>" +
                "<td>" + response[i][1] + "</td>" +
                "<td>" + response[i][2] + "</td>" +
                "</tr>"
              );
              if (i == (count - 1)) {
                allIntelligence += response[i][1] + '=' + response[i][2];

              } else {
                allIntelligence += response[i][1] + '=' + response[i][2] + ':';
              }
              labels.push(response[i][1]);
              if (response[i][2] == 'N/A') {
                data.push(0.0);
              } else {
                data.push(response[i][2]);
              }
              backgroundColor.push('#ED7D32');
              borderColor.push('#ED7D32');
            }
            $('input[name=buIntelligences]').val(allIntelligence);
            statistic.data.labels = labels
            statistic.data.datasets.push({
              label: 'PROMEDIO',
              data: data,
              backgroundColor: backgroundColor,
              borderColor: borderColor,
              fill: false,
              borderWidth: 1
            });
            statistic.update();
          }
          $('input[name=buStudent_id]').val(studentSelected);
          $('input[name=buCourse_id]').val(courseSelected);
          $('input[name=buPeriod_id]').val(periodSelected);
          $('.spinner-border').css('display', 'none');
          $('.infoGeneral').css('display', 'flex');
        }
      );
    } else {
      $('.infoGeneral').css('display', 'none');
      $('.spinner-border').css('display', 'none');
    }
    convertCanvasToImage();
  });

  function resetAll() {
    $('select[name=pcPeriod]').empty();
    $('select[name=pcPeriod]').append("<option value=''>Seleccione un periodo...</option>");
    $('input[name=infoIdStudent]').val('');
    $('input[name=infoCourseStudent]').val('');
    $('.spinner-border').css('display', 'none');
  }

  function convertCanvasToImage() {
    img.src = canvas.toDataURL("image/png");

    // $('input[name=buGrafic_id]').val(img.src);
    // $('form').append(img);
  }
</script>
@endsection