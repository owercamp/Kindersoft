@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <h5>MODIFICACION DE PERMISO: {{ $permission->name }}</h5>
  <form action="{{ route('permission.save', $permission->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control" id="id" name="id" value="{{ $permission->id }}" disabled="disabled">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="name">TIPO:</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required="required">
      <small class="form-text text-muted">El permiso actual tiene como nombre <b>{{ $permission->name }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary ">VOLVER</a>
  </form>
</div>
@endsection