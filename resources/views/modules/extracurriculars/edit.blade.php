@extends('modules.services')

@section('services')
<div class="col-md-12">
  <h5>MODIFICACION DE EXTRACURRICULAR: {{ $extracurricular->extConcept }}</h5>
  <form action="{{ route('extracurricular.update', $extracurricular->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label>IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" name="id" value="{{ $extracurricular->id }}" readonly required>
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="group">CONCEPTO:</label>
      <input type="text" class="form-control form-control-sm" name="extConcept" value="{{ $extracurricular->extConcept }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $extracurricular->extConcept }}</b></small>
    </div>
    <div class="form-group">
      <label for="group">INTENSIDAD:</label>
      <input type="text" class="form-control form-control-sm" name="extIntensity" value="{{ $extracurricular->extIntensity }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $extracurricular->extIntensity }}</b></small>
    </div>
    <div class="form-group">
      <label>VALOR:</label>
      <input type="text" class="form-control form-control-sm" name="extValue" value="{{ $extracurricular->extValue }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $extracurricular->extValue }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection