@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <h5>MODIFICACION DE LOGRO: {{ $achievement->description }}</h5>
  <form action="{{ route('achievement.save', $achievement->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $achievement->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <select class="form-control form-control-sm" name="intelligence_id" id="intelligence_id" required="required">
        <option value="">SELECCIONE UNA INTELIGENCIA...</option>
        @php $nameintelligence = '' @endphp
        @foreach($intelligences as $intelligence)
        @if($intelligence->id == $achievement->intelligence_id)
        @php $nameintelligence = $intelligence->type @endphp
        <option value="{{ $intelligence->id }}" selected>{{ $intelligence->type }}</option>
        @else
        <option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
        @endif
        @endforeach
      </select>
      <small class="form-text text-muted">La inteligencia actual de este logro es <b>{{ $nameintelligence }}</b></small>
    </div>
    <div class="form-group">
      <label for="name">NOMBRE:</label>
      <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $achievement->name }}" required="required">
      <small class="form-text text-muted">La nombre actual de este logro es <b>{{ $achievement->name }}</b></small>
    </div>
    <div class="form-group">
      <label for="description">DESCRIPCION:</label>
      <input type="text" class="form-control form-control-sm" id="description" name="description" value="{{ $achievement->description }}" required="required">
      <small class="form-text text-muted">La descripcion actual de este logro es <b>{{ $achievement->description }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary text-white form-control-sm">VOLVER</a>
  </form>
</div>
@endsection