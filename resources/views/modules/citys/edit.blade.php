@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <h5>MODIFICACION DE CIUDAD: {{ $city->name }}</h5>
  <form action="{{ route('city.save', $city->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $city->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="name">NOMBRE:</label>
      <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $city->name }}" required="required">
      <small class="form-text text-muted">Nombre de la ciudad actual es <b>{{ $city->name }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection