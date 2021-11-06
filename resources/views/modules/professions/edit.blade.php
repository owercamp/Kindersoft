@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <h5>MODIFICACION DE PROFESION: {{ $profession->title }}</h5>
  <form action="{{ route('profession.save', $profession->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $profession->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <label for="title">TITULO:</label>
      <input type="text" class="form-control form-control-sm" id="title" name="title" value="{{ $profession->title }}" required="required">
      <small class="form-text text-muted">La profesión actual es <b>{{ $profession->title }}</b></small>
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection