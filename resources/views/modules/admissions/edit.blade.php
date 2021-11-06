@extends('modules.services')

@section('services')
<div class="col-md-12">
  <h5>MODIFICACION DE ADMISION: {{ $admission->admConcept }}</h5>
  <form action="{{ route('admission.update', $admission->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label>IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" name="id" value="{{ $admission->id }}" readonly required>
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="group">CONCEPTO:</label>
      <input type="text" class="form-control form-control-sm" name="admConcept" value="{{ $admission->admConcept }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $admission->admConcept }}</b></small>
    </div>
    <div class="form-group">
      <label>VALOR:</label>
      <input type="number" class="form-control form-control-sm" name="admValue" value="{{ $admission->admValue }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $admission->admValue }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection