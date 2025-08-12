@extends('modules.academic')

@section('academics')
<div class="col-md-12 text-center border-bottom mb-4">
  <div class="row">
    <div class="col-md-6">
      <form action="{{ route('course.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <select class="form-control my-2 form-control-sm select2" name="grade_id" required>
              <option value="">Seleccione grado...</option>
              @foreach($grades as $grade)
              <option value="{{ $grade->id }}">{{ $grade->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control my-2 form-control-sm" name="name" placeholder="Nuevo curso" required>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-outline-success my-2 form-control-sm">CREAR</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de cursos -->
      @if(session('SuccessSaveCourse'))
      <div class="alert alert-success">
        {{ session('SuccessSaveCourse') }}
      </div>
      @endif
      @if(session('SecondarySaveCourse'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveCourse') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de cursos -->
      @if(session('PrimaryUpdateCourse'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateCourse') }}
      </div>
      @endif
      @if(session('SecondaryUpdateCourse'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateCourse') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de cursos -->
      @if(session('WarningDeleteCourse'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteCourse') }}
      </div>
      @endif
      @if(session('SecondaryDeleteCourse'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteCourse') }}
      </div>
      @endif
    </div>

  </div>
  <table id="tablecourses" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>CURSO</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($courses as $course)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $course->name }}</td>
        <td><a href="{{ route('course.edit', $course->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('course.delete', $course->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('¿Desea borrar el curso?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection