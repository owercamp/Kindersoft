@extends('modules.dailynews')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>CONTROL DE ASISTENCIA</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de asistencias -->
      @if(session('SuccessSaveAssitances'))
      @php set_time_limit(3); @endphp
      <div class="alert alert-success">
        {{ session('SuccessSaveAssitances') }}
      </div>
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
      <div class="alert message-save" style="display: none"></div>
    </div>
  </div>
  <div class="row p-3 border-bottom">
    <div class="col-md-4">
      <div class="form-group">
        <small class="text-muted">FECHA:</small>
        <input type="text" name="dateAssistance" class="form-control form-control-sm datepicker" value="{{ $datenow }}">
      </div>
    </div>
    <div class="col-md-4 pt-4">
      <div class="form-group form-inline">
        <button type="button" class="btn btn-outline-success form-control-sm btn-refreshTable">CONSULTAR</button>
      </div>
    </div>
    <div class="col-md-4 pt-4">
      <div class="form-group form-inline">
        <button type="button" class="btn btn-outline-primary form-control-sm btn-newAssistance">NUEVA ASISTENCIA</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h6 class="table-title text-center m-3">Asistencias del</h6>
    </div>
  </div>
  <div class="row text-center bj-spinner">
    <div class="col-md-12">
      <div class="spinner-border" align="center" role="status">
        <span class="sr-only" align="center">Procesando...</span>
      </div>
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <th>CURSO</th>
      <th>AUSENTES</th>
      <th>PRESENTES</th>
      <th>ACCIONES</th>
    </thead>
    <tbody>
      <!-- rows dinamics from ajax -->
    </tbody>
  </table>
</div>

<!-- MODAL PARA TOMAR ASISTENCIA  -->
<div class="modal fade" id="newAssistance-modal" style="font-size: 12px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="text-muted">NUEVO LISTADO DE ASISTENCIA:</h4><br>
        <div class="alert message" style="display: none"></div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">CURSO:</small>
              <select name="assCourse" class="form-control form-control-sm" required>
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
              <select name="assStudent" class="form-control form-control-sm" required>
                <option value="">Seleccione un alumno...</option>
                <!-- Option dinamico de seleccion del curso -->
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">FECHA ACTUAL:</small>
              <input type="text" name="assDate" class="form-control form-control-sm datepicker" disabled>
              <input type="hidden" name="assDate_hidden" class="form-control form-control-sm" readonly>
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
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">HORA LLEGADA:</small>
              <input type="time" name="assHourinitial" class="form-control form-control-sm">
              <span hidden class="hourinitialLegalization"></span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">TEMPERATURA DE LLEGADA:</small>
              <input type="text" placeholder="00.0" maxlength="4" title="Ingrese numero decimal con punto" name="assTempentry" class="form-control form-control-sm">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted">OBSERVACIÓN DE LLEGADA:</small>
              <textarea name="assDescriptionArrival" maxlength="500" class="form-control form-control-sm" placeholder="Máximo de 500 carácteres"></textarea>
            </div>
          </div>
        </div>

        <div class="row text-center border-bottom py-2">
          <div class="col-md-12">
            <button type="button" class="btn btn-outline-primary form-control-sm btnAddAssistance">AÑADIR ALUMNO</button>
          </div>
        </div>
        <table id="tableList" class="table table-hover text-center" width="100%">
          <thead>
            <tr>
              <th>ALUMNO</th>
              <th>JORNADA</th>
              <th>LLEGADA</th>
              <th>OBSERVACIONES</th>
              <th>TEMPERATURA</th>
              <th>CUMPLIMIENTO</th>
            </tr>
          </thead>
          <tbody>
            <!-- rows dinamics -->
          </tbody>
        </table>
        <div class="row text-center border-top my-2">
          <div class="col-md-12 py-4">
            <button type="button" class="btn btn-outline-success form-control-sm btnAssistanceFinal">VALIDAR ASISTENCIA</button>
          </div>
        </div>
        <div class="row text-center bj-spinner-modal">
          <div class="col-md-12">
            <div class="spinner-border" align="center" role="status">
              <span class="sr-only" align="center">Procesando...</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <div class="row assistanceAll" style="display: none;">
          <div class="col-md-12">
            <h6>Ha confirmado el total de alumnos de <b class="nameCourseSelected">Nombre del curso</b></h6>
            <button type="submit" class="btn btn-outline-success form-control-sm float-left  mx-4 saveAssistance">GUARDAR ASISTENCIA</button>
          </div>
        </div>
        <div class="row assistanceNotAll" style="display: none;">
          <div class="col-md-12">
            <h6>Los siguientes alumnos faltan por asistencia, Si continua se marcarán con fecha de hoy como ausentes</h6>
            <table id="table-validate" class="table table-hover text-center" width="100%">
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
          <button type="submit" class="btn btn-outline-success form-control-sm float-left  mx-4 saveAssistance">CONTINUAR Y GUARDAR</button>
          <button type="button" class="btn btn-outline-tertiary  form-control-sm float-right mx-4" data-dismiss="modal">CANCELAR</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA EDITAR ASISTENCIA SELECCIONADA -->
