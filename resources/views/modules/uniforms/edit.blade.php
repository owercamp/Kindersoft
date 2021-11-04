@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<h5>MODIFICACION DE UNIFORME: {{ $uniform->uniConcept }}</h5>
		<form action="{{ route('uniform.update', $uniform->id) }}" method="POST">
			@csrf
		  <div class="form-group">
		    <label>IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" name="id" value="{{ $uniform->id }}" readonly required>
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		    <label for="group">CONCEPTO:</label>
		    <input type="text" class="form-control form-control-sm" name="uniConcept" value="{{ $uniform->uniConcept }}" required>
		    <small class="form-text text-muted">La referencia actual es: <b>{{ $uniform->uniConcept }}</b></small>
		  </div>
		   <div class="form-group">
		    <label>VALOR:</label>
		    <input type="text" class="form-control form-control-sm" name="uniValue" value="{{ $uniform->uniValue }}" required>
		    <small class="form-text text-muted">La referencia actual es: <b>{{ $uniform->uniValue }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIO</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection