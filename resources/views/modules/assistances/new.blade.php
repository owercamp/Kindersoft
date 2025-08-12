@extends('modules.dailynews')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>MODULO DE CONTROL DE ASISTENCIA</h3> <br>
      <a href="#" class="btn btn-outline-success form-control-sm mb-3 mx-3 pdfAssistance-link">DESCARGA DE ASISTENCIAS</a>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de asistencias -->
      @if(session('SuccessSaveAssitances'))
      @php set_time_limit(3); @endphp
      <div class="alert alert-success">
        {{ session('SuccessSaveAssitances') }}
      </div>
      @php sleep(3); @endphp
      @endif
      @if(session('SecondarySaveAssitances'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAssitances') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de asistencias -->
      @if(session('PrimaryUpdateAssitances'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAssitances') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAssitances'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAssitances') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de asistencias -->
      @if(session('WarningDeleteAssitances'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAssitances') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAssitances'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAssitances') }}
      </div>
      @endif
      <div class="alert message" style="display: none"></div>
    </div>
  </div>
  <div class="row border-bottom">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">CURSO:</small>
            <select name="assCourse" class="form-control form-control-sm select2" required>
              <option value="">Seleccione un curso...</option>
              @foreach($courses as $course)
              <option value="{{ $course->id }}">{{ $course->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <small class="text-muted">ALUMNO:</small>
            <select name="assStudent" class="form-control form-control-sm select2" required>
              <option value="">Seleccione un alumno...</option>
              <!-- Option dinamico de seleccion del curso -->
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">FECHA Y HORA ACTUAL:</small>
            <input type="text" name="assDate" class="form-control form-control-sm datepicker" disabled>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">HORA DE LLEGADA:</small>
                <input type="time" name="assHourinitial" class="form-control form-control-sm">
                <span hidden class="hourinitialLegalization"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">HORA DE SALIDA:</small>
                <input type="time" name="assHourfinal" class="form-control form-control-sm">
                <span hidden class="hourfinalLegalization"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <small class="text-muted">JORNADA:</small><span hidden class="assAditionalDay badge badge-warning ml-3"></span>
            <input type="text" name="assJourney" class="form-control form-control-sm" disabled>
            <span hidden class="assIdJourney"></span>
            <small hidden class="text-muted title-add">DIA ADICIONAL:</small>
            <div class="input-group dayAdditional" style="display: none;">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="hidden" class="form-control form-control-sm" name="assAdd" maxlength="6" disabled>
            </div>
            <small hidden class="text-muted title-addMinute">CADA MINUTO ADICIONAL:</small>
            <div class="input-group minuteAdditional" style="display: none;">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="hidden" class="form-control form-control-sm" name="assAddMinute" maxlength="6" disabled placeholder="Especifique el valor por minuto adicional (Solo números)">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <small class="text-muted">OBSERVACIÓN DE LLEGADA:</small>
        <textarea name="assDescriptionArrival" cols="5" rows="3" maxlength="500" class="form-control form-control-sm" placeholder="Máximo de 500 carácteres"></textarea>
      </div>
      <div class="form-group">
        <small class="text-muted">OBSERVACIÓN DE SALIDA:</small>
        <textarea name="assDescriptionExit" cols="5" rows="3" maxlength="500" class="form-control form-control-sm" placeholder="Máximo de 500 carácteres"></textarea>
      </div>
    </div>
  </div>
  <div class="row text-center border-bottom py-2">
    <div class="col-md-6">
      <button type="button" class="btn btn-outline-primary form-control-sm btnAddAssistance">AÑADIR</button>
    </div>
    <div class="col-md-6">

    </div>
  </div>
  <table id="tableList" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>ALUMNO</th>
        <th>JORNADA</th>
        <th>HORAS DE ASISTENCIA</th>
        <th>OBSERVACIONES</th>
        <th>CUMPLIMIENTO</th>
      </tr>
    </thead>
    <tbody>
      <!-- rows dinamics -->
    </tbody>
  </table>
  <div class="row text-center border-top my-2">
    <div class="col-md-12 py-4">
      <button type="button" class="btn btn-outline-success form-control-sm btnAssistanceFinal">FINALIZAR ASISTENCIA</button>
    </div>
  </div>

  <!-- MODAL PARA CONFIRMAR Y FINALIZAR LISTA DE ASISTENCIA  -->
  <div class="modal fade" id="confirmAssistance-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="text-muted">CONFIRMAR ASISTENCIA:</h4>
        </div>
        <div class="modal-body">
          <div class="row assistanceAll" style="display: none;">
            <div class="col-md-12">
              <h6>Ha confirmado el total de alumnos de <b class="nameCourseSelected">Nombre del curso</b></h6>
            </div>
          </div>
          <div class="row assistanceNotAll" style="display: none;">
            <div class="col-md-12">
              <h6>Los siguientes alumnos faltan por asistencia, Si continua se marcarán con fecha de hoy como ausentes</h6>
              <table id="table-modal" class="table table-hover text-center" width="100%">
                <thead>
                  <tr>
                    <th>NOMBRES</th>
                    <th>NUMERO DE IDENTIFICACION</th>
                    <th>EDAD</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- tr dinamicos -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer text-center">
          <div class="row ">
            <div class="col-md-12">
              <button type="submit" class="btn btn-outline-success form-control-sm float-left  mx-4 saveAssistance">CONTINUAR</button>
              <button type="button" class="btn btn-outline-tertiary  form-control-sm float-right mx-4" data-dismiss="modal">CANCELAR</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL PARA DESCARGAR PDFs FILTRADOS POR CURSO Y FECHA  -->
  <div class="modal fade" id="pdfAssistance-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="text-muted">DESCARGAR PDFs DE ASISTENCIAS:</h4>
        </div>
        <form action="{{ route('assistances.pdf') }}" method="GET" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilterPdf" value="group" checked>
                  INFORME GRUPAL
                </small>
              </div>
              <div class="col-md-6 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilterPdf" value="unique">
                  INFORME INDIVIDUAL
                </small>
              </div>
            </div>
            <div class="row filterPdfGroup">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">CURSO:</small>
                  <select name="pdfCourseGroup" class="form-control form-control-sm select2" required>
                    <option value="">Seleccione un curso...</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">FECHA:</small>
                  <input type="text" name="pdfDateGroup" class="form-control form-control-sm datepicker" required>
                </div>
              </div>
            </div>
            <div class="row filterPdfUnique" style="display: none;">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">CURSO:</small>
                  <select name="pdfCourseUnique" class="form-control form-control-sm select2" disabled>
                    <option value="">Seleccione un curso...</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">ESTUDIANTE:</small>
                  <select name="pdfStudentUnique" class="form-control form-control-sm select2" disabled>
                    <option value="">Seleccione un alumno...</option>
                    <!-- option dinamicos -->
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer text-center">
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-success form-control-sm float-left  mx-4">DESCARGAR</button>
                <button type="button" class="btn btn-outline-tertiary  form-control-sm float-right mx-4" data-dismiss="modal">CANCELAR</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    var date = new Date();
    $('input[name=assDate]').val(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
  });

  // FILTRO DE PDF
  $('input[name=optionFilterPdf]').on('click', function() {
    var check = $(this).val();
    if (check == 'group') {
      $('.filterPdfGroup').css('display', 'flex');
      $('select[name=pdfCourseGroup]').attr('required', true);
      $('select[name=pdfCourseGroup]').attr('disabled', false);
      $('input[name=pdfDateGroup]').attr('required', true);
      $('input[name=pdfDateGroup]').attr('disabled', false);
      $('.filterPdfUnique').css('display', 'none');
      $('select[name=pdfCourseUnique]').attr('required', false);
      $('select[name=pdfCourseUnique]').attr('disabled', true);
      $('select[name=pdfStudentUnique]').attr('required', false);
      $('select[name=pdfStudentUnique]').attr('disabled', true);
      $('input[name=pdfDateInitialUnique]').attr('required', false);
      $('input[name=pdfDateInitialUnique]').attr('disabled', true);
      $('input[name=pdfDateFinalUnique]').attr('required', false);
      $('input[name=pdfDateFinalUnique]').attr('disabled', true);
    } else if (check == 'unique') {
      $('.filterPdfGroup').css('display', 'none');
      $('select[name=pdfCourseGroup]').attr('required', false);
      $('select[name=pdfCourseGroup]').attr('disabled', true);
      $('input[name=pdfDateGroup]').attr('required', false);
      $('input[name=pdfDateGroup]').attr('disabled', true);
      $('.filterPdfUnique').css('display', 'flex');
      $('select[name=pdfCourseUnique]').attr('required', true);
      $('select[name=pdfCourseUnique]').attr('disabled', false);
      $('select[name=pdfStudentUnique]').attr('required', true);
      $('select[name=pdfStudentUnique]').attr('disabled', false);
      $('input[name=pdfDateInitialUnique]').attr('required', true);
      $('input[name=pdfDateInitialUnique]').attr('disabled', false);
      $('input[name=pdfDateFinalUnique]').attr('required', true);
      $('input[name=pdfDateFinalUnique]').attr('disabled', false);
    }
  });

  $('select[name=pdfCourseUnique]').on('change', function(e) {
    var courseSelected = e.target.value;
    if (courseSelected != '') {
      $.get("{{ route('getStudentFromCourse') }}", {
        courseSelected: courseSelected
      }, function(objectStudents) {
        var count = Object.keys(objectStudents).length;
        $('select[name=pdfStudentUnique]').empty();
        $('select[name=pdfStudentUnique]').append("<option value=''>Seleccione un alumno...</option>");
        for (var i = 0; i < count; i++) {
          $('select[name=pdfStudentUnique]').append('<option value=' + objectStudents[i]['id'] + '>' + objectStudents[i]['nameStudent'] + '</option>');
        }
      });
    }
  });
  // ##FILTRO DE PDF

  $('select[name=assCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    if (courseSelected != '') {
      $.get("{{ route('getStudentFromCourse') }}", {
        courseSelected: courseSelected
      }, function(objectStudents) {
        var count = Object.keys(objectStudents).length;
        $('select[name=assStudent]').empty();
        $('select[name=assStudent]').append("<option value=''>Seleccione un alumno...</option>");
        $('input[name=assJourney]').val('');
        $('span.assAditionalDay').text('');
        $('span.assAditionalDay').attr('hidden', true);
        $('.title-add').attr('hidden', true);
        $('.dayAdditional').css('display', 'none');
        $('input[name=assAdd]').attr('type', 'hidden');
        $('input[name=assAdd]').val('');
        for (var i = 0; i < count; i++) {
          $('select[name=assStudent]').append('<option value=' + objectStudents[i]['id'] + '>' + objectStudents[i]['nameStudent'] + '</option>');
        }
      });
    } else {
      //VACIAR CAMPOS DEL FORMULARIO DE ASISTENCIA
      $('select[name=assStudent]').empty();
      $('select[name=assStudent]').append("<option value=''>Seleccione un alumno...</option>");
      $('span.hourinitialLegalization').text('');
      $('span.hourfinalLegalization').text('');
      $('.title-addMinute').attr('hidden', true);
      $('.minuteAdditional').css('display', 'none');
      $('input[name=assAddMinute]').attr('disabled', true);
      $('input[name=assAddMinute]').attr('type', 'hidden');
      $('input[name=assAddMinute]').val('');
    }
  });

  $('select[name=assStudent]').on('change', function(e) {
    var studentSelected = e.target.value;
    if (studentSelected != '') {
      $.get("{{ route('getJourneyFromStudent') }}", {
        studentSelected: studentSelected
      }, function(objectJourney) {
        if (Object.keys(objectJourney).length > 0) {
          $('span.assIdJourney').text('');
          $('span.assIdJourney').text(objectJourney['id']);
          $('input[name=assJourney]').val('');
          $('input[name=assJourney]').val(objectJourney['jouJourney'] + ' / ' + objectJourney['jouDays'] + ' / DE ' + objectJourney['jouHourEntry'] + ' A ' + objectJourney['jouHourExit']);
          //PONER LAS HORAS DEL CONTRATO EN LOS SPAN OCULTOS
          $('span.hourinitialLegalization').text('');
          $('span.hourinitialLegalization').text(objectJourney['jouHourEntry']);
          $('span.hourfinalLegalization').text('');
          $('span.hourfinalLegalization').text(objectJourney['jouHourExit']);
          var datenow = $('input[name=assDate]').val();
          // if(objectJourney['legDateInitial'] <= datenow && objectJourney['legDateFinal'] >= datenow){
          var separatedDaysLegalization = objectJourney['jouDays'].split(' - ');
          var controlCountDays = false;
          for (i = 0; i < separatedDaysLegalization.length; i++) {
            var dayDatenow = getDayFormat(datenow);
            if (separatedDaysLegalization[i] == dayDatenow) {
              controlCountDays = true;
            }
          }
          if (controlCountDays) {
            $('span.assAditionalDay').text('');
            $('span.assAditionalDay').attr('hidden', true);
            $('span.assAditionalDay').text('SKIP');
            $('.title-add').attr('hidden', true);
            $('.dayAdditional').css('display', 'none');
            $('input[name=assAdd]').attr('type', 'hidden');
            $('input[name=assAdd]').val('');
          } else {
            $('span.assAditionalDay').text('');
            $('span.assAditionalDay').attr('hidden', false);
            $('span.assAditionalDay').text('ESTE ALUMN@ GENERA COBRO POR DIA ADICIONAL');
            $('.title-add').attr('hidden', false);
            $('.dayAdditional').css('display', 'flex');
            $('input[name=assAdd]').attr('type', 'text');
            $('input[name=assAdd]').val('');
          }
          $.get("{{ route('getJourneyDayAdditional') }}", function(objectValueAdditional) {
            if (objectValueAdditional != null && Object.keys(objectValueAdditional).length > 0) {
              $('input[name=assAdd]').val(objectValueAdditional['jouValue']);
            } else {
              $('input[name=assAdd]').attr('disabled', false);
              $('input[name=assAdd]').attr('placeholder', 'ESPECIFIQUE EL COSTO ADICIONAL AQUI (Solo números)');
            }
          });
          // 	$('.btnAddAssistance').css('display','flex');
          // }else{
          // 	$('.btnAddAssistance').css('display','none');
          // }
        } else {
          $('span.assIdJourney').text('');
          $('input[name=assJourney]').val('');
        }
      });
    } else {
      $('span.assIdJourney').text('');
      $('input[name=assJourney]').val('');
      $('span.hourinitialLegalization').text('');
      $('span.hourfinalLegalization').text('');
      $('.title-addMinute').attr('hidden', true);
      $('.minuteAdditional').css('display', 'none');
      $('input[name=assAddMinute]').attr('disabled', true);
      $('input[name=assAddMinute]').attr('type', 'hidden');
      $('input[name=assAddMinute]').val('');
    }
  });

  //OBTENER EL DIA DE LA SEMANA PARA COMPARAR CON LOS DIAS DEL CONTRATO
  function getDayFormat(datenow) {
    var days = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
    var dt = new Date(datenow);
    return days[dt.getUTCDay()];
  }

  $('.btnAddAssistance').on('click', function(e) {
    e.preventDefault();
    var statusDayAdditional = $('span.assAditionalDay').text();
    var valueDayAdditional = $('input[name=assAdd]').val();
    var idStudent = $('select[name=assStudent] option:selected').val();
    var nameStudent = $('select[name=assStudent] option:selected').text();
    var dateAssistance = $('input[name=assDate]').val();
    var idJourney = $('span.assIdJourney').text();
    var journey = $('input[name=assJourney]').val();
    var hourInitial = $('input[name=assHourinitial]').val();
    var hourFinal = $('input[name=assHourfinal]').val();
    var hil = $('span.hourinitialLegalization').text(); //Hora inicial de legalización
    var hfl = $('span.hourfinalLegalization').text(); //Hora final de legalización
    var observationArrival = $('textarea[name=assDescriptionArrival]').val();
    var observationExit = $('textarea[name=assDescriptionExit]').val();
    var minutesValue = $('input[name=assAddMinute]').val();
    if (
      statusDayAdditional != '' && statusDayAdditional != null &&
      idStudent != '' && idStudent != null &&
      nameStudent != '' && nameStudent != null &&
      dateAssistance != '' && dateAssistance != null &&
      idJourney != '' && idJourney != null &&
      journey != '' && journey != null &&
      hourInitial != '' && hourInitial != null &&
      hourFinal != '' && hourFinal != null &&
      hil != '' && hil != null &&
      hfl != '' && hfl != null &&
      observationArrival != '' && observationArrival != null &&
      observationExit != '' && observationExit != null
      // minutesValue != '' && minutesValue != null
    ) {
      var repeat = false;
      $('#tableList tbody tr').each(function() {
        var idOld = $(this).find('span.idstudent').text();
        if (idOld != null && idOld != '') {
          if (idOld == idStudent) {
            repeat = true;
          }
        }
      });
      if (!repeat) {
        var dateControl = new Date(); //Formato de fecha para comparar las horas seleccionada con las horas del contrato 
        var hilS = hil.split(':');
        var hisS = hourInitial.split(':');
        var hflS = hfl.split(':');
        var hfsS = hourFinal.split(':');
        var datehil = new Date(dateControl.setHours(hilS[0], hilS[1]));
        var datehis = new Date(dateControl.setHours(hisS[0], hisS[1]));
        var datehfl = new Date(dateControl.setHours(hflS[0], hflS[1]));
        var datehfs = new Date(dateControl.setHours(hfsS[0], hfsS[1]));
        var come = '';
        var out = '';
        var minutesCome = 0;
        var minutesOut = 0;
        //COMPARANDO LAS HORAS Y MINUTOS DE LLEGADA
        if (datehis < datehil) {
          come = 'LLEGADA A TIEMPO';
        } else {
          if (datehis.getMinutes() > datehil.getMinutes() + 15) {
            come = 'LLEGADA TARDE ..' + datehis.getMinutes() + '.. MINUTOS'; // SI LOS MINUTOS SUPERAN LOS QUINCE MINUTOS
          } else {
            come = 'LLEGADA A TIEMPO'; // SI LOS MINUTOS DE LLEGADA SON MENORES O IGUAL A QUINCE
          }
        }
        if (datehfs < datehfl) {
          out = 'RECOGIDA A TIEMPO';
        } else {
          if (datehfs.getMinutes() > datehfl.getMinutes() + 15) {
            out = 'RECOGIDA TARDE ..' + datehfs.getMinutes() + '.. MINUTOS'; // SI LOS MINUTOS SUPERAN LOS QUINCE MINUTOS
            $.get("{{ route('getValueMinutesAdditional') }}", {
              minutes: datehfs.getMinutes()
            }, function(objectValueMinutes) {
              var count = Object.keys(objectValueMinutes).length;
              if (count > 0) {
                $('.title-addMinute').attr('hidden', false);
                $('.minuteAdditional').css('display', 'flex');
                $('input[name=assAddMinute]').attr('disabled', true);
                $('input[name=assAddMinute]').attr('type', 'text');
                $('input[name=assAddMinute]').val(objectValueMinutes['jouValue']);
              } else {
                $('.title-addMinute').attr('hidden', false);
                $('.minuteAdditional').css('display', 'flex');
                $('input[name=assAddMinute]').attr('disabled', false);
                $('input[name=assAddMinute]').attr('type', 'text');
                $('input[name=assAddMinute]').val('');
              }
            });
          } else {
            out = 'RECOGIDA A TIEMPO'; // SI LOS MINUTOS DE LLEGADA SON MENORES O IGUAL A QUINCE
          }
        }

        $('#tableList tbody').append(
          '<tr>' +
          "<td><span hidden class='idstudent'>" + idStudent + "</span><span class='nameStudent'>" + nameStudent + "</span><span hidden class='statusDay'>" + statusDayAdditional + "</span><span hidden class='valueDay'>" + valueDayAdditional + "</span></td>" +
          '<td><span hidden>' + idJourney + '</span><span>' + journey + '</span></td>' +
          '<td>' + hourInitial + ' - ' + hourFinal + '</td>' +
          '<td>' + observationArrival + ' / ' + observationExit + '</td>' +
          '<td>' + come + ' / ' + out + '</td>' +
          "<td><a herf='#' class='btn btn-outline-tertiary  btnDeleteRow' title='ELIMINAR'><i class='fas fa-trash-alt'></i></a></td>" +
          '</tr>'
        );
      } else {
        $('.message').css('display', 'block');
        $('.message').removeClass('alert-success');
        $('.message').addClass('alert-warning');
        $('.message').html('Ya existe el alumno en la lista de asistencia');
        setTimeout(function() {
          $('.message').css('display', 'none');
          $('.message').html('');
          $('.message').removeClass('alert-success');
          $('.message').removeClass('alert-warning');
        }, 5000);
      }
    }
  });

  $('#tableList').on('click', '.btnDeleteRow', function() {
    //$(this).parents('tr').empty();
    $(this).parents('tr').remove();
    // var countRow = $('#tableList tbody tr').length;
    // if(countRow <= 0){
    // 	$('.btnAssistanceFinal').css('display','none');
    // }else{
    // 	$('.btnAssistanceFinal').css('display','flex');
    // }
  });

  //BOTON FINALIZAR ASISTENCIA PARA MOSTRAR VENTANA MODAL
  $('.btnAssistanceFinal').on('click', function(e) {
    e.preventDefault();
    var countRow = $('#tableList tbody tr').length;
    if (countRow > 0) {
      var students = [];
      var courseSelected = $('select[name=assCourse] option:selected').val();
      $('#tableList tbody tr').each(function() {
        var idStudent = $(this).find('span.idstudent').text();
        if (idStudent != null && idStudent != '' && idStudent != 'Undefined') {
          students.push(idStudent);
        }
      });
      if (students != '' && students.length > 0) {
        var date = new Date();
        $.get("{{ route('getValidateAssistance') }}", {
          students: students,
          course: courseSelected,
          day: date.getDay()
        }, function(objectStudents) {
          if (objectStudents != null && objectStudents != '') {
            var count = Object.keys(objectStudents).length;
            $('#table-modal tbody').empty();
            if (count > 0) {
              for (var i = 0; i < count; i++) {
                $('#table-modal tbody').append(
                  '<tr>' +
                  "<td><span hidden class='idstudent'>" + objectStudents[i][0] + "</span>" + objectStudents[i][1] + "</td>" +
                  '<td>' + objectStudents[i][2] + '</td>' +
                  '<td>' + objectStudents[i][3] + '</td>' +
                  '</tr>'
                );
              }
              $('.assistanceAll').css('display', 'none');
              $('.assistanceNotAll').css('display', 'block');
              $('#confirmAssistance-modal').modal();
            } else {
              $('.nameCourseSelected').text('');
              $('.nameCourseSelected').text($('select[name=assCourse] option:selected').text());
              $('.assistanceNotAll').css('display', 'none');
              $('.assistanceAll').css('display', 'block');
              $('#table-modal tbody').empty();
              $('#confirmAssistance-modal').modal();
            }
          } else {
            $('.nameCourseSelected').text('');
            $('.nameCourseSelected').text($('select[name=assCourse] option:selected').text());
            $('.assistanceNotAll').css('display', 'none');
            $('.assistanceAll').css('display', 'block');
            $('#table-modal tbody').empty();
            $('#confirmAssistance-modal').modal();
          }
        });
      } else {
        $('.assistanceAll').css('display', 'block');
        $('.assistanceNotAll').css('display', 'none');
        $('#confirmAssistance-modal').modal();
      }
    }
  });

  //BOTON DE CIERRE DE MODAL
  $("#confirmAssistance-modal").on('hidden.bs.modal', function() {
    $('.assistanceAll').css('display', 'none');
    $('.assistanceNotAll').css('display', 'none');
    $('#table-modal tbody').empty();
  });

  //BOTON PARA GUARDAR TODAS LAS FILAS DE LA TABLA EN LA BASE DE DATOS DE ASISTENCIAS
  $('.saveAssistance').on('click', function(e) {
    e.preventDefault();
    var present = [];
    var courseSelected = $('select[name=assCourse] option:selected').val();
    var dateAssistance = $('input[name=assDate]').val();
    $('#tableList tbody tr').each(function() {
      var idStudent = $(this).find('span.idstudent').text();
      var nameStudent = $(this).find('span.nameStudent').text();
      var statusDay = $(this).find('span.statusDay').text();
      var valueDay = $(this).find('span.valueDay').text();
      var idJourney = $(this).find('td:nth-child(2)').find('span:nth-child(1)').text();
      var journey = $(this).find('td:nth-child(2)').find('span:nth-child(2)').text();
      var rangeHour = $(this).find('td:nth-child(3)').text();
      var observations = $(this).find('td:nth-child(4)').text().split(' / ');
      var puntuality = $(this).find('td:nth-child(5)').text().split(' / ');
      var minuteAdditional = $('input[name=assAddMinute]').val();
      if (idStudent != null && idStudent != '' && idStudent != 'Undefined') {
        present.push([
          idStudent,
          rangeHour,
          observations[0], //OBSERVACION DE LLEGADA
          observations[1], //OBSERVACION DE SALIDA
          idJourney,
          statusDay,
          valueDay,
          puntuality[0],
          puntuality[1],
          minuteAdditional
        ]);
      }
    });
    var absent = [];
    $('#table-modal tbody tr').each(function() {
      var idStudent = $(this).find('span.idstudent').text();
      if (idStudent != null && idStudent != '') {
        absent.push(idStudent);
      }
    });
    if (present != '' && present.length > 0) {
      $.ajax({
        url: "{{ route('assistances.new') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          course: courseSelected,
          date: dateAssistance,
          present: present,
          absent: absent
        },
        success: function(response) {
          $('.message').css('display', 'block');
          $('.message').addClass('alert-success');
          $('.message').removeClass('alert-warning');
          $('.message').html(response);
          setTimeout(function() {
            $('.message').css('display', 'none');
            $('.message').removeClass('alert-success');
            $('.message').removeClass('alert-warning');
            $('.message').html('');
          }, 30000);
        },
        complete: function() {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('#tableList tbody').empty();
          $('#table-modal tbody').empty();
          $('#confirmAssistance-modal').modal('hide');
        }
      });
    }
  });

  $('.pdfAssistance-link').on('click', function(e) {
    e.preventDefault();
    $('#pdfAssistance-modal').modal();
  });
</script>
@endsection