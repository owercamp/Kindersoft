@extends('modules.database')

@section('databases')
<!-- Plantilla provisional, No es necesaria ya que los grupos sanguineos viene predeterminados en los select para ingresarlos a la base de datos los cuales tienen campos ENUM en la base de datos solo para ingresar opcion limitadas correctas-->
<div class="col-md-12">
  <h5>MODIFICACION DE GRUPO SANGUINEO: {{ $bloodtype->group }} {{ $bloodtype->type }}</h5>
  <form action="{{ route('bloodtype.save', $bloodtype->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $bloodtype->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="group">TIPO:</label>
      <input type="text" class="form-control form-control-sm" id="group" name="group" value="{{ $bloodtype->group }}" required="required">
      <small class="form-text text-muted">La referencia actual es: {{ $bloodtype->group }}</small>
    </div>
    <div class="form-group">
      <label for="type">TIPO:</label>
      <input type="text" class="form-control form-control-sm" id="type" name="type" value="{{ $bloodtype->type }}" required="required">
      <small class="form-text text-muted">La referencia actual es: {{ $bloodtype->type }}</small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection