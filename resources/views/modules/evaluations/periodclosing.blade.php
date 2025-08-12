@extends('modules.evaluation')

@section('academicModules')
<div class="col-md-12">
  <div class="row py-3 border-top border-bottom">
    <div class="col-md-6">
      <h5>CIERRE DE PERIODOS ACADEMICOS</h5>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de seguimientos semanales -->
      @if(session('SuccessSavePeriodClose'))
      <div class="alert alert-success">
        {{ session('SuccessSavePeriodClose') }}
      </div>
      @endif
      @if(session('SecondarySavePeriodClose'))
      <div class="alert alert-secondary">
        {{ session('SecondarySavePeriodClose') }}
      </div>
      @endif
      <div class="alert message"></div>
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
        <input type="hidden" name="infoIdCourseStudent" class="form-control form-control-sm" disabled>
        <input type="text" name="infoCourseStudent" class="form-control form-control-sm" disabled>
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
  <div class="row sectionsBases">
    <!-- tables dinamics -->
  </div>
</div>

<!-- MODAL PARA VER DETALLES Y FILTRAR DESCARGAR PDF -->
<div class="modal fade" id="observations-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content px-4 py-4">
      <form action="{{ route('weeklyTracking.save') }}" method="POST">
        @csrf
        <div class="modal-header row">
          <div class="col-md-12">
            <div class="row border-bottom mb-2">
              <div class="col-md-6">
                <small class="nameCourse-modal"></small><br>
                <input type="hidden" name="idCourse_modalObservation" class="form-control form-control-sm" readonly required>
                <small class="namePeriod-modal"></small><br>
                <input type="hidden" name="idPeriod_modalObservation" class="form-control form-control-sm" readonly required>
                <small class="nameStudent-modal"></small>
                <input type="hidden" name="idStudent_modalObservation" class="form-control form-control-sm" readonly required>
              </div>
              <div class="col-md-6 bg-default">
                <small class="text-muted">NOTA DEFINITIVA:</small>
                <h2 class="noteFinal-modalObservation"></h2>
                <input type="hidden" name="idsTrackingsNotes_modalObservation" class="form-control form-control-sm" readonly required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <small class="text-muted">INTELIGENCIA:</small>
                  <select name="taIntelligence_id" class="form-control form-control-sm select2">
                    <option value="">Seleccione una inteligencia...</option>
                    <!-- options dinamics -->
                  </select>
                </div>
                <div class="form-group">
                  <small class="text-muted">OBSERVACION:</small>
                  <select name="taObservation_id" class="form-control form-control-sm select2">
                    <option value="">Seleccione una observación...</option>
                    <!-- options dinamics -->
                  </select>
                </div>
                <div class="form-group text-center">
                  <button type="button" class="btn btn-outline-success form-control-sm btn-addObservation" title='AGREGUE OBSERVACIONES A LA TABLA PARA ESTE PERIODO'>AGREGAR</button>
                  <small class="infoRepeat" style="display: none; transition: all .2s; color: red;"></small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table text-center tableObservations" style="font-size: 12px;">
                  <thead>
                    <th>NUMERO</th>
                    <th>OBSERVACION</th>
                    <th>INTELIGENCIA</th>
                    <th></th>
                  </thead>
                  <tbody class="listObservations">
                    <!-- rows dinamics -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <input type="hidden" name="rowsObservations" class="form-control form-control-sm" readonly>
          <button type="submit" class="btn btn-outline-success mx-3 form-control-sm btn-saveDefinitive">CONTINUAR Y GUARDAR</button>
          <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // var infoWeeks = [];
  // var infoAchievements = [];
  var idsIntelligences = [];

  $(function() {
    $('.spinner-border').css('display', 'none');
    $('.message').css('display', 'none');
  });

  $('select[name=pcStudent]').on('change', function(e) {
    var studentSelected = e.target.value;
    $('input[name=infoIdStudent]').val('');
    $('input[name=infoCourseStudent]').val('');
    $('input[name=infoIdCourseStudent]').val('');
    $('select[name=pcPeriod]').empty();
    $('select[name=pcPeriod]').append("<option value=''>Seleccione un periodo...</option>");
    $('.sectionsBases').empty();
    $('.sectionsBases').css('display', 'none');
    idsIntelligences.length = 0;
    if (studentSelected != '') {
      var infoStudent = [];
      $.get("{{ route('getInfoBasicStudentPeriodClosing') }}", {
        studentSelected: studentSelected
      }, function(response) {
        var count = Object.keys(response).length;
        if (count > 0) {
          $('input[name=infoIdStudent]').val(response[0]['documentStudent']);
          $('input[name=infoCourseStudent]').val(response[0]['nameCourse']);
          $('input[name=infoIdCourseStudent]').val(response[0]['idCourse']);
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
    $('.spinner-border').css('display', 'block');
    $('.sectionsBases').empty();
    $('.sectionsBases').css('display', 'none');
    idsIntelligences.length = 0;
    if (periodSelected != '' && studentSelected != '') {
      $.get("{{ route('getAchievementAll') }}", {
        apId: periodSelected,
        stId: studentSelected
      }, function(objectTrackings) {
        var count = Object.keys(objectTrackings).length;
        if (count > 0) {
          var contentAll = "<table class='table text-center my-3 tableUp' width='100%'>" +
            "<thead style='background-color: #ccc'>" +
            "<tr>" +
            "<th><h5>DEFINITIVA HASTA LA FECHA:</h5></th>" +
            "<th><h6 class='noteFinal' style='font-size: 20px; font-weight: bold;'>0</h6></th>" +
            "</tr>"
          "</thead>" +
          "</table>";
          var totalAll = 0;
          var notesCount = 0;
          for (var i = 0; i < count; i++) {
            var contentItem = '';
            var totalItem = 0;
            var countItem = 0;
            var validateRepeatWeekly = '';
            for (var m = 0; m < objectTrackings[i][2].length; m++) {
              /*
              	objectTrackings[i][2][m][0] => id de weeklytracking
              	objectTrackings[i][2][m][1] => cantidad de actividades
              	objectTrackings[i][2][m][2] => ids de actividades
              	objectTrackings[i][2][m][3] => name de logro
              	objectTrackings[i][2][m][4] => nota de logro
              	objectTrackings[i][2][m][5] => estado de logro
              */
              var findWeekly = validateRepeatWeekly.indexOf(objectTrackings[i][2][m][0]);
              if (findWeekly < 0) {
                // Calculos de todos los logros para la nota definitiva
                // Calculos para el promedio por inteligencia
                totalItem += parseInt(objectTrackings[i][2][m][4]);
                countItem++;
                contentItem += "<tr id='" + objectTrackings[i][2][m][0] + "'>" +
                  "<td class='" + objectTrackings[i][2][m][2] + "'>" +
                  "<h5 class='badge badge-info'>" + objectTrackings[i][2][m][1] + "</h5>" +
                  "</td>" +
                  "<td>" +
                  objectTrackings[i][2][m][3] +
                  "<input type='range' class='form-control form-control-sm progress-bar progress-bar-striped bg-warning ml-2 porcentageRange' value='" + objectTrackings[i][2][m][4] + "' min='0' max='100' step='1' style='font-weight: bold; font-size: 20px; width: 500px; max-width: 500px;' hidden>" +
                  "</td>" +
                  "<td colspan='2'>" +
                  "<span class='porcentageNumber mr-2' style='color: #000; font-weight: bold;'>" + objectTrackings[i][2][m][4] + "%</span>" +
                  "<span class='form-control form-control-sm badge badge-danger' style='color: #fff; font-weight: bold; width: 120px; max-width: 120px;'>" + objectTrackings[i][2][m][5] + "</span>" +
                  "</td>" +
                  "</tr>";
                validateRepeatWeekly += objectTrackings[i][2][m][0] + ':';
              }
            }
            var average = Math.round(totalItem / countItem);
            totalAll += average;
            notesCount++;
            contentAll += "<table class='table text-center my-3 tableIntelligence' width='100%'>" +
              "<thead style='background-color: #ccc'>" +
              "<tr>" +
              "<th colspan='2'><h5>" + objectTrackings[i][1] + "</h5></th>" +
              "<th style='background-color: #000; color: #fff; border-radius: 5px; font-weight: bold;'>PROMEDIO</th>" +
              "<th style='background-color: #000; color: #fff; border-radius: 5px; font-weight: bold;'>" + average + "</th>" +
              "</tr>" +
              "<tr style='background-color: #E0E0E0'>" +
              "<th>Q ACTIVIDADES</th>" +
              "<th>LOGRO</th>" +
              "<th colspan='2'>ESTADO</th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>" +
              contentItem +
              "</tbody>" +
              "</table>";
            // VAariable global que capturas los ids de las inteligencias
            idsIntelligences.push(objectTrackings[i][0]);
          }
          contentAll += "<table class='table text-center my-3 tableUp' width='100%'>" +
            "<thead style='background-color: #ccc'>" +
            "<tr>" +
            "<th><h5>DEFINITIVA HASTA LA FECHA:</h5></th>" +
            "<th><h6 class='noteFinal' style='font-size: 20px; font-weight: bold;'>0</h6></th>" +
            "<th><button type='button' class='btn btn-outline-success form-control-sm btn-saveNotes'>GUARDAR PROCESO</button></th>" +
            "</tr>"
          "</thead>" +
          "</table>";
          $('.sectionsBases').append(contentAll);
          var noteFinal = Math.round(totalAll / notesCount);
          $('.noteFinal').text(noteFinal);
          $('.tableIntelligence').each(function() {
            $(this).find('tbody').find('tr').each(function() {
              var note = $(this).find('td:nth-child(3)').find('span:nth-child(1)').text();
              var spanStatus = $(this).find('td:nth-child(3)').find('span:nth-child(2)');
              changeStatus(note.slice(0, -1), spanStatus);
            });
          });
          $('.spinner-border').css('display', 'none');
          $('.sectionsBases').css('display', 'flex');
        }
      });
    } else {
      idsIntelligences.length = 0;
      $('.spinner-border').css('display', 'none');
    }
  });

  // EVENTO PARA ABRIR MODAL Y LLENAR AUTOMATICAMENTE FORMULARIO DE MODAL
  $('.sectionsBases').on('click', '.btn-saveNotes', function() {
    //COMPLETAR TITULOS Y CAMPOS OCULTOS
    var idTrackAndNote = '';
    $('.sectionsBases').find('.tableIntelligence').each(function() {
      $(this).find('tbody').find('tr').each(function() {
        var id = $(this).attr('id');
        var note = $(this).find('td:last').find('.porcentageNumber').text();
        idTrackAndNote += id + '=>' + note.slice(0, -1) + ',';
      });
    });
    $('input[name=idsTrackingsNotes_modalObservation]').val(idTrackAndNote.slice(0, -1));
    var idCourse = parseInt($('input[name=infoIdCourseStudent]').val());
    var idPeriod = parseInt($('select[name=pcPeriod] option:selected').val());
    var idStudent = parseInt($('select[name=pcStudent] option:selected').val());
    $('.nameCourse-modal').text($('input[name=infoCourseStudent]').val());
    $('input[name=idCourse_modalObservation]').val(idCourse);
    $('.namePeriod-modal').text($('select[name=pcPeriod] option:selected').text());
    $('input[name=idPeriod_modalObservation]').val(idPeriod);
    $('.nameStudent-modal').text($('select[name=pcStudent] option:selected').text());
    $('input[name=idStudent_modalObservation]').val(idStudent);
    $('.noteFinal-modalObservation').text($('.sectionsBases').find('.noteFinal:last').text());
    // LLENAR SELECT DE INTELIGENCIAS PERMITIDAS		
    $('select[name=taIntelligence_id]').empty();
    $('select[name=taIntelligence_id]').append("<option value=''>Seleccione una inteligencia...</option>");
    $.get("{{ route('getIntelligenceFromArray') }}", {
      ids: idsIntelligences
    }, function(objectIntelligences) {
      var count = Object.keys(objectIntelligences).length;
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          $('select[name=taIntelligence_id]').append(
            '<option value=' + objectIntelligences[i]['id'] + '>' + objectIntelligences[i]['type'] + '</option>'
          );
        }
      }
    });
    // LLENAR TABLA DE OBSERVACIONES CON LAS OBSERVACIONES EXISTENTES DEL PERIODO (Tabla trackingachievement)
    $.get(
      "{{ route('getObservationsFromPeriod') }}", {
        idCourse: idCourse,
        idPeriod: idPeriod,
        idStudent: idStudent
      },
      function(objectObservations) {
        $('.tableObservations').find('tbody').empty();
        var count = Object.keys(objectObservations).length;
        if (count > 0) {
          for (var o = 0; o < count; o++) {
            $('.tableObservations').find('tbody').append(
              "<tr class='" + objectObservations[o][0] + "' data-idObservation='" + objectObservations[o][0] + "'>" +
              "<td>" + objectObservations[o][1] + "</td>" +
              "<td>" + objectObservations[o][2] + "</td>" +
              "<td>" + objectObservations[o][3] + "</td>" +
              "<td>" +
              "<button type='button' class='btn btn-outline-tertiary  form-control-sm btn-deleteObservations'><i class='fas fa-trash-alt'></i></button>" +
              "</td>" +
              "</tr>"
            );
          }
        }
      }
    );

    $('#observations-modal').modal();
  });

  // LLENAR SELECT DE OBSERVACIONES DE ACUERDO A LA INTELIGENCIA SELECCIONADA
  $('select[name=taIntelligence_id]').on('change', function(e) {
    var value = e.target.value;
    $('select[name=taObservation_id]').empty();
    $('select[name=taObservation_id]').append("<option value=''>Seleccione una observación...</option>");
    if (value != '') {
      $.get("{{ route('getObservationsFromIntelligence') }}", {
        idIntelligence: value
      }, function(objectsObservations) {
        var count = Object.keys(objectsObservations).length;
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=taObservation_id]').append(
              '<option value=' + objectsObservations[i]['obsId'] + '>' + objectsObservations[i]['obsNumber'] + ' - ' + objectsObservations[i]['obsDescription'] + '</option>'
            );
          }
        }
      });
    }
  });

  // BOTON PARA AGREGAR OBSERVACIONES EN TABLA
  $('.btn-addObservation').on('click', function() {
    var intId = $('select[name=taIntelligence_id]').val();
    var intelligence = $('select[name=taIntelligence_id] option:selected').text();
    var obsId = $('select[name=taObservation_id]').val();
    var text = $('select[name=taObservation_id] option:selected').text();
    var observation = text.split(' - ');
    var obsNumber = observation[0];
    var obsDescription = observation[1];
    var validateRepet = false;
    $('.tableObservations').find('tbody').find('tr').each(function() {
      var id = $(this).attr('class');
      if (id == obsId) {
        validateRepet = true;
      }
    });
    if (intId != '' && obsId != '') {
      if (validateRepet == false) {
        $('.tableObservations').find('tbody').append(
          "<tr class='" + obsId + "' data-idObservation='" + obsId + "'>" +
          "<td>" + obsNumber + "</td>" +
          "<td>" + obsDescription + "</td>" +
          "<td>" + intelligence + "</td>" +
          "<td>" +
          "<button type='button' class='btn btn-outline-tertiary  form-control-sm btn-deleteObservations'><i class='fas fa-trash-alt'></i></button>" +
          "</td>" +
          "</tr>"
        );
      } else {
        $('.infoRepeat').css('display', 'block');
        $('.infoRepeat').text('Observación repetida');
        setTimeout(function() {
          $('.infoRepeat').css('display', 'none');
          $('.infoRepeat').text('');
        }, 3000);
      }
    } else {
      $('.infoRepeat').css('display', 'block');
      $('.infoRepeat').text('Seleccione inteligencia y observación');
      setTimeout(function() {
        $('.infoRepeat').css('display', 'none');
        $('.infoRepeat').text('');
      }, 3000);
    }
  });

  // BOTON DE TABLA DE OBSERVACIONES PARA CAMBIAR ESTADO DE FILAS (Para eliminar)
  $('.tableObservations').on('click', '.btn-deleteObservations', function() {
    $(this).empty();
    $(this).html("<li class='fas fa-redo-alt'></li>");
    $(this).removeClass('btn btn-outline-tertiary ');
    $(this).addClass('btn-addObservations');
    $(this).addClass('btn btn-outline-primary');
    var classRow = $(this).parents('tr').attr('data-idObservation');
    var classRemove = classRow + '-delete';
    $(this).parents('tr').attr('data-idObservation', classRemove);
    $(this).parents('tr').css('background', '#FFF7A4');
  });
  // BOTON DE TABLA DE OBSERVACIONES PARA CAMBIAR ESTADO DE FILAS (Para no eliminar)
  $('.tableObservations').on('click', '.btn-addObservations', function() {
    $(this).empty();
    $(this).html("<li class='fas fa-trash-alt'></li>");
    $(this).addClass('btn btn-outline-tertiary ');
    $(this).removeClass('btn-addObservations');
    $(this).removeClass('btn btn-outline-primary');
    var classRow = $(this).parents('tr').attr('data-idObservation');
    var classRemove = classRow.split('-');
    $(this).parents('tr').attr('data-idObservation', classRemove[0]);
    $(this).parents('tr').css('background', '#fff');
  });

  // CAMBIAR NOTAS EN CADENA CON DEFINITIVAS POR INTELIGENCIA Y DEFINITA FINAL
  $('.sectionsBases').on('change', '.porcentageRange', function() {
    var fatherBase = $(this).parents('tr');
    fatherBase.find('td:nth-child(3)').find('.porcentageNumber').text($(this).val() + '%');
    changeAverageIntelligence($(this).parents('tbody'));
    changeStatus($(this).val(), fatherBase.find('td:nth-child(3)').find('span:nth-child(2)'));
  });

  // EVENTO PARA CLICK EN MODAL, GUARDAR NOTAS ACTUALIZADAS Y OBSERVACIONES AGREGADAS
  $('.btn-saveDefinitive').on('click', function(e) {
    // e.preventDefault();
    var allObservations = '';
    $('input[name=rowsObservations]').val('');
    $('.tableObservations').find('tbody').find('tr').each(function() {
      var idObservation = $(this).attr('data-idObservation');
      allObservations += idObservation + '=';
    });
    $('input[name=rowsObservations]').val(allObservations);
    $(this).submit();
  });

  function changeAverageIntelligence(tbody) {
    var totalNotes = 0;
    var countNotes = 0;
    tbody.find('tr').each(function() {
      var value = $(this).find('td:nth-child(2)').find('input[type=range]').val();
      totalNotes += parseInt(value);
      countNotes++;
    });
    var averageIntelligence = totalNotes / countNotes;
    tbody.parent('table').find('thead').find('tr:nth-child(1)').find('th:last').text(averageIntelligence);
    changeAverageFinal();
  }

  function changeAverageFinal() {
    var totalEverages = 0;
    var countEverages = 0;
    $('.sectionsBases').find('.tableIntelligence').each(function() {
      var averageIntelligence = $(this).find('tr:first').find('th:last').text();
      totalEverages += parseInt(averageIntelligence);
      countEverages++;
    });
    var averageFinal = totalEverages / countEverages;
    $('.sectionsBases').find('.noteFinal').text(averageFinal);
  }

  function getAchievementsFromWeek(chId) {
    var selectedStudent = $('select[name=pcStudent] option:selected').val();
    $.get("{{ route('getAchievementFromWeek') }}", {
      chId: chId,
      selectedStudent: selectedStudent
    }, function(objectAchievements) {
      $('.sectionAchievements').each(function() {
        var countAchievement = $('.sectionAchievements').length;
        if (countAchievement > 1) {
          $('.sectionAchievements:last').remove();
        } else if (countAchievement == 1) {
          $(this).attr('id', 'achi1');
          $(this).find('.nameAChievement').val('');
          $(this).find('.nameAChievement').val('SIN LOGROS');
          $(this).find('.rangeAChievement').val('0');
          $(this).find('.rangeAChievement').attr('disabled', true);
          $(this).find('.numberRangeInput').val('0');
          $(this).find('.changeRangePrev').attr('disabled', true);
          $(this).find('.changeRangePrev').attr('readonly', true);
          $(this).find('.changeRangeNext').attr('disabled', true);
          $(this).find('.changeRangeNext').attr('readonly', true);
          $(this).find('.taStatus').removeClass('badge-secondary');
          $(this).find('.taStatus').removeClass('badge-warning');
          $(this).find('.taStatus').removeClass('badge-primary');
          $(this).find('.taStatus').removeClass('badge-success');
          $(this).find('.taStatus').addClass('badge-danger');
          $(this).find('.taStatus').text('PENDIENTE');
          $('.btnSaveAchievements').attr('disabled', true);
        }
      });
      infoAchievements = [];
      if (objectAchievements != null && objectAchievements != '') {
        var count = Object.keys(objectAchievements).length;
        for (var i = 0; i < count; i++) {
          infoAchievements.push([
            objectAchievements[i]['taId'],
            objectAchievements[i]['taWeektracking_id'],
            objectAchievements[i]['taPercentage'],
            objectAchievements[i]['taStatus'],
            objectAchievements[i]['nameAchievement']
          ]);
        }
        if (infoAchievements.length > 0) {
          for (var i = 0; i < infoAchievements.length; i++) {
            if (i == 0) {
              var father = $('.sectionAchievements:last');
              changeStatus(infoAchievements[i][2], father);
              father.find('.taId').text('');
              father.find('.taId').text(infoAchievements[i][0]);
              father.find('.nameAChievement').val('');
              father.find('.nameAChievement').val(infoAchievements[i][4]);
            } else if (i > 0) {
              var sectionAchievements = $('.sectionAchievements:last').clone();
              sectionAchievements.attr('id', 'achi' + (i + 1));
              $('.allAchievements').append(sectionAchievements);
              sectionAchievements.find('.taId').text('');
              sectionAchievements.find('.taId').text(infoAchievements[i][0]);
              var father = $('.sectionAchievements:last');
              changeStatus(infoAchievements[i][2], father);
              sectionAchievements.find('.nameAChievement').val('');
              sectionAchievements.find('.nameAChievement').val(infoAchievements[i][4]);
            }
          }
          $('.btnSaveAchievements').attr('disabled', false);
        }
      }
    });
  }

  function changeStatus(value, object) {
    if (value >= 0 && value <= 25) {
      object.removeClass('badge-secondary');
      object.removeClass('badge-warning');
      object.removeClass('badge-primary');
      object.removeClass('badge-success');
      object.addClass('badge-danger');
      object.text('PENDIENTE');
    } else if (value >= 26 && value <= 50) {
      object.removeClass('badge-danger');
      object.removeClass('badge-warning');
      object.removeClass('badge-primary');
      object.removeClass('badge-success');
      object.addClass('badge-secondary');
      object.text('INICIADO');
    } else if (value >= 51 && value <= 75) {
      object.removeClass('badge-danger');
      object.removeClass('badge-secondary');
      object.removeClass('badge-primary');
      object.removeClass('badge-success');
      object.addClass('badge-warning');
      object.text('EN PROCESO');
    } else if (value >= 76 && value <= 99) {
      object.removeClass('badge-danger');
      object.removeClass('badge-secondary');
      object.removeClass('badge-warning');
      object.removeClass('badge-success');
      object.addClass('badge-primary');
      object.text('POR TERMINAR');
    } else if (value >= 100) {
      object.removeClass('badge-danger');
      object.removeClass('badge-secondary');
      object.removeClass('badge-warning');
      object.removeClass('badge-primary');
      object.addClass('badge-success');
      object.text('COMPLETADO');
    }
  }
</script>
@endsection