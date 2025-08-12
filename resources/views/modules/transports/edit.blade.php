@extends('modules.services')

@section('services')
<div class="col-md-12">
  <h5>MODIFICACION DE TRANSPORTE: {{ $transport->traConcept }}</h5>
  <form action="{{ route('transport.update', $transport->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label>IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" name="id" value="{{ $transport->id }}" readonly required>
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="group">CONCEPTO:</label>
      <input type="text" class="form-control form-control-sm" name="traConcept" value="{{ $transport->traConcept }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $transport->traConcept }}</b></small>
    </div>
    <div class="form-group">
      <label>VALOR:</label>
      <input type="number" class="form-control form-control-sm" name="traValue" value="{{ $transport->traValue }}" required>
      <small class="form-text text-muted">La referencia actual es: <b>{{ $transport->traValue }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection