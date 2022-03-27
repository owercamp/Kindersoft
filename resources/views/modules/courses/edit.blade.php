@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <h5>MODIFICACION DE CURSO: {{ $course->name }}</h5>
  <form action="{{ route('course.save', $course->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $course->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <select class="form-control form-control-sm select2" name="grade_id" id="grade_id" required="required">
        <option value="">SELECCIONE UN GRADO...</option>
        @php $namegrade = '' @endphp
        @foreach($grades as $grade)
        @if($grade->id == $course->grade_id)
        @php $namegrade = $grade->name @endphp
        <option value="{{ $grade->id }}" selected="selected">{{ $grade->name }}</option>
        @else
        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
        @endif
        @endforeach
      </select>
      <small class="form-text text-muted">El curso pertenece al grado <b>{{ $namegrade }}</b></small>
    </div>
    <div class="form-group">
      <label for="name">NOMBRE:</label>
      <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $course->name }}" required="required">
      <small class="form-text text-muted">El nombre actual del curso es <b>{{ $course->name }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection