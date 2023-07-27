@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <h5>MODIFICACION DE LOCALIDAD: {{ $location->name }}</h5>
  <form action="{{ route('location.save', $location->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $location->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <select class="form-control form-control-sm" name="city_id" id="city_id" required="required">
        <option value="">SELECCIONE UNA CIUDAD...</option>
        @php $namecity = '' @endphp
        @foreach($citys as $city)
        @if($city->id == $location->city_id)
        @php $namecity = $city->name @endphp
        <option value="{{ $city->id }}" selected="selected">{{ $city->name }}</option>
        @else
        <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endif
        @endforeach
      </select>
      @if($namecity == '')
      <small class="form-text text-muted">Actualmente la localidad pertenece a <b>{{ __('Dato vacio') }}</b></small>
      @else
      <small class="form-text text-muted">Actualmente la localidad pertenece a <b>{{ $namecity }}</b></small>
      @endif
    </div>
    <div class="form-group">
      <label for="name">NOMBRE:</label>
      <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $location->name }}" required="required">
      <small class="form-text text-muted">El nombre actual de la localidad es <b>{{ $location->name  }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection