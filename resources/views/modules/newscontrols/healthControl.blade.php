@extends('modules.dailynews')

@section('logisticModules')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>MODULO DE CONTROL DE ENFERMERIA</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de enfermeria -->
      @if(session('SuccessCreateHealths'))
      <div class="alert alert-success">
        {{ session('SuccessCreateHealths') }}
      </div>
      @endif
      @if(session('SecondaryCreateHealths'))
      <div class="alert alert-secondary">
        {{ session('SecondaryCreateHealths') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de enfermeria -->
      @if(session('PrimaryUpdateHealths'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateHealths') }}
      </div>
      @endif
      @if(session('SecondaryUpdateHealths'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateHealths') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de enfermeria -->
      @if(session('WarningDeleteHealths'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteHealths') }}
      </div>
      @endif
      @if(session('SecondaryDeleteHealths'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteHealths') }}
      </div>
      @endif
      <a href="#" class="btn btn-outline-primary newFeeding-link">NUEVO CONTROL</a>
    </div>
  </div>
  <table id="tableDatatable" class="table" width="100%">
    <thead>
      <tr>
        <th>ALUMNO</th>
        <th>EDAD</th>
        <th>GRADO</th>
        <th>ACUDIENTE/S</th>
        <th>CORREO/TELEFONO</th>
        <th>NOVEDADES</th>
      </tr>
    </thead>
    <tbody>
      @for($i = 0; $i < count($result); $i++) <tr>
        <td>{{ $result[$i][1] }}</td>
        <td>{{ $result[$i][2] }}</td>
        <td>{{ $result[$i][3] }}</td>
        <td>{{ $result[$i][4] }}</td>
        <td>{{ $result[$i][5] . ' / ' . $result[$i][6] }}</td>
        <td>
          <a href="#" title="VER NOVEDADES" class="btn btn-outline-success rounded-circle seeNews-link">
            <i class="fas fa-eye"></i>
            <span hidden>{{ $datenow }}</span> <!-- Fecha -->
            <span hidden>{{ $result[$i][1] }}</span> <!-- Nombres de alumno -->
            <span hidden>{{ $result[$i][2] }}</span> <!-- Edad -->
            <span hidden>{{ $result[$i][3] }}</span> <!-- Grado -->
            <span hidden>{{ $result[$i][4] }}</span> <!-- Acudiente -->
            <span hidden>{{ $result[$i][7] }}</span> <!-- Novedades -->
            <span hidden>{{ $result[$i][0] }}</span> <!-- Legalizacion ID -->
          </a>
        </td>
        </tr>
        @endfor
    </tbody>
  </table>
</div>

<!-- Modal de detalles de novedades de esfinteres -->
<div class="modal fade" id="news-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row p-3 m-3">
          <div class="col-md-12">
            <h5 class="text-muted">NOVEDADES DE ENFERMERIA:</h5>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="row modal-body">
        <div class="col-md-12">
          <div class="row p-3 text-center">
            <div class="col-md-12">
              <input type="text" name="date-new" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row p-3 border-bottom">
                <div class="col-md-6 text-right">
                  <b style="font-size: 12px;" class="text-muted">ALUMNO:</b><br>
                  <b style="font-size: 12px;" class="text-muted">EDAD:</b><br>
                  <b style="font-size: 12px;" class="text-muted">GRADO:</b><br>
                  <b style="font-size: 12px;" class="text-muted">ACUDIENTE/S:</b><br>
                </div>
                <div class="col-md-6 text-left">
                  <b style="font-size: 12px;" class="text-muted student-new"></b><br>
                  <b style="font-size: 12px;" class="text-muted yearsold-new"></b><br>
                  <b style="font-size: 12px;" class="text-muted grade-new"></b><br>
                  <b style="font-size: 12px;" class="text-muted attendant-new"></b>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-center text-muted">NOVEDADES DE FECHA:</h6><br>
              <table class="table table-hover table-news" width="100%">
                <thead>
                  <tr>
                    <th style="max-width: 50px;">ITEM</th>
                    <th>NOVEDAD</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Campos dinámicos -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de creación de control de esfinteres -->
<div class="modal fade" id="createControl-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row p-3 m-3">
          <div class="col-md-12">
            <h5 class="text-muted">NUEVA NOVEDADES DE CONTROL DE ENFERMERIA:</h5>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="row modal-body">
        <div class="col-md-12">
          <form action="{{ route('health.newControl') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row p-3">
              <div class="col-md-3">
                <small class="text-muted">FECHA ACTUAL:</small>
                <input type="hidden" name="newControl_DateHidden" class="form-control form-control-sm text-center" value="" readonly>
                <input type="text" name="newControl_Date" class="form-control form-control-sm text-center" value="" readonly>
              </div>
              <div class="col-md-3">
                <small class="text-muted">GRADO:</small>
                <select name="newControl_Grade" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un grado...</option>
                  @foreach($grades as $grade)
                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <small class="text-muted">CURSO:</small>
                <select name="newControl_Course" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un curso...</option>
                  <!-- Campos dinamicos -->
                </select>
              </div>
              <div class="col-md-3">
                <small class="text-muted">ALUMNO:</small>
                <select name="newControl_Student" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un alumno...</option>
                  <!-- Campos dinamicos -->
                </select>
              </div>
            </div>
            <div class="row p-3">
              <div class="col-md-12">
                <small class="text-muted">DESCRIPCION DE NOVEDAD:</small>
                <textarea name="newControl_NewHealths" placeholder="ESCRIBA LA NOVEDAD DE ENFERMERIA" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-success">GUARDAR NOVEDAD</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    var date = new Date();

    var completedDate = date.getFullYear() + "-" + ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1) + "-" + date.getDate();
    $('input[name=newControl_DateHidden]').val(completedDate);
    $('input[name=newControl_Date]').val(getFormatDate(completedDate));
  });

  $('.seeNews-link').on('click', function(e) {
    e.preventDefault();
    var date = $(this).find('span:nth-child(2)').text();
    var student = $(this).find('span:nth-child(3)').text();
    var yearsold = $(this).find('span:nth-child(4)').text();
    var grade = $(this).find('span:nth-child(5)').text();
    var attendant = $(this).find('span:nth-child(6)').text();
    var news = $(this).find('span:nth-child(7)').text();
    var legalization = $(this).find('span:nth-child(8)').text();

    $('input[name=date-new]').val(getFormatDate(date));
    $('.student-new').text(student);
    $('.yearsold-new').text(yearsold);
    $('.grade-new').text(grade);
    $('.attendant-new').text(attendant);

    var separatedNews = news.split('==');

    $('.table-news tbody').empty();
    var rows = 1;
    for (var i = 0; i < separatedNews.length; i++) {
      $('.table-news tbody').append("<tr>" +
        "<td>" + rows + "</td>" +
        "<td>" + separatedNews[i] + "</td>" +
        "</tr>");
      rows++;
    }
    $('#news-modal').modal();
  });

  $('.newFeeding-link').on('click', function(e) {
    e.preventDefault();
    $('#createControl-modal').modal();
  });

  $('select[name=newControl_Grade]').on('change', function(e) {
    var grade = e.target.value;
    if (grade !== null && grade !== '') {
      // CONSULTA PARA FILTRAR CURSO DEL GRADO SELECCIONADO
      $.get("{{ route('legGradeSelected') }}", {
        selectedGrade: grade
      }, function(objectCourses) {
        var count = Object.keys(objectCourses).length //total de cursos del grado seleccionado
        $('select[name=newControl_Student]').empty();
        $('select[name=newControl_Student]').append("<option value=''>Seleccione un alumno...</option>");
        $('select[name=newControl_Course]').empty();
        $('select[name=newControl_Course]').append("<option value=''>Seleccione un curso...</option>");
        for (var i = 0; i < count; i++) {
          $('select[name=newControl_Course]').append('<option value=' + objectCourses[i]['id'] + '>' + objectCourses[i]['name'] + '</option>');
        }
      });
    } else {
      $('select[name=newControl_Course]').empty();
      $('select[name=newControl_Course]').append("<option value=''>Seleccione un curso...</option>");
      $('select[name=newControl_Student]').empty();
      $('select[name=newControl_Student]').append("<option value=''>Seleccione un alumno...</option>");
    }
  });
  $('select[name=newControl_Course]').on('change', function(e) {
    var course = e.target.value;
    var grade = $('select[name=newControl_Grade] option:selected').val();
    if (grade !== null && grade !== '' && course !== null && course !== '') {
      // CONSULTA PARA FILTRAR ALUMNOS DEL CURSO SELECCIONADO
      $.get(
        "{{ route('legCourseSelectedForList') }}", {
          selectedCourse: course,
          selectedGrade: grade
        },
        function(objectStudent) {
          var count = Object.keys(objectStudent).length //total de cursos del grado seleccionado
          $('select[name=newControl_Student]').empty();
          $('select[name=newControl_Student]').append("<option value=''>Seleccione un alumno...</option>");
          for (var i = 0; i < count; i++) {
            var nameStudent = objectStudent[i]['firstname'] + ' ' + objectStudent[i]['threename'] + ' ' + objectStudent[i]['fourname'];
            $('select[name=newControl_Student]').append('<option value=' + objectStudent[i]['id'] + '>' + nameStudent + '</option>');
          }
        }
      );
    } else {
      $('select[name=newControl_Student]').empty();
      $('select[name=newControl_Student]').append("<option value=''>Seleccione un alumno...</option>");
    }
  });

  function getFormatDate(date) {
    var day = date.substr(8, 2);
    var mount = date.substr(5, 2);
    var year = date.substr(0, 4);
    switch (mount) {
      case '01':
        return 'Enero ' + day + ' del ' + year;
        break;
      case '02':
        return 'Febrero ' + day + ' del ' + year;
        break;
      case '03':
        return 'Marzo ' + day + ' del ' + year;
        break;
      case '04':
        return 'Abril ' + day + ' del ' + year;
        break;
      case '05':
        return 'Mayo ' + day + ' del ' + year;
        break;
      case '06':
        return 'Junio ' + day + ' del ' + year;
        break;
      case '07':
        return 'Julio ' + day + ' del ' + year;
        break;
      case '08':
        return 'Agosto ' + day + ' del ' + year;
        break;
      case '09':
        return 'Septiembre ' + day + ' del ' + year;
        break;
      case '10':
        return 'Octubre' + day + ' del ' + year;
        break;
      case '11':
        return 'Noviembre ' + day + ' del ' + year;
        break;
      case '12':
        return 'Diciembre ' + day + ' del ' + year;
        break;
    }
  }
</script>
@endsection