<div class="modal fade" id="editAssistance-modal" style="font-size: 15px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="text-muted">SALIDAS DE ASISTENCIA:</h4><br>
        <span class="dateAssistance_hidden"></span>
      </div>
      <div class="modal-body">
        <div class="row py-3 border-top border-bottom">
          <div class="col-md-6 text-center">
            <small class="text-muted">
              <input type="radio" name="optionTable" value="absent">
              MOSTRAR ALUMNOS AUSENTES
            </small>
          </div>
          <div class="col-md-6 text-center">
            <small class="text-muted">
              <input type="radio" name="optionTable" value="present" checked>
              MOSTRAR ALUMNOS PRESENTES
            </small>
          </div>
        </div>
        <div class="row p-4">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">CURSO:</small>
              <span style="display: block" class="form-control form-control-sm course_info"></span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">CANTIDAD DE ALUMNOS:</small>
              <span style="display: block" class="form-control form-control-sm countStudent_info"></span>
            </div>
          </div>
        </div>
        <div class="row section-absent" style="display: none;">
          <div class="col-md-12">
            <h6 class="ed-title-table-come text-center m-3">TABLA DE AUSENTES</h6>
            <table class="table ed-table-absent" width="100%" style="font-size: 10px;">
              <thead>
                <th>ALUMNO</th>
                <th>IDENTIFICACION</th>
                <th>ACCIONES</th>
              </thead>
              <tbody>
                <!-- rows dinamics -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="row section-present">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <!-- SECCIONES DE VALORES (DIA ADICIONAL O MINUTOS ADICIONALES) -->
                <div class="row p-2">
                  <div class="col-md-6">
                    <div class="input-group valueDay-database" style="display: none;">
                      <small class="text-muted">VALOR DE UN DIA ADICIONAL:</small>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" name="valueDayAdditional_database" class="form-control form-control-sm text-center" readonly>
                      </div>
                    </div>
                    <div class="input-group valueDay-user" style="display: none;">
                      <small class="text-muted">ESPECIFIQUE VALOR DE UN DIA ADICIONAL: (Solo numeros)</small>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" name="valueDayAdditional_user" class="form-control form-control-sm text-center">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group valueMinute-database" style="display: none;">
                      <small class="text-muted">VALOR DE UN MINUTO ADICIONAL:</small>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" name="valueMinuteAdditional_database" class="form-control form-control-sm text-center" readonly>
                      </div>
                    </div>
                    <div class="input-group valueMinute-user" style="display: none;">
                      <small class="text-muted">ESPECIFIQUE VALOR DE UN MINUTO ADICIONAL: (Solo numeros)</small>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input type="number" name="valueMinuteAdditional_user" class="form-control form-control-sm text-center">
                      </div>
                    </div>
                  </div>
                </div>
                <h6 class="ed-title-table-out text-center m-3">TABLA DE ASISTENCIA</h6>
                <input type="hidden" name="idAssistance" class="form-control form-control-sm" readonly>
                @php $dateAdditional = Date('Y-m-d'); @endphp
                <input type="hidden" name="datenow-aditional" class="form-control form-control-sm" value="{{ $dateAdditional }}" readonly>

                <div class="alert alert-warning text-center msg-infoAssistanceFinal" style="display: none; font-size: 12px;"></div>
                <table class="table ed-table-present" width="100%" style="font-size: 10px;">
                  <thead>
                    <th>ALUMNO</th>
                    <th>LLEGADA</th>
                    <th>SALIDA</th>
                    <th>TEMPERATURA</th>
                    <th>OBSERVACION</th>
                  </thead>
                  <tbody>
                    <!-- row dinamics -->
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-md-12">
                <button type="button" class="btn btn-outline-success form-control-sm btn-saveFinalAssistance">ACTUALIZAR ASISTENCIA</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-outline-tertiary  form-control-sm float-right mx-4" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    var date = $('input[name=dateAssistance]').val();
    getAssistancesFilter(date);
    $('.bj-spinner').css('display', 'none');
    $('.bj-spinner-modal').css('display', 'none');
    $('#tableDatatable').css('display', 'inline-block');
    /* ===start/ MODAL DE NUEVA ASISTENCIA \start=== */
    var date = new Date();
    var mount = ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);
    var dateCompleted = date.getFullYear() + '-' + mount + '-' + date.getDate()
    $('input[name=assDate_hidden]').val(dateCompleted);
    $('input[name=assDate]').val(converterDateToString(dateCompleted));
    getValueDay();
    getValueMinute();
    /* ===end/ MODAL DE NUEVA ASISTENCIA \end=== */
  });

  $('.btn-refreshTable').on('click', function() {
    var date = $('input[name=dateAssistance]').val();
    getAssistancesFilter(date);
  });

  function getAssistancesFilter(date) {
    if (date != '') {
      $('.bj-spinner').css('display', 'block');
      $('#tableDatatable').css('display', 'none');
      $.get("{{ route('assistances.get') }}", {
        dateSelected: date
      }, function(objectAssistances) {
        var count = Object.keys(objectAssistances).length;
        $('#tableDatatable').DataTable().rows().remove().draw();
        var dateResult = date;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            var rownow = $('#tableDatatable').DataTable().row;
            if (objectAssistances[i][7] == 0) {
              rownow.add([
                objectAssistances[i][1], // CURSO
                "<h3 class='badge badge-danger' style='font-size: 15px;'>" + objectAssistances[i][2] + "</h3>",
                "<h3 class='badge badge-success' style='font-size: 15px;'>" + objectAssistances[i][3] + "</h3>",
                "<a href='#' class='btn btn-outline-primary form-control-sm btn-edit' title='EDITAR ASISTENCIA'><i class='fas fa-edit'></i><span hidden>" + objectAssistances[i][0] + "</span><span hidden>" + objectAssistances[i][1] + "</span><span hidden>" + (objectAssistances[i][2] + objectAssistances[i][3]) + "</span></a>"
              ]).draw(false).node().id = objectAssistances[i][0];
            } else {
              rownow.add([
                objectAssistances[i][1], // CURSO
                "<h3 class='badge badge-danger' style='font-size: 15px;'>" + objectAssistances[i][2] + "</h3>",
                "<h3 class='badge badge-success' style='font-size: 15px;'>" + objectAssistances[i][3] + "</h3>",
                "<button type='button' class='btn btn-outline-success form-control-sm' title='ASISTENCIA FINALIZADA'><i class='fas fa-check-circle'></i><span hidden>" + objectAssistances[i][0] + "</span><span hidden>" + objectAssistances[i][1] + "</span><span hidden>" + (objectAssistances[i][2] + objectAssistances[i][3]) + "</span></button>"
              ]).draw(false).node().id = objectAssistances[i][0];
            }

            if (i == 0) {
              dateResult = objectAssistances[i][4];
            }
          }
        }
        $('.bj-spinner').css('display', 'none');
        $('#tableDatatable').css('display', 'inline-block');
        $('h6.table-title').text('Asistencias del ' + converterDateToString(dateResult));
      });
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
          return day + ' de enero del ' + year;
          break;
        case '02':
          return day + ' de febrero del ' + year;
          break;
        case '03':
          return day + ' de marzo del ' + year;
          break;
        case '04':
          return day + ' de abril del ' + year;
          break;
        case '05':
          return day + ' de mayo del ' + year;
          break;
        case '06':
          return day + ' de junio del ' + year;
          break;
        case '07':
          return day + ' de julio del ' + year;
          break;
        case '08':
          return day + ' de agosto del ' + year;
          break;
        case '09':
          return day + ' de septiembre del ' + year;
          break;
        case '10':
          return day + ' de octubre del ' + year;
          break;
        case '11':
          return day + ' de noviembre del ' + year;
          break;
        case '12':
          return day + ' de diciembre del ' + year;
          break;
        default:
          return date;
      }
    } else {
      return date;
    }
  }

  /*===============================================================================
  	/ start \ EVENTOS DE LA VENTANA MODAL DE NUEVA ASISTENCIAS / start \
  ===============================================================================*/

  // ABRIR VENTANA MODAL
  $('.btn-newAssistance').on('click', function() {
    $('#newAssistance-modal').modal();
  });

  // SELECCIONA EL CURSO Y BUSCAR LOS ALUMNOS DE DICHO CURSO
  $('select[name=assCourse]').on('change', function(e) {
    $('#tableList tbody').empty();
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

  // SELECCIONAR UN ALUMNO Y VALIDAR LA JORNADA SEGUN EL CONTRATO
  $('select[name=assStudent]').on('change', function(e) {
    var studentSelected = e.target.value;
    if (studentSelected != '') {
      $.get("{{ route('getJourneyFromStudent') }}", {
        studentSelected: studentSelected
      }, function(objectJourney) {
        if (Object.keys(objectJourney).length > 0) {
          $('span.assIdJourney').text(objectJourney['id']);
          $('input[name=assJourney]').val(objectJourney['jouJourney'] + ' / ' + objectJourney['jouDays'] + ' / DE ' + objectJourney['jouHourEntry'] + ' A ' + objectJourney['jouHourExit']);
          //PONER LAS HORAS DEL CONTRATO EN LOS SPAN OCULTOS
          $('span.hourinitialLegalization').text('');
          $('span.hourinitialLegalization').text(objectJourney['jouHourEntry']);
          $('span.hourfinalLegalization').text('');
          $('span.hourfinalLegalization').text(objectJourney['jouHourExit']);
          var datenow = $('input[name=assDate_hidden]').val();
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
    var dateAssistance = $('input[name=assDate_hidden]').val();
    var idJourney = $('span.assIdJourney').text();
    var journey = $('input[name=assJourney]').val();
    var hourInitial = $('input[name=assHourinitial]').val();
    // var hourFinal = $('input[name=assHourfinal]').val();
    var hil = $('span.hourinitialLegalization').text(); //Hora inicial de legalización
    // var hfl = $('span.hourfinalLegalization').text(); //Hora final de legalización
    var observationArrival = $('textarea[name=assDescriptionArrival]').val();
    // var observationExit = $('textarea[name=assDescriptionExit]').val();
    var minutesValue = $('input[name=assAddMinute]').val();
    var assTempentry = $('input[name=assTempentry]').val();
    if (
      statusDayAdditional != '' && statusDayAdditional != null &&
      idStudent != '' && idStudent != null &&
      nameStudent != '' && nameStudent != null &&
      dateAssistance != '' && dateAssistance != null &&
      idJourney != '' && idJourney != null &&
      journey != '' && journey != null &&
      hourInitial != '' && hourInitial != null &&
      // hourFinal != '' && hourFinal != null &&
      hil != '' && hil != null &&
      // hfl != '' && hfl != null &&
      observationArrival != '' && observationArrival != null &&
      assTempentry != '' && assTempentry != null
      // observationExit != '' && observationExit != null
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
        // var hflS = hfl.split(':');
        // var hfsS = hourFinal.split(':');
        var datehil = new Date(dateControl.setHours(hilS[0], hilS[1]));
        var datehis = new Date(dateControl.setHours(hisS[0], hisS[1]));
        // var datehfl = new Date(dateControl.setHours(hflS[0],hflS[1]));
        // var datehfs = new Date(dateControl.setHours(hfsS[0],hfsS[1]));
        var come = '';
        // var out = '';
        var minutesCome = 0;
        // var minutesOut = 0;
        //COMPARANDO LAS HORAS Y MINUTOS DE LLEGADA
        if (datehis < datehil) {
          come = 'LLEGADA A TIEMPO';
        } else {
          if (datehis.getHours() > datehil.getHours()) {
            var hours = datehis.getHours() - datehil.getHours();
            var minutes = hours * 60;
            come = 'LLEGADA TARDE ..' + (datehis.getMinutes() + minutes) + '.. MINUTOS'; // SI LOS MINUTOS SUPERAN LOS QUINCE MINUTOS
          } else {
            if (datehis.getMinutes() > datehil.getMinutes() + 15) {
              come = 'LLEGADA TARDE ..' + datehis.getMinutes() + '.. MINUTOS'; // SI LOS MINUTOS SUPERAN LOS QUINCE MINUTOS
            } else {
              come = 'LLEGADA A TIEMPO'; // SI LOS MINUTOS DE LLEGADA SON MENORES O IGUAL A QUINCE
            }
          }
        }
        // if(datehfs < datehfl){
        // 	out = 'RECOGIDA A TIEMPO';
        // }else{
        // 	if(datehfs.getMinutes() > datehfl.getMinutes() + 15){
        // 		out = 'RECOGIDA TARDE ..' + datehfs.getMinutes() + '.. MINUTOS'; // SI LOS MINUTOS SUPERAN LOS QUINCE MINUTOS
        // 		$.get("{{ route('getValueMinutesAdditional') }}",{minutes: datehfs.getMinutes()},function(objectValueMinutes){
        // 			var count = Object.keys(objectValueMinutes).length;
        // 			if(count > 0){
        // 				$('.title-addMinute').attr('hidden',false);
        // 				$('.minuteAdditional').css('display','flex');
        // 				$('input[name=assAddMinute]').attr('disabled',true);
        // 				$('input[name=assAddMinute]').attr('type','text');
        // 				$('input[name=assAddMinute]').val(objectValueMinutes['jouValue']);
        // 			}else{
        // 				$('.title-addMinute').attr('hidden',false);
        // 				$('.minuteAdditional').css('display','flex');
        // 				$('input[name=assAddMinute]').attr('disabled',false);
        // 				$('input[name=assAddMinute]').attr('type','text');
        // 				$('input[name=assAddMinute]').val('');
        // 			}
        // 		});
        // 	}else{
        // 		out = 'RECOGIDA A TIEMPO'; // SI LOS MINUTOS DE LLEGADA SON MENORES O IGUAL A QUINCE
        // 	}
        // }

        $('#tableList tbody').append(
          '<tr>' +
          "<td><span hidden class='idstudent'>" + idStudent + "</span><span class='nameStudent'>" + nameStudent + "</span><span hidden class='statusDay'>" + statusDayAdditional + "</span><span hidden class='valueDay'>" + valueDayAdditional + "</span></td>" +
          '<td><span hidden>' + idJourney + '</span><span>' + journey + '</span></td>' +
          '<td>' + hourInitial + '</td>' +
          '<td>' + observationArrival + '</td>' +
          '<td>' + assTempentry + '</td>' +
          '<td>' + come + '</td>' +
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

  // ELIMINAR LA FILA SELECCIONADA DEL LISTADO (TABLA)
  $('#tableList').on('click', '.btnDeleteRow', function() {
    $(this).parents('tr').remove();
  });


  // BOTON PARA VALIDAR ASISTENCIA MOSTRANDO LISTADO DE LOS ALUMNOS QUE NO SE HAN AGREGADO
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
            $('#table-validate tbody').empty();
            if (count > 0) {
              for (var i = 0; i < count; i++) {
                $('#table-validate tbody').append(
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
            $('#table-validate tbody').empty();
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
  $("#newAssistance-modal").on('hidden.bs.modal', function() {
    $('.assistanceAll').css('display', 'none');
    $('.assistanceNotAll').css('display', 'none');
    $('#table-validate tbody').empty();
  });

  //BOTON PARA GUARDAR TODAS LAS FILAS DE LA TABLA EN LA BASE DE DATOS DE ASISTENCIAS
  $('.saveAssistance').on('click', function(e) {
    e.preventDefault();
    var present = [];
    var courseSelected = $('select[name=assCourse] option:selected').val();
    var dateAssistance = $('input[name=assDate_hidden]').val();
    $('#tableList tbody tr').each(function() {
      var idStudent = $(this).find('span.idstudent').text();
      var nameStudent = $(this).find('span.nameStudent').text();
      var statusDay = $(this).find('span.statusDay').text();
      var valueDay = $(this).find('span.valueDay').text();
      var idJourney = $(this).find('td:nth-child(2)').find('span:nth-child(1)').text();
      var journey = $(this).find('td:nth-child(2)').find('span:nth-child(2)').text();
      var hour = $(this).find('td:nth-child(3)').text();
      var observation = $(this).find('td:nth-child(4)').text();
      var temperature = $(this).find('td:nth-child(5)').text();
      var puntuality = $(this).find('td:nth-child(6)').text();
      var minuteAdditional = $('input[name=assAddMinute]').val();
      if (idStudent != null && idStudent != '' && idStudent != 'Undefined') {
        present.push([
          idStudent, // 0
          hour, // 1
          observation, // 2 OBSERVACION DE LLEGADA
          idJourney, // 3
          statusDay, // 4
          valueDay, // 5
          puntuality, // 6
          minuteAdditional, // 7
          temperature // 8 TEMPERATURA DE LLEGADA
        ]);
      }
    });
    var absent = [];
    $('#table-validate tbody tr').each(function() {
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
          $('.message-save').css('display', 'block');
          $('.message-save').addClass('alert-success');
          $('.message-save').removeClass('alert-warning');
          $('.message-save').html(response);
          setTimeout(function() {
            $('.message-save').css('display', 'none');
            $('.message-save').removeClass('alert-success');
            $('.message-save').removeClass('alert-warning');
            $('.message-save').html('');
          }, 30000);
        },
        complete: function() {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('#tableList tbody').empty();
          $('#table-validate tbody').empty();
          $('#newAssistance-modal').modal('hide');
        }
      });
    }
  });

  /*===============================================================================
  	/ end \ EVENTOS DE LA VENTANA MODAL DE NUEVA ASISTENCIAS / end \
  ===============================================================================*/


  /*===============================================================================
  	/ start \ EVENTOS DE LA VENTANA MODAL DE SALIDAS DE ASISTENCIAS / start \
  ===============================================================================*/

  // EVENTO PARA MOSTRAR VENTANA MODAL DE SALIDAS DE ASISTENCIA
  $('#tableDatatable').on('click', '.btn-edit', function(e) {
    e.preventDefault();
    var assId = $(this).find('span:nth-child(2)').text();
    var course = $(this).find('span:nth-child(3)').text();
    var countStudent = $(this).find('span:nth-child(4)').text();
    if (assId != '') {
      $('input[name=idAssistance]').val(assId);
      $.get("{{ route('getAssistancesForedit') }}", {
        assId: assId
      }, function(objectAssistance) {
        var count = Object.keys(objectAssistance).length;
        $('.ed-table-absent tbody').empty();
        $('.ed-table-present tbody').empty();
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            if (objectAssistance[i][0] == 'FECHA') {
              $('.dateAssistance_hidden').text(objectAssistance[i][1]);
            }
            if (objectAssistance[i][0] == 'PRESENTE') {
              $('.ed-table-present tbody').append(
                "<tr id='" + objectAssistance[i][1] + "' class='" + objectAssistance[i][4] + "-" + objectAssistance[i][5] + "'>" + // id de estudiante
                "<td>" + objectAssistance[i][2] + "</td>" + // Nombre del estudiante
                "<td>" + objectAssistance[i][3] + "</td>" + // Hora y observaciones de salida
                "<td>" +
                "<input type='time' class='form-control form-control-sm hour-out' title='HORA DE SALIDA'><span hidden class='countMinutes'>0</span><span hidden class='badge badge-danger showMessage'>SALIDA TARDE</span>" +
                "</td>" +
                "<td>" +
                "<input type='text' class='form-control form-control-sm temp-out' data-tempin='" + objectAssistance[i][6] + "' maxlength='4' title='Ingrese número decimal con puntos (00.0)' placeholder='00.0'>" +
                "</td>" +
                "<td><input type='text' maxlength='500' class='form-control form-control-sm observation-out' title='OBSERVACION DE SALIDA'></td>" +
                "</tr>"
              );
            } else if (objectAssistance[i][0] == 'AUSENTE') {
              if (objectAssistance[i][6] != null && objectAssistance[i][6] == 'ADICIONAL') {
                $('.ed-table-absent tbody').append(
                  "<tr id='" + objectAssistance[i][1] + "A' class='" + objectAssistance[i][4] + "-" + objectAssistance[i][5] + "'>" + // id de estudiante
                  "<td>" + objectAssistance[i][2] + "<span class='badge badge-success ml-2'>NO DEBE ASISTIR<span></td>" + // Nombre de estudiante
                  "<td>" + objectAssistance[i][3] + "</td>" + // Numero de documento
                  "<td><button type='button' class='btn btn-outline-tertiary  btn-addStudentToPresent' title='AGREGAR ALUMNO COMO PRESENTE CON DIA ADICIONAL'><i class='fas fa-redo-alt'></i></button></td>" +
                  "</tr>"
                );
              } else {
                $('.ed-table-absent tbody').append(
                  "<tr id='" + objectAssistance[i][1] + "' class='" + objectAssistance[i][4] + "-" + objectAssistance[i][5] + "'>" + // id de estudiante
                  "<td>" + objectAssistance[i][2] + "</td>" + // Nombre de estudiante
                  "<td>" + objectAssistance[i][3] + "</td>" + // Numero de documento
                  "<td><button type='button' class='btn btn-outline-success form-control-sm btn-addStudentToPresent' title='AGREGAR ALUMNO COMO PRESENTE'><i class='fas fa-redo-alt'></i></button></td>" +
                  "</tr>"
                );

              }
            }
          }
        }
      });
    }
    $('.course_info').text(course);
    $('.countStudent_info').text(countStudent);
    $('#editAssistance-modal').modal();
  });

  $('body').on('keyup', '.temp-out', function(e) {
    let value = e.target.value;
    if (value.length == 2) {
      value = value + '.';
    }
    $(this).val(value);
  });

  $('input[name=assTempentry]').on('keyup', function(e) {
    let value = e.target.value;
    if (value.length == 2) {
      value = value + '.';
    }
    $(this).val(value);
  });

  // EVENTO PARA OCULTAR TABLAS DE MODAL DE SALIDAS
  $('input[name=optionTable]').on('click', function(e) {
    var value = e.target.value;
    switch (value) {
      case 'absent':
        $('.section-absent').css('display', 'block');
        $('.section-present').css('display', 'none');
        break;
      case 'present':
        $('.section-absent').css('display', 'none');
        $('.section-present').css('display', 'block');
        break;
    }
  });

  // AGREGAR ALUMNOS DE TABLA DE AUSENTES HACIA TABLA PRESENTES:
  $('.ed-table-absent').on('click', '.btn-addStudentToPresent', function() {
    var getStudent = $(this).parents('tr').attr('id');
    var classHours = $(this).parents('tr').attr('class');
    var findA = getStudent.indexOf('A');
    var nameStudent = $(this).parents('tr').find('td:nth-child(1)').text();
    var idStudent;
    if (findA > -1) {
      idStudent = getStudent.slice(0, -1);
      $('.ed-table-present tbody').append(
        "<tr id='" + idStudent + "' class='fromAbsent " + classHours + "'>" + // id de estudiante
        "<td class='ADITIONAL'>" + nameStudent.split("NO DEBE ASISTIR").join("") + "<span class='badge badge-primary ml-2'>DIA ADICIONAL<span>" + "</td>" + // Nombre del estudiante
        "<td>" +
        "<input type='time' class='form-control form-control-sm text-center hour-come' title='HORA DE LLEGADA'><span hidden class='countMinutes'>0</span><span hidden class='badge badge-danger showMessage'>LLEGADA TARDE</span>" +
        "<input type='text' maxlength='500' class='form-control form-control-sm observation-come' title='OBSERVACION DE LLEGADA'>" +
        "</td>" + // Hora y observaciones de llegada
        "<td><input type='time' class='form-control form-control-sm text-center hour-out' title='HORA DE SALIDA'><span hidden class='countMinutes'>0</span><span hidden class='badge badge-danger showMessage'>SALIDA TARDE</span></td>" +
        "<td><input type='text' maxlength='500' class='form-control form-control-sm observation-out' title='OBSERVACION DE SALIDA'></td>" +
        "</tr>"
      );
    } else {
      idStudent = getStudent;
      $('.ed-table-present tbody').append(
        "<tr id='" + idStudent + "' class='fromAbsent " + classHours + "'>" + // id de estudiante
        "<td>" + nameStudent + "</td>" + // Nombre del estudiante
        "<td>" +
        "<input type='time' class='form-control form-control-sm text-center hour-come' title='HORA DE LLEGADA'><span hidden class='countMinutes'>0</span><span hidden class='badge badge-danger showMessage'>LLEGADA TARDE</span>" +
        "<input type='text' maxlength='500' class='form-control form-control-sm observation-come' title='OBSERVACION DE LLEGADA'>" +
        "</td>" + // Hora y observaciones de llegada
        "<td><input type='time' class='form-control form-control-sm text-center hour-out' title='HORA DE SALIDA'><span hidden class='countMinutes'>0</span><span hidden class='badge badge-danger showMessage'>SALIDA TARDE</span></td>" +
        "<td><input type='text' maxlength='500' class='form-control form-control-sm observation-out' title='OBSERVACION DE SALIDA'></td>" +
        "</tr>"
      );
    }

    $(this).parents('tr').remove();
  });

  $('.ed-table-present').on('keyup', '.hour-out', function() {
    var entrySelected = $(this).val();
    if (entrySelected != '' && entrySelected != '00:00') {
      var hourLegalization, minutesLegalization, hourSelected, minutesSelected;
      hourSelected = parseInt(entrySelected.slice(0, -3));
      minutesSelected = parseInt(entrySelected.slice(3));
      var classHours = $(this).parents('tr').attr('class');
      var findClass = classHours.indexOf('fromAbsent');
      if (findClass > -1) {
        var onlyHour = classHours.split(' ');
        var range = onlyHour[1].split('-');
        hourLegalization = parseInt(range[1].slice(0, -6));
        minutesLegalization = parseInt(range[1].slice(3, -3));
      } else {
        var range = classHours.split('-');
        hourLegalization = parseInt(range[1].slice(0, -6));
        minutesLegalization = parseInt(range[1].slice(3, -3));
      }

      if (hourSelected <= hourLegalization) {
        if (hourSelected < hourLegalization) {
          // LLEGADA TEMPRANO
          $(this).parent('td').find('.countMinutes').text(0);
          $(this).parent('td').find('.showMessage').attr('hidden', true);
        } else {
          if (minutesSelected <= (minutesLegalization + 15)) {
            // LLEGADA TEMPRANO ANTES DE LOS 15 MINUTOS
            $(this).parent('td').find('.countMinutes').text(0);
            $(this).parent('td').find('.showMessage').attr('hidden', true);
          } else {
            //VAOLIDAR SI LA HORA DE LA LEGALIZACION ES => Y MEDIA
            if (minutesLegalization == 30) {
              // LLEGADA TARDE EXCEDIDA DE 15 MINUTOS
              $(this).parent('td').find('.countMinutes').text(minutesSelected - minutesLegalization);
              $(this).parent('td').find('.showMessage').attr('hidden', false);
            } else {
              // LLEGADA TARDE EXCEDIDA DE 15 MINUTOS
              $(this).parent('td').find('.countMinutes').text(minutesSelected);
              $(this).parent('td').find('.showMessage').attr('hidden', false);
            }
          }
        }
      } else {
        // LLEGADA TARDE POR MAS DE UNA HORA
        var hourCount = hourSelected - hourLegalization;
        var minutesCount = (60 * hourCount) + minutesSelected;
        $(this).parent('td').find('.countMinutes').text(minutesCount);
        $(this).parent('td').find('.showMessage').attr('hidden', false);
      }

    }
  });

  $('.ed-table-present').on('keyup', '.hour-come', function() {
    var exitSelected = $(this).val();
    if (exitSelected != '' && exitSelected != '00:00') {
      var hourLegalization, minutesLegalization, hourSelected, minutesSelected;
      hourSelected = parseInt(exitSelected.slice(0, -3));
      minutesSelected = parseInt(exitSelected.slice(3));
      var classHours = $(this).parents('tr').attr('class');
      var findClass = classHours.indexOf('fromAbsent');
      if (findClass > -1) {
        var onlyHour = classHours.split(' ');
        var range = onlyHour[1].split('-');
        hourLegalization = parseInt(range[0].slice(0, -6));
        minutesLegalization = parseInt(range[0].slice(3, -3));
      } else {
        var range = classHours.split('-');
        hourLegalization = parseInt(range[0].slice(0, -6));
        minutesLegalization = parseInt(range[0].slice(3, -3));
      }

      if (hourSelected <= hourLegalization) {
        if (hourSelected < hourLegalization) {
          // LLEGADA TEMPRANO
          $(this).parent('td').find('.countMinutes').text(0);
          $(this).parent('td').find('.showMessage').attr('hidden', true);
        } else {
          if (minutesSelected <= (minutesLegalization + 15)) {
            // LLEGADA TEMPRANO ANTES DE LOS 15 MINUTOS
            $(this).parent('td').find('.countMinutes').text(0);
            $(this).parent('td').find('.showMessage').attr('hidden', true);
          } else {
            // LLEGADA TARDE EXCEDIDA DE 15 MINUTOS
            $(this).parent('td').find('.countMinutes').text(minutesSelected);
            $(this).parent('td').find('.showMessage').attr('hidden', false);
          }
        }
      } else {
        // LLEGADA TARDE POR MAS DE UNA HORA
        var hourCount = hourSelected - hourLegalization;
        var minutesCount = (60 * hourCount) + minutesSelected;
        $(this).parent('td').find('.countMinutes').text(minutesCount);
        $(this).parent('td').find('.showMessage').attr('hidden', false);
      }

    }
  });



  function getValueDay() {
    $.get("{{ route('getJourneyDayAdditional') }}", function(objectValueAdditional) {
      if (objectValueAdditional != null && Object.keys(objectValueAdditional).length) {
        $('.valueDay-database').css('display', 'block');
        $('.valueDay-user').css('display', 'none');
        $('input[name=valueDayAdditional_database]').val(objectValueAdditional['jouValue']);
        $('input[name=valueDayAdditional_user]').val('');
      } else {
        $('input[name=valueDayAdditional_database]').val('');
        $('.valueDay-database').css('display', 'none');
        $('.valueDay-user').css('display', 'block');
      }
    });
  }

  function getValueMinute() {
    $.get("{{ route('getValueMinutesAdditional') }}", function(objectValueMinutes) {
      if (objectValueMinutes != null && Object.keys(objectValueMinutes).length) {
        $('.valueMinute-database').css('display', 'block');
        $('.valueMinute-user').css('display', 'none');
        $('input[name=valueMinuteAdditional_database]').val(objectValueMinutes['jouValue']);
        $('input[name=valueMinuteAdditional_user]').val('');
      } else {
        $('.valueMinute-database').css('display', 'none');
        $('.valueMinute-user').css('display', 'block');
        $('input[name=valueMinuteAdditional_database]').val('');
      }
    });
  }

  $('.btn-saveFinalAssistance').on('click', function() {
    var presentStudents = '';
    var absentStudent = '';
    var dayAdditionalStudent = '';
    var countMinutes = '';
    var validate = true;
    var valuedayAdditional;
    var valueMinutes;
    var idsAbsents = ''; // Variable par aguardar ids de alumnos
    // VALIDAR EL CAMPO DEL VALOR DEL CADA MINUTO ADICIONAL
    var validateValueday = $('.valueDay-database').css('display');
    if (validateValueday == 'none') {
      valuedayAdditional = $('input[name=valueDayAdditional_user]').val();
    } else if (validateValueday == 'block') {
      valuedayAdditional = $('input[name=valueDayAdditional_database]').val();
    }
    // VALIDAR EL CAMPO DEL VALOR DEL DIA ADICIONAL
    var validateValueminute = $('.valueMinute-database').css('display');
    if (validateValueminute == 'none') {
      valueMinutes = $('input[name=valueMinuteAdditional_user]').val();
    } else if (validateValueminute == 'block') {
      valueMinutes = $('input[name=valueMinuteAdditional_database]').val();
    }

    if (valuedayAdditional > 0 || valuedayAdditional != '' && valueMinutes > 0 || valueMinutes != '') {
      $('.ed-table-present tbody tr').each(function() {
        if (validate) {
          var classRow = $(this).attr('class');
          var findClass = classRow.indexOf('fromAbsent');
          if (findClass < 0) {
            var hourOut = $(this).find('td:nth-child(3)').find('input').val();
            var observationOut = $(this).find('td:nth-child(5)').find('input').val();
            if (hourOut != '' && hourOut != '00:00' && observationOut != '') {
              var idStudent = $(this).attr('id');
              var hourObservation = $(this).find('td:nth-child(2)').text().split(' ==> ');
              var hourCome = hourObservation[0];
              var observationCome = hourObservation[1];
              var minutes = parseInt($(this).find('td:nth-child(3)').find('.countMinutes').text());
              var tempOut = $(this).find('td:nth-child(4)').find('input.temp-out').val();
              var tempIn = $(this).find('td:nth-child(4)').find('input.temp-out').attr('data-tempin');
              if (minutes > 15) {
                countMinutes += idStudent + '=>' + minutes + '=>MINUTES-';
              }
              presentStudents += idStudent + '/' + hourCome + '/' + hourOut + '/' + observationCome + '/' + observationOut + '/' + tempIn + '/' + tempOut + '%';
            } else {
              validate = false;
            }
          } else {
            var hourOut = $(this).find('td:nth-child(3)').find('input').val();
            var observationOut = $(this).find('td:nth-child(5)').find('input').val();
            var hourCome = $(this).find('td:nth-child(2)').find('input:nth-child(1)').val();
            var observationCome = $(this).find('td:nth-child(2)').find('input:nth-child(2)').val();
            var tempOut = $(this).find('td:nth-child(4)').find('input.temp-out').val();
            if (hourOut != '' && hourOut != '00:00' && observationOut != '' && hourCome != '' && hourCome != '00:00' && observationCome != '' && tempOut != '') {
              var idStudent = $(this).attr('id');
              var aditional = $(this).find('td:nth-child(1)').attr('class');
              if (aditional == 'ADITIONAL') {
                dayAdditionalStudent += idStudent + '=>ADITIONAL-';
              }
              var minutes = parseInt($(this).find('td:nth-child(3)').find('.countMinutes').text());
              if (minutes > 15) {
                countMinutes += idStudent + '=>' + minutes + '=>MINUTES-';
              }
              presentStudents += idStudent + '/' + hourCome + '/' + hourOut + '/' + observationCome + '/' + observationOut + '/' + tempIn + '/' + tempOut + '%';
            } else {
              validate = false;
            }
          }
        }
      });
    } else {
      validate = false;
    }
    // RECORRER TABLA DE PRESENTES VALIDANDO QUE NO HALLAN CAMPOS VACIOS

    if (!validate) {
      $('.msg-infoAssistanceFinal').css('display', 'block');
      $('.msg-infoAssistanceFinal').html('COMPLETE LOS CAMPOS DEL VALOR DEL DIA ADICIONAL, MINUTO ADICIONAL, Y DE LLEGADA Y/O SALIDA PARA CADA ALUMNO');
      setTimeout(function() {
        $('.msg-infoAssistanceFinal').css('display', 'none');
        $('.msg-infoAssistanceFinal').html('');
      }, 5000);
    } else {
      // RECORRER TABLA DE AUSENTES PARA OBTENER IDS DE ALUMNOS
      $('.ed-table-absent tbody tr').each(function() {
        idsAbsents += $(this).attr('id') + '-';
      });
      if (idsAbsents != '') {
        absentStudent = idsAbsents.substring(0, (idsAbsents.length - 1));
      }
    }
    var assId = $('input[name=idAssistance]').val();
    var dateAdditional = $('input[name=datenow-aditional]').val();

    if (presentStudents != '' && assId != '') {
      $.ajax({
        url: "{{ route('assistances.final') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          presentStudents: presentStudents.slice(0, -1),
          absentStudent: absentStudent,
          dayAdditionalStudent: dayAdditionalStudent.slice(0, -1),
          assId: assId,
          date: dateAdditional,
          valuedayAdditional: valuedayAdditional,
          valueMinutes: valueMinutes,
          countMinutes: countMinutes.slice(0, -1)
        },
        beforeSend: function() {

        },
        complete: function(objectResponse) {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('#editAssistance-modal').modal('hide');
          var date = $('.dateAssistance_hidden').text();
          $('input[name=dateAssistance]').val(date);

          $('.message-save').css('display', 'block');
          $('.message-save').addClass('alert-success');
          $('.message-save').removeClass('alert-warning');
          $('.message-save').append('LISTADO ACTUALIZADO CORRECTAMENTE');
          setTimeout(function() {
            $('.message-save').css('display', 'none');
            $('.message-save').removeClass('alert-success');
            $('.message-save').removeClass('alert-warning');
            $('.message-save').empty();
          }, 30000);

          getAssistancesFilter(date);

        }
      });
    }
  });

  /*===============================================================================
  	/ end \ EVENTOS DE LA VENTANA MODAL DE SALIDAS DE ASISTENCIAS / end \
  ===============================================================================*/
</script>
@endsection