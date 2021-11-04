@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<h5>MODIFICACION DE MATERIAL ESCOLAR: {{ $supplie->supConcept }}</h5>
		<form action="{{ route('supplie.update', $supplie->id) }}" method="POST">
			@csrf
		  <div class="form-group">
		    <label>IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" name="id" value="{{ $supplie->id }}" readonly required>
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		    <label for="group">CONCEPTO:</label>
		    <input type="text" class="form-control form-control-sm" name="supConcept" value="{{ $supplie->supConcept }}" required>
		    <small class="form-text text-muted">La referencia actual es: <b>{{ $supplie->supConcept }}</b></small>
		  </div>
		   <div class="form-group">
		    <label>VALOR:</label>
		    <input type="text" class="form-control form-control-sm" name="supValue" value="{{ $supplie->supValue }}" required>
		    <small class="form-text text-muted">La referencia actual es: <b>{{ $supplie->supValue }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIO</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection