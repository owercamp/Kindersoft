@extends('modules.reports')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>ESTADISTICA DE ASISTENCIA</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de estadisticas de asistencias -->
      @if(session('SuccessSaveStatisticAssistances'))
      <div class="alert alert-success">
        {{ session('SuccessSaveStatisticAssistances') }}
      </div>
      @endif
      @if(session('SecondarySaveStatisticAssistances'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveStatisticAssistances') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de estadisticas de asistencias -->
      @if(session('PrimaryUpdateStatisticAssistances'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateStatisticAssistances') }}
      </div>
      @endif
      @if(session('SecondaryUpdateStatisticAssistances'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateStatisticAssistances') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de estadisticas de asistencias -->
      @if(session('WarningDeleteStatisticAssistances'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteStatisticAssistances') }}
      </div>
      @endif
      @if(session('SecondaryDeleteStatisticAssistances'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteStatisticAssistances') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <small class="text-muted">CURSO:</small>
        <select name="saCourse" class="form-control form-control-sm select2" required>
          <option value="">Seleccione un curso...</option>
          @foreach($courses as $course)
          <option value="{{ $course->id }}">{{ $course->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <small class="text-muted">ALUMNO:</small>
        <select name="saStudent" class="form-control form-control-sm select2" required>
          <option value="">Seleccione un alumno...</option>
          <!-- Dinamics -->
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <small class="text-muted">PERIODO ACADEMICO:</small>
        <select name="saPeriod" class="form-control form-control-sm select2" required>
          <option value="">Seleccione un periodo...</option>
          <!-- Dinamics -->
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" name="saDateInitial" class="form-control form-control-sm" disabled>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" name="saDateFinal" class="form-control form-control-sm" disabled>
      </div>
    </div>
  </div>
  <div class="row border-bottom p-3 text-center">
    <div class="col-md-12">
      <a href="#" class="btn btn-outline-success btn-executeStatistic">CONSULTAR</a>
    </div>
  </div>
  <div class="row py-3 text-center">
    <div class="col-md-12 text-center">
      <div class="spinner-border text-center" align="center" role="status">
        <span class="sr-only" align="center">Procesando...</span>
      </div>
    </div>
  </div>
  <div class="row border-top text-center pt-3 report" style="display: none;">
    <div class="col-md-12">
      <div class="row text-center">
        <div class="col-md-12">
          <b>
            <h6 class="nameStudent-title"></h6>
          </b>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 text-center">
          <canvas id="statisticAssistances"></canvas>
          <div id="tblCanvas"></div>
          <a href="#" class="btnDownload btn btn-outline-tertiary  text-center"><i class="fas fa-file-pdf"></i> PDF</a>
        </div>
        <div class="col-md-6 pdfTable" id="pdfTable">
          <table id="tblResult" class="table text-center">
            <thead>
              <tr>
                <th colspan="2">DATOS</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="text-align: right;">Periodo:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Fecha inicial:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Fecha final:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Dias habiles:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Dias adicionales:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Llegadas a tiempo:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Llegadas tarde:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Ausencias:</th>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <th style="text-align: right;">Procentaje de faltas:</th>
                <td style="text-align: left;"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var canvas = document.getElementById('statisticAssistances');
  // var tblCanvas = document.getElementById('tblCanvas');
  var ctx = document.getElementById('statisticAssistances').getContext('2d');
  // var tblCtx = document.getElementById('tblCanvas').getContext('2d');
  var statistic = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
          label: 'LLEGADAS A TIEMPO',
          data: [],
          backgroundColor: ['#008000'],
        },
        {
          label: 'LLEGADAS TARDE',
          data: [],
          backgroundColor: ['#DC143C'],
        }
      ]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      },
    }
  });

  $(function() {
    $('.spinner-border').css('display', 'none');
  });

  $('select[name=saCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    if (courseSelected != '') {
      $.get("{{ route('getStudentFromCourse') }}", {
        courseSelected: courseSelected
      }, function(objectStudents) {
        var count = Object.keys(objectStudents).length;
        $('select[name=saStudent]').empty();
        $('select[name=saStudent]').append("<option value=''>Seleccione un alumno...</option>");
        for (var i = 0; i < count; i++) {
          $('select[name=saStudent]').append('<option value=' + objectStudents[i]['id'] + '>' + objectStudents[i]['nameStudent'] + '</option>');
        }
        /** NO ESISTEN PERIODOS ACADEMICOS PARA EL AÑO 2022 **/
        $.get("{{ route('getPeriodsOfCourse') }}", {
          courseSelected: courseSelected
        }, function(objectPeriods) {
          var count = Object.keys(objectPeriods).length;
          $('select[name=saPeriod]').empty();
          $('select[name=saPeriod]').append("<option value=''>Seleccione un periodo...</option>");
          for (var i = 0; i < count; i++) {
            // objectPeriods[i]['apId']
            $('select[name=saPeriod]').append("<option value='" + objectPeriods[i]['apDateInitial'] + ":" + objectPeriods[i]['apDateFinal'] + "'>" + objectPeriods[i]['apNameperiod'] + "</option>");
          }
        });
      });
    } else {
      //VACIAR CAMPOS DEL FORMULARIO DE ASISTENCIA
      $('select[name=saStudent]').empty();
      $('select[name=saStudent]').append("<option value=''>Seleccione un alumno...</option>");
      $('select[name=saPeriod]').empty();
      $('select[name=saPeriod]').append("<option value=''>Seleccione un periodo...</option>");
    }
  });

  $('select[name=saPeriod]').on('change', function(e) {
    var period = $(this).val();
    var rangePeriod = period.split(':');
    if (rangePeriod.length > 0 && rangePeriod != null) {
      $('input[name=saDateInitial]').val('');
      $('input[name=saDateInitial]').val(convertDates(rangePeriod[0]));
      $('input[name=saDateFinal]').val('');
      $('input[name=saDateFinal]').val(convertDates(rangePeriod[1]));
    } else {
      $('input[name=saDateInitial]').val('');
      $('input[name=saDateFinal]').val('');
    }
  });

  $('.btn-executeStatistic').on('click', function(e) {
    e.preventDefault();
    var courseSelected = $('select[name=saCourse]').val();
    var periodSelected = $('select[name=saPeriod]').val();
    var studentSelected = $('select[name=saStudent]').val();
    var nameStudent_title = $('select[name=saStudent] option:selected').text();
    if (courseSelected != '' && courseSelected != null &&
      periodSelected != '' && periodSelected != null &&
      studentSelected != '' && studentSelected != null
    ) {
      $('.spinner-border').css('display', 'flex');
      $('.report').css('display', 'none');
      $.ajax({
        type: 'GET',
        url: "{{ route('statistic.period') }}",
        data: {
          course: courseSelected,
          period: periodSelected,
          student: studentSelected
        },
        dataType: 'json',
        async: false,
        beforeSend: function() {
          statistic.data.labels = [];
          statistic.data.datasets[0].data = [];
          statistic.data.datasets[1].data = [];
          $('.btnDownload').css('display', 'none');
        }
      }).done(function(response) {
        if (response != null) {
          statistic.data.labels.push(convertDates(response[0]) + ' - ' + convertDates(response[1]));
          statistic.data.datasets[0].data.push(response[4]);
          statistic.data.datasets[1].data.push(response[5]);
          $('#tblResult tbody').find('tr:nth-child(1)').find('td').text($('select[name=saPeriod] option:selected').text());
          $('#tblResult tbody').find('tr:nth-child(2)').find('td').text(convertDates(response[0]));
          $('#tblResult tbody').find('tr:nth-child(3)').find('td').text(convertDates(response[1]));
          $('#tblResult tbody').find('tr:nth-child(4)').find('td').text(response[2]);
          $('#tblResult tbody').find('tr:nth-child(5)').find('td').text(response[3]);
          $('#tblResult tbody').find('tr:nth-child(6)').find('td').text(response[4]);
          $('#tblResult tbody').find('tr:nth-child(7)').find('td').text(response[5]);
          $('#tblResult tbody').find('tr:nth-child(8)').find('td').text(response[6]);
          $('#tblResult tbody').find('tr:nth-child(9)').find('td').text(response[7] + '%');
        }
        statistic.update();
        $('.spinner-border').css('display', 'none');
        $('.report').css('display', 'flex');
        $('.btnDownload').css('display', 'block');
        $('.nameStudent-title').text('');
        $('.nameStudent-title').text(nameStudent_title);
        converterGrafic();
        // convertTable($('#pdfTable'));
      });
    }
  });

  $('.btnDownload').on('click', function(e) {
    e.preventDefault();
    var pdf = new jsPDF();
    pdf.setFontSize(15);
    pdf.text('ASISTENCIAS DE ESTUDIANTE', 30, 25);
    pdf.text($('.nameStudent-title').text(), 30, 25);
    var namePeriod = $('#tblResult tbody').find('tr:nth-child(1)').find('td').text();
    var initialPeriod = $('#tblResult tbody').find('tr:nth-child(2)').find('td').text();
    var finalPeriod = $('#tblResult tbody').find('tr:nth-child(3)').find('td').text();
    var dayBussines = $('#tblResult tbody').find('tr:nth-child(4)').find('td').text();
    var dayAdditional = $('#tblResult tbody').find('tr:nth-child(5)').find('td').text();
    var timecome = $('#tblResult tbody').find('tr:nth-child(6)').find('td').text();
    var timeout = $('#tblResult tbody').find('tr:nth-child(7)').find('td').text();
    var absent = $('#tblResult tbody').find('tr:nth-child(8)').find('td').text();
    var percentage = $('#tblResult tbody').find('tr:nth-child(9)').find('td').text();

    // $('#tblCanvas').empty();
    // $('#tblCanvas').html(t);
    var grafic = converterGrafic();
    // var table = converterTable();
    // convertTable($('#pdfTable'));
    // console.log(table);
    pdf.addImage(grafic, 'png', 20, 40, 170, 90);
    pdf.fromHTML('PERIODO: ' + namePeriod, 20, 150);
    pdf.fromHTML('Fecha inicial: ' + initialPeriod, 20, 160);
    pdf.fromHTML('Fecha final: ' + finalPeriod, 20, 170);
    pdf.fromHTML('Dias habiles: ' + dayBussines, 20, 180);
    pdf.fromHTML('Dias adicionales: ' + dayAdditional, 20, 190);
    pdf.fromHTML('Llegadas a tiempo: ' + timecome, 20, 200);
    pdf.fromHTML('Llegadas tarde: ' + timeout, 20, 210);
    pdf.fromHTML('Ausencias: ' + absent, 20, 220);
    pdf.fromHTML('Porcentaje de llegadas tarde y ausencias: ' + percentage, 20, 230);
    // pdf.addImage(table,'png',20,40);
    // pdf.addImage(tblImg,'png',20,40,170,90);
    pdf.save("ASISTENCIA_" + $('#tblResult tbody').find('tr:nth-child(1)').find('td').text() + "_GENERADO EL " + Date() + ".pdf");
  });

  function convertTable(element) {
    html2canvas(element, {
      onrendered: function(tcanvas) {
        theCanvas = tcanvas;
        $('#tblCanvas').appendChild(tcanvas);
        /*
        canvas.toBlob(function(blob) {
           	saveAs(blob, "Dashboard.png"); 
        });
        */
      }
    });
    // html2canvas([document.body], table => {
    // 	// var tblImg = table.toDataURL("image/png");
    // 	$('#tblCanvas').appendChild(table);
    // 	console.log($('#tblCanvas').html());
    // });
    // html2canvas(document.getElementById('pdfTable')),(tblCanvas => {
    //     var image = tblCanvas.toDataURL("image/png").replace("image/png", "image/octet-stream"); 
    //     var a = document.createElement('a');
    //     a.href = image;
    //     a.download = 'tabla.png';
    //     a.click();
    // });
    // var data = "<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'>" +         
    //        "<foreignObject width='100%' height='100%'>" + $("#pdfTable").html() +
    //        "</foreignObject>" +
    //        "</svg>";
    //    var DOMURL = self.URL || self.webkitURL || self;
    //    var svg = new Blob([data], {
    //        type: "image/png;charset=utf-8"
    //    });
    //    var url = DOMURL.createObjectURL(svg);
    //    console.log('URL: ' + url);
    //    tblImg.onload = function() {
    //        tblCtx.drawImage(tblImg, 0, 0);
    //        DOMURL.revokeObjectURL(url);
    //    };
    //    tblImg.src = tblCanvas.toDataURL("image/png");
  }

  function converterGrafic() {
    var imgGrafic = new Image();
    imgGrafic.src = canvas.toDataURL("image/png");
    return imgGrafic;
  }

  function converterTable() {
    var imgTable = new Image();
    imgTable.src = $('div#tblCanvas').toDataURL("image/png");
    html2canvas($("#tblCanvas"), {
      onrendered: function(tcanvas) {
        theCanvas = tcanvas;
        $("#tblCanvas").appendChild(tcanvas);
        tcanvas.toBlob(function(blob) {
          saveAs(blob, "tabla.png");
        });
      }
    });
    return imgTable;
  }

  function convertDates(date) {
    var separated = date.split('-');
    switch (separated[1]) {
      case '01':
        return separated[2] + ' de ENERO del ' + separated[0];
        break;
      case '02':
        return separated[2] + ' de FEBRERO del ' + separated[0];
        break;
      case '03':
        return separated[2] + ' de MARZO del ' + separated[0];
        break;
      case '04':
        return separated[2] + ' de ABRIL del ' + separated[0];
        break;
      case '05':
        return separated[2] + ' de MAYO del ' + separated[0];
        break;
      case '06':
        return separated[2] + ' de JUNIO del ' + separated[0];
        break;
      case '07':
        return separated[2] + ' de JULIO del ' + separated[0];
        break;
      case '08':
        return separated[2] + ' de AGOSTO del ' + separated[0];
        break;
      case '09':
        return separated[2] + ' de SEPTIEMBRE del ' + separated[0];
        break;
      case '10':
        return separated[2] + ' de OCTUBRE del ' + separated[0];
        break;
      case '11':
        return separated[2] + ' de NOVIEMBRE del ' + separated[0];
        break;
      case '12':
        return separated[2] + ' de DICIEMBRE del ' + separated[0];
        break;
    }
  }
</script>
@endsection