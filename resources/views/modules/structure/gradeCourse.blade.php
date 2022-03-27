@extends('modules.structure')

@section('academicModules')
<div class="col-md-12">
  <div class="row mb-3 border-bottom">
    <div class="col-md-6 form-inline">
      <h3>GRADOS Y CURSOS <span><a href="#" title="ESTE FORMULARIO ASIGNARA UN DIRECTOR DE GRUPO A LOS ALUMNOS MATRICULADOS EN EL GRADO Y CURSO QUE SELECCIONE"><i class="fas fa-question-circle"></i></a></span></h3>
      <a href="{{ route('listgradeCourse') }}" class="btn btn-outline-primary mx-4 form-control-sm">VER LISTADOS</a>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de los grados y cursos -->
      @if(session('SuccessSaveGradecourse'))
      <div class="alert alert-success">
        {{ session('SuccessSaveGradecourse') }}
      </div>
      @endif
      @if(session('SecondarySaveGradecourse'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveGradecourse') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de los grados y cursos -->
      @if(session('PrimaryUpdateGradecourse'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateGradecourse') }}
      </div>
      @endif
      @if(session('SecondaryUpdateGradecourse'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateGradecourse') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de los grados y cursos -->
      @if(session('WarningDeleteGradecourse'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteGradecourse') }}
      </div>
      @endif
      @if(session('SecondaryDeleteGradecourse'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteGradecourse') }}
      </div>
      @endif
    </div>
  </div>
  <form action="{{ route('gradeCourse.save') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">GRADO:</small>
          <select name="ccGrade" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un grado...</option>
            @foreach($grades as $grade)
            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">CURSO:</small>
          <select name="ccCourse" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un curso...</option>
            <!-- Select dinamico con la seleccion del grado -->
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">FECHA INICIAL:</small>
          <input type="text" name="ccDateInitial" class="form-control form-control-sm datepicker" required>
        </div>
        <div class="form-group">
          <small class="text-muted">FECHA FINAL:</small>
          <input type="text" name="ccDateFinal" class="form-control form-control-sm datepicker" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">DIRECTOR/A DE GRUPO:</small>
          <select name="ccCollaborator" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un colaborador...</option>
            @foreach($collaborators as $collaborator)
            <option value="{{ $collaborator->id }}">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-outline-success form-control-sm mt-4">ESTABLECER GRUPO</button>
        </div>
      </div>
    </div>
  </form>
  <div class="row border-top sectionlist">
    <div class="col-md-12">
      <h4 class="ml-4 mt-3"><b>LISTADO: </b> TOTAL DE ALUMNOS MATRICULADOS: <b class="totalStudents badge badge-success">0</b></h4>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });

  $('select[name=ccGrade]').on('change', function(e) {
    var selectedGrade = e.target.value;
    if (selectedGrade != '') {
      $.get("{{ route('legGradeSelected') }}", {
        selectedGrade: selectedGrade
      }, function(objectCourses) {
        var count = Object.keys(objectCourses).length //total de cursos del grado seleccionado
        $('.totalStudents').text('0');
        $('select[name=ccCourse]').empty();
        $('select[name=ccCourse]').append("<option value=''>Seleccione un curso...</option>");
        for (var i = 0; i < count; i++) {
          $('select[name=ccCourse]').append('<option value=' + objectCourses[i]['id'] + '>' + objectCourses[i]['name'] + '</option>');
        }
      });
    } else {
      $('select[name=ccCourse]').empty();
      $('select[name=ccCourse]').append("<option value=''>Seleccione un curso...</option>");
    }
  });

  $('select[name=ccCourse]').on('change', function(e) {
    var selectedCourse = e.target.value;
    if (selectedCourse != '') {
      $.get("{{ route('getCountStudent') }}", {
        selectedCourse: selectedCourse
      }, function(objectCountCourses) {
        if (objectCountCourses != null && objectCountCourses != '') {
          $('.totalStudents').text('0');
          $('.totalStudents').text(objectCountCourses);
        } else {
          $('.totalStudents').text('0');
        }
      });
    } else {
      $('.totalStudents').text('0');
    }
  });
</script>
@endsection