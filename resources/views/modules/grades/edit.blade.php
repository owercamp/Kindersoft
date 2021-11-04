@extends('modules.academic')

@section('academics')
	<div class="col-md-12">
		<h5>MODIFICACION DE GRADO: {{ $grade->name }}</h5>
		<form action="{{ route('grade.save', $grade->id) }}" method="PUT">
			@csrf
		  <div class="form-group">
		    <label for="id">IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $grade->id }}" disabled="disabled" required="required">
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		    <label for="name">NOMBRE:</label>
		    <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $grade->name }}" required="required">
		    <small class="form-text text-muted">El nombre actual del grado es <b>{{ $grade->name }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIO</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection