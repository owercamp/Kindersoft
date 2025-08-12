@extends('modules.evaluation')

@section('academicModules')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <h3>SEGUIMIENTO SEMANAL</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de seguimientos semanales -->
      @if(session('SuccessSaveWeekTracking'))
      <div class="alert alert-success">
        {{ session('SuccessSaveWeekTracking') }}
      </div>
      @endif
      @if(session('SecondarySaveWeekTracking'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveWeekTracking') }}
      </div>
      @endif
      <!-- Mensajes de actualización de seguimientos semanales -->
      @if(session('PrimaryUpdateWeekTracking'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateWeekTracking') }}
      </div>
      @endif
      @if(session('SecondaryUpdateWeekTracking'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateWeekTracking') }}
      </div>
      @endif
      <!-- Mensajes de eliminacion de seguimientos semanalesa -->
      @if(session('WarningDeleteWeekTracking'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteWeekTracking') }}
      </div>
      @endif
      @if(session('SecondaryDeleteWeekTracking'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteWeekTracking') }}
      </div>
      @endif
      <!-- <div class="alert alert-info messages"></div> -->
    </div>
  </div>
  <form action="{{ route('weeklyTracking.new') }}" method="POST">
    @csrf
    <div class="row border-top py-2">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CURSO:</small>
          <select name="wtCourse" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un curso...</option>
            @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">PERIODO:</small>
          <select name="wtPeriod" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un periodo...</option>
            <!-- Select dinámico -->
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">DIRECTOR/A DE GRUPO:</small>
          <input type="text" name="wtCollaborator" class="form-control form-control-sm" value="" disabled required>
        </div>
        <div class="form-group">
          <small class="text-muted">GRADO:</small>
          <input type="text" name="wtGrade" class="form-control form-control-sm" value="" disabled required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">FECHA INICIAL:</small>
          <input type="text" name="wtDateInitial" class="form-control form-control-sm datepicker" disabled required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">FECHA FINAL:</small>
          <input type="text" name="wtDateFinal" class="form-control form-control-sm datepicker" disabled required>
        </div>
      </div>
    </div>
    <div class="row border-top py-3 configWeeks" style="display: none;">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">SEMANAS CON ACTIVIDADES DEL PERIODO:</small>
              <select name="wtChronological" class="form-control form-control-sm select2" required>
                <option value="">Seleccione una semana...</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">ALUMNO: </small>
              <select name="wtStudent_id" class="form-control form-control-sm select2" required>
                <option value="">Seleccione un alumno...</option>
                <!-- Options dinamicos, Apenas carga la pagina, se carga los estudiantes del curso seleccionado -->
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12 d-flex flex-column sectionsBases">
                <!-- tables dinamics -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center d-flex justify-content-center">
        <input type="hidden" name="allPorcentages" class="form-control form-control-sm" required>
        <button type="submit" class="btn btn-outline-success form-control-sm btn-save" style="display: none;">GUARDAR SEGUIMIENTO</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('.buttons').css('display', 'none');
  });

  $('.rowsAchievements').on('click', '.countAchievementAdd', function(e) {
    e.preventDefault();
    var div = $('.sectionAchievement:last').clone();
    $('.rowsAchievements').append(div);
  });

  $('.countAchievementLess').on('click', function(e) {
    e.preventDefault();
    var count = $('.sectionAchievement').length;
    if (count > 1) {
      $('.sectionAchievement:last').remove();
    }
  });

  $('select[name=wtCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    if (courseSelected != '') {
      $.get("{{ route('getInfoCourseConsolidated') }}", {
        courseSelected: courseSelected
      }, function(objectInfo) {
        if (objectInfo != null && objectInfo != '') {
          $('input[name=wtGrade]').val('');
          $('input[name=wtGrade]').val(objectInfo['nameGrade']);
          $('input[name=wtCollaborator]').val('');
          $('input[name=wtCollaborator]').val(objectInfo['nameCollaborator']);

          $.get("{{ route('getAcademicPeriodsCourse') }}", {
            courseSelected: courseSelected
          }, function(objectPeriods) {
            if (objectPeriods != null && objectPeriods != '') {
              var count = Object.keys(objectPeriods).length //total de periodos existentes del curso
              $('select[name=wtPeriod]').empty();
              $('select[name=wtPeriod]').append("<option value=''>Seleccione un periodo...</option>");
              for (var i = 0; i < count; i++) {
                $('select[name=wtPeriod]').append('<option value=' + objectPeriods[i]['apId'] + '>' + objectPeriods[i]['apNameperiod'] + '</option>');
              }
            }
          });
          //LLENAR SELECT DE LOS ESTUDIANTES DEL CURSO SELECCIONADO
          $.get("{{ route('getStudentCourseSelected') }}", {
            courseSelected: courseSelected
          }, function(objectStudent) {
            if (objectStudent != null && objectStudent != '') {
              var count = Object.keys(objectStudent).length //total de periodos existentes del curso
              $('select[name=wtStudent_id]').empty();
              $('select[name=wtStudent_id]').append("<option value=''>Seleccione un alumno...</option>");
              for (var i = 0; i < count; i++) {
                $('select[name=wtStudent_id]').append('<option value=' + objectStudent[i]['idStudent'] + '>' + objectStudent[i]['nameStudent'] + '</option>');
              }
            }
          });
        }
      });
    } else {
      $('input[name=wtGrade]').val('');
      $('input[name=wtCollaborator-hidden]').val('');
      $('input[name=wtCollaborator]').val('');
      $('select[name=wtPeriod]').empty();
      $('select[name=wtPeriod]').append("<option value=''>Seleccione un periodo...</option>");
      $('select[name=wtStudent_id]').empty();
      $('select[name=wtStudent_id]').append("<option value=''>Seleccione un alumno...</option>");
    }
  });

  $('select[name=wtPeriod]').on('change', function(e) {
    var periodSelected = e.target.value;
    var courseSelected = $('select[name=wtCourse] option:selected').val();
    $('input[name=wtDateInitial]').val('');
    $('input[name=wtDateFinal]').val('');
    $('select[name=wtChronological]').empty();
    $('select[name=wtChronological]').append("<option value=''>Seleccione una semana...</option>");
    $('.configWeeks').css('display', 'none');
    if (periodSelected != '' && courseSelected != '') {
      $.get("{{ route('getRangePeriod') }}", {
        periodSelected: periodSelected
      }, function(objectDates) {
        if (objectDates != null && objectDates != '') {
          $('input[name=wtDateInitial]').val(objectDates['apDateInitial']);
          $('input[name=wtDateFinal]').val(objectDates['apDateFinal']);
          //LLENAR SELECT DE LAS SEMANAS DEL PERIODO Y EL ID DE LA TABLA CRONOLOGICA						
          $.get("{{ route('getRangeWeek') }}", {
            periodSelected: periodSelected,
            courseSelected: courseSelected
          }, function(objectWeek) {
            var count = Object.keys(objectWeek).length;
            if (count > 0) {
              for (var i = 0; i < count; i++) {
                var separatedRange = objectWeek[i][1].split('/');
                $('select[name=wtChronological]').append('<option value=' + objectWeek[i][0] + '>SEMANA ' + objectWeek[i][0] + ' - DE ' + separatedRange[0] + ' A ' + separatedRange[1] + '</option>');
              }
            }
            $('.configWeeks').css('display', 'block');
          });
        }
      });
    }
  });

  $('select[name=wtIntelligence_id]').on('change', function(e) {
    var intelligenceSelected = e.target.value;
    if (intelligenceSelected != '') {
      $.get("{{ route('getDescriptionIntelligence') }}", {
        intelligenceSelected: intelligenceSelected
      }, function(objectDescription) {
        if (objectDescription != null && objectDescription != '') {
          $('textarea[name=wtIntelligenceDescription]').val('');
          $('textarea[name=wtIntelligenceDescription]').val(objectDescription['description']);
        }
      });
      $.get("{{ route('getAchievement') }}", {
        intelligenceSelected: intelligenceSelected
      }, function(objectAchievement) {
        if (objectAchievement != null && objectAchievement != '') {
          var count = Object.keys(objectAchievement).length //total de periodos existentes del curso
          $('.wtAchievement_id').empty();
          $('.wtAchievement_id').append("<option value=''>Seleccione un logro...</option>");
          if (count >= 0) {
            for (var i = 0; i < count; i++) {
              $('.wtAchievement_id').append('<option value=' + objectAchievement[i]['id'] + '>' + objectAchievement[i]['name'] + '</option>');
            }
            $('.buttons').css('display', 'block');
          } else {
            $('.buttons').css('display', 'none');
            $('.wtAchievement_id').empty();
            $('.wtAchievement_id').append("<option value=''>Seleccione un logro...</option>");
          }
        } else {
          $('.buttons').css('display', 'none');
          $('.wtAchievement_id').empty();
          $('.wtAchievement_id').append("<option value=''>Seleccione un logro...</option>");
        }
      });
    } else {
      $('.wtAchievement_id').empty();
      $('.wtAchievement_id').append("<option value=''>Seleccione un logro...</option>");
      $('.buttons').css('display', 'none');
    }
  });

  $('select[name=wtStudent_id]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $('.btn-save').css('display', 'block');
    } else {
      $('.btn-save').css('display', 'none');
    }
  });

  // EVENTOS DE ACTUALIZACIÖN 23/Marzo/2020

  $('select[name=wtChronological]').on('change', function(e) {
    var numberWeek = e.target.value;
    var courseSelected = $('select[name=wtCourse] option:selected').val();
    var periodSelected = $('select[name=wtPeriod] option:selected').val();
    // $('.sectionsBases').empty();
    // $('.sectionsBases .sectionItem').length;
    var countSections = 1;
    $('.sectionsBases').empty();
    $('.sectionsBases').css('display', 'none');
    if (numberWeek != '' && courseSelected != '' && periodSelected != '') {
      $.get("{{ route('getBasesFromWeek') }}", {
        numberWeek: numberWeek,
        periodSelected: periodSelected,
        courseSelected: courseSelected
      }, function(objectBases) {
        var count = Object.keys(objectBases).length;
        if (count > 0) {
          var idIn = [];
          var contentAll = '';
          for (var i = 0; i < count; i++) {
            idIn.push(objectBases[i][0]);
            var contentItem = '';

            for (var m = 0; m < objectBases[i][2].length; m++) {
              contentItem += "<tr id='" + objectBases[i][2][m][0] + "' class='" + objectBases[i][0] + "'>" +
                "<td>" +
                objectBases[i][2][m][1] +
                "<br>" +
                "<input type='range' class='form-control form-control-sm progress-bar progress-bar-striped bg-warning ml-2 porcentageLeft' value='0' min='0' max='100' step='1' style='font-weight: bold; font-size: 20px;'>" +
                "</td>" +
                "<td style='max-width: 200px;'>" +
                "<select class='form-control form-control-sm select2 mt-4 selectAchievement' data-intelligence='" + objectBases[i][0] + "' required>" +
                "<option value=''>Asigne un logro a la actividad...</option>" +
                "</select>" +
                "</td>" +
                "<td style='max-width: 100px;'>" +
                "<span class='porcentageRight' style='color: #000; font-weight: bold;'>0%</span>" +
                "<span class='form-control form-control-sm badge badge-danger' style='color: #fff; font-weight: bold;'>PENDIENTE</span>" +
                "</td>" +
                "</tr>";
            }
            contentAll += "<table class='table text-center my-4 tableIntelligence' width='100%' style='background-color: #ccc'>" +
              "<thead>" +
              "<tr>" +
              "<th colspan='3'><h5>" + objectBases[i][1] + "</h5></th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>" +
              contentItem +
              "</tbody>" +
              "</table>";
          }
          if (idIn.length > 0) {
            for (var index = 0; index < idIn.length; index++) {
              getAchievements(idIn[index]);
            }
          }
          $('.sectionsBases').append(contentAll);
          $('.sectionsBases').css('display', 'flex');
        }
      });
    }
  });

  $('.sectionsBases').on('change', '.porcentageLeft', function() {
    var fatherBase = $(this).parents('tr');
    fatherBase.find('td:nth-child(3)').find('.porcentageRight').text($(this).val() + '%');
    changeStatus($(this).val(), fatherBase.find('td:nth-child(3)').find('span:nth-child(2)'));
  });

  $('.btn-save').on('click', function() {
    // e.preventDefault();
    var allPorcentages = '';
    $('.sectionsBases .tableIntelligence').each(function() {
      $(this).find('tbody').find('tr').each(function() {
        var baId = $(this).attr('id');
        var inId = $(this).attr('class');
        var achId = $(this).find('td:nth-child(2)').find('select').val();
        var note = $(this).find('td:nth-child(3)').find('span:nth-child(1)').text();
        var status = $(this).find('td:nth-child(3)').find('span:nth-child(2)').text();
        allPorcentages += baId + ':' + inId + ':' + achId + ':' + note + ':' + status + '=';
      });
    });
    $('input[name=allPorcentages]').val(allPorcentages);
    $(this).submit();
  });

  // LLENAR SELECT DE LOS LOGROS DE ACUERDO A SU INTELIGENCIA CORRESPONDIENTE
  function getAchievements(idIntelligence) {
    $.get("{{ route('getAchievement') }}", {
      intelligenceSelected: idIntelligence
    }, function(objectAchievement) {
      var countAchievement = Object.keys(objectAchievement).length;
      if (countAchievement > 0) {
        for (var a = 0; a < countAchievement; a++) {
          // options += "<option value='" + objectAchievement[a]['id'] + "'>" + objectAchievement[a]['name'] + "</option>";
          $("select[data-intelligence=" + idIntelligence + "]").append(
            "<option value='" + objectAchievement[a]['id'] + "'>" + objectAchievement[a]['name'] + "</option>"
          );
        }
        // select = "<select class='form-control form-control-sm select2 selectAchievement' required>" +
        // 				"<option value=''>Asigne un logro a la actividad...</option>" +
        // 					options +
        // 			"</select>";
      }
    });
  }

  function changeStatus(value, note) {
    if (value >= 0 && value <= 25) {
      note.removeClass('badge-secondary');
      note.removeClass('badge-warning');
      note.removeClass('badge-primary');
      note.removeClass('badge-success');
      note.addClass('badge-danger');
      note.text('PENDIENTE');
    } else if (value >= 26 && value <= 50) {
      note.removeClass('badge-danger');
      note.removeClass('badge-warning');
      note.removeClass('badge-primary');
      note.removeClass('badge-success');
      note.addClass('badge-secondary');
      note.text('INICIADO');
    } else if (value >= 51 && value <= 75) {
      note.removeClass('badge-danger');
      note.removeClass('badge-secondary');
      note.removeClass('badge-primary');
      note.removeClass('badge-success');
      note.addClass('badge-warning');
      note.text('EN PROCESO');
    } else if (value >= 76 && value <= 99) {
      note.removeClass('badge-danger');
      note.removeClass('badge-secondary');
      note.removeClass('badge-warning');
      note.removeClass('badge-success');
      note.addClass('badge-primary');
      note.text('POR TERMINAR');
    } else if (value >= 100) {
      note.removeClass('badge-danger');
      note.removeClass('badge-secondary');
      note.removeClass('badge-warning');
      note.removeClass('badge-primary');
      note.addClass('badge-success');
      note.text('COMPLETADO');
    }
  }
</script>
@endsection