@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<h5>MODIFICACION DE GRUPO SANGUINEO: {{ $health->entity }} , DE TIPO: {{ $health->type }}</h5>
		<form action="{{ route('health.save', $health->id) }}" method="PUT">
			@csrf
		  <div class="form-group">
		    <label for="id">IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $health->id }}" disabled="disabled" required="required">
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		    <label for="group">ENTIDAD:</label>
		    <input type="text" class="form-control form-control-sm" id="entity" name="entity" value="{{ $health->entity }}" required="required">
		    <small class="form-text text-muted">El centro de salud actual es: <b>{{ $health->entity }}</b></small>
		  </div>
		   <div class="form-group">
		    <label for="type">TIPO DE AFILIACION:</label>
		    <input type="hidden" id="type_hidden" value="{{ $health->type }}">
		    <select class="form-control form-control-sm" id="type" name="type" required="required">
		    	<option value="">SELECCIONE TIPO DE AFILIACION...</option>
		    	<option value="EPS">EPS</option>
		    	<option value="PREPAGADA">PREPAGADA</option>
		    </select>
		    <small class="form-text text-muted">Actualmente <b>{{ $health->entity }}</b> es de tipo: <b>{{ $health->type }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIO</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
			var valueType = $('#type_hidden').val();
			$("#type option[value="+ valueType +"]").attr("selected",true);
		});
	</script>
@endsection