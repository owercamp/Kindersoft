@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <h5>MODIFICACION DE DOCUMENTO: {{ $document->type }}</h5>
  <form action="{{ route('document.save', $document->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $document->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="type">TIPO:</label>
      <input type="text" class="form-control form-control-sm" id="type" name="type" value="{{ $document->type }}" required="required">
      <small class="form-text text-muted">El documento actual es <b>{{ $document->type }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection