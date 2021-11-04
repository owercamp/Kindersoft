@extends('modules.academic')

@section('academics')
	<div class="col-md-12">
		<h5>MODIFICACION DE INTELIGENCIA: {{ $intelligence->type }}</h5>
		<form action="{{ route('intelligence.save', $intelligence->id) }}" method="PUT">
			@csrf
		  <div class="form-group">
		    <label for="id">IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $intelligence->id }}" disabled="disabled" required="required">
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		    <label for="type">NOMBRE:</label>
		    <input type="text" class="form-control form-control-sm" id="type" name="type" value="{{ $intelligence->type }}" required="required">
		  	<small class="form-text text-muted">La inteligencia actual es <b>{{ $intelligence->type }}</b></small>
		  </div>
		  <div class="form-group">
		    <label for="description">DESCRIPCION:</label>
		    <input type="text" class="form-control form-control-sm" id="description" name="description" value="{{ $intelligence->description }}" required="required">
		  	<small class="form-text text-muted">La descripcion de la inteligencia actual es <b>{{ $intelligence->description }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIO</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection