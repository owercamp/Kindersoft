@extends('modules.services')

@section('services')
<div class="col-md-12">
  <h5>MODIFICACION DE ALIMENTACION: {{ $feeding->feeConcept }}</h5>
  <form action="{{ route('feeding.update', $feeding->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label>IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" name="id" value="{{ $feeding->id }}" readonly required>
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="group">CONCEPTO:</label>
      <input type="text" class="form-control form-control-sm" name="feeConcept" value="{{ $feeding->feeConcept }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $feeding->feeConcept }}</b></small>
    </div>
    <div class="form-group">
      <label>VALOR:</label>
      <input type="text" class="form-control form-control-sm" name="feeValue" value="{{ $feeding->feeValue }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $feeding->feeValue }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection