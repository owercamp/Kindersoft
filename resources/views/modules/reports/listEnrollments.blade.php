@extends('modules.reports')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>LISTADO DE MATRICULADOS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de listado de matriculados -->
      @if(session('SuccessSaveList'))
      <div class="alert alert-success">
        {{ session('SuccessSaveList') }}
      </div>
      @endif
      @if(session('SecondarySaveList'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveList') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">CURSO:</small>
        <select name="leCourse" class="form-control form-control-sm" required>
          <option value=""></option>
          @foreach($courses as $course)
          <option value="{{ $course->id }}">{{ $course->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">ALUMNO:</small>
        <select name="leStudent" class="form-control form-control-sm" required>
          <!-- Dinamics -->
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <button type="button" class="btn btn-outline-primary form-control-sm btn-addStudent">AGREGAR ALUMNO</button>
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover mt-3 tbl-reportStudents" width="100%" style="text-align: center;">
    <thead>
      <th>ID</th>
      <th>ALUMNO</th>
      <th>DOCUMENTO</th>
      <th>FECHA DE NACIMIENTO</th>
      <th>EDAD ACTUAL</th>
      <th>GRADO</th>
    </thead>
    <tbody>
      <!-- Filas dinamicas -->
    </tbody>
  </table>
  <div class="row section-btnExcel" style="display: none;">
    <div class="col-md-12 text-right">
      <form action="{{ route('listStudentExcel') }}" method="GET">
        @csrf
        <input type="hidden" name="idsExcel" class="form-control form-control-sm" readonly required>
        <button type="submit" class="btn btn-outline-success form-control-sm btn-excel">EXPORTAR A EXCEL</button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function converterYearsoldFromBirtdate(date) {
    var values = date.split("-");
    var day = values[2];
    var mount = values[1];
    var year = values[0];
    var now = new Date();
    var yearNow = now.getYear()
    var mountNow = now.getMonth() + 1;
    var dayNow = now.getDate();
    //Cálculo de años
    var old = (yearNow + 1900) - year;
    if (mountNow < mount) {
      old--;
    }
    if ((mount == mountNow) && (dayNow < day)) {
      old--;
    }
    if (old > 1900) {
      old -= 1900;
    }
    //Cálculo de meses
    var mounts = 0;
    if (mountNow > mount && day > dayNow) {
      mounts = (mountNow - mount) - 1;
    } else if (mountNow > mount) {
      mounts = mountNow - mount;
    } else if (mountNow < mount && day < dayNow) {
      mounts = 12 - (mount - mountNow);
    } else if (mountNow < mount) {
      mounts = 12 - (mount - mountNow + 1);
    }
    if (mountNow == mount && day > dayNow) {
      mounts = 11;
    }
    //Cálculo de dias
    var days = 0;
    if (dayNow > day) {
      days = dayNow - day
    }
    if (dayNow < day) {
      lastDayMount = new Date(yearNow, mountNow - 1, 0);
      days = lastDayMount.getDate() - (day - dayNow);
    }
    var processed = parseInt(old) + '-' + parseInt(mounts);
    return processed;
    // days ==> Opcional para mostrar dias también
  }

  function getYearsold(yearsold) {
    var len = yearsold.length;
    if (len < 5 & len > 0) {
      var separated = yearsold.split('-');
      return separated[0] + ' años ' + separated[1] + ' meses';
    } else {
      return yearsold;
    }
  }

  $(function() {

  });

  $('select[name=leCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    if (courseSelected != '') {
      $.get("{{ route('getStudentFromCourseWithEnrollment') }}", {
        courseSelected: courseSelected
      }, function(objectStudents) {
        var count = Object.keys(objectStudents).length;
        $('select[name=leStudent]').empty();
        $('select[name=leStudent]').append("<option value=''>Seleccione un alumno...</option>");
        for (var i = 0; i < count; i++) {
          $('select[name=leStudent]').append('<option value=' + objectStudents[i][0] + '>' + objectStudents[i][1] + '</option>');
        }
      });
    } else {
      //VACIAR CAMPOS DEL FORMULARIO
      $('select[name=leStudent]').empty();
      $('select[name=leStudent]').append("<option value=''>Seleccione un alumno...</option>");
    }
  });

  $('.btn-addStudent').on('click', function() {
    var course = $('select[name=leCourse]').val();
    var student = $('select[name=leStudent]').val();
    if (course != '' && student != '') {
      $.get("{{ route('getRowStudent') }}", {
        student: student
      }, function(objectRow) {
        if (objectRow != null) {
          var count = ($('.tbl-reportStudents tbody tr').length + 1);
          var again = false;
          $('.tbl-reportStudents tbody tr').each(function() {
            var validate = $(this).attr('id');
            if (validate == objectRow['idStudent']) {
              again = true;
            }
          });
          if (!again) {
            var rownow = $('.tbl-reportStudents').DataTable().row;
            rownow.add(
              [
                objectRow['idStudent'],
                objectRow['nameStudent'],
                objectRow['numberdocument'],
                objectRow['birthdate'],
                getYearsold(converterYearsoldFromBirtdate(objectRow['birthdate'])), // Calculo de la edad actualizada
                objectRow['nameGrade'],
                "<a href='#' class='btn btn-outline-tertiary  form-control-sm remove-link' title='ELIMINAR FILA'><i class='fas fa-trash-alt'></i></a>"
              ]).draw(false).node().id = objectRow['idStudent'];
          }
        }
        validateTable();
      });
    }
  });

  $('.tbl-reportStudents').on('click', '.remove-link', function(e) {
    e.preventDefault();
    var idSelf = $(this).parents('tr').attr('id');
    var row = 0;
    var rowValidate = 0;
    $('.tbl-reportStudents tbody tr').each(function() {
      if ($(this).attr('id') == idSelf) {
        rowValidate = row;
      }
      row++;
    });
    $('.tbl-reportStudents').DataTable().row(':eq(' + rowValidate + ')').remove().draw();
    // $(this).parents('tr').remove();
    validateTable();
  });

  function validateTable() {
    var count = $('.tbl-reportStudents tbody tr').length;
    if (count >= 1) {
      $('.section-btnExcel').css('display', 'block');
    } else {
      $('.section-btnExcel').css('display', 'none');
    }
  }

  $('.btn-excel').on('click', function() {
    var allRow = '';
    $('input[name=idsExcel]').val('');
    $('.tbl-reportStudents tbody tr').each(function() {
      var idStudent = $(this).attr('id');
      allRow += idStudent + ':';
    });
    if (allRow != '') {
      $('input[name=idsExcel]').val(allRow);
      $(this).submit();
    }
  });
</script>
@endsection