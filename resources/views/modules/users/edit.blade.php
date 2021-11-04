@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<h5>MODIFICACION DE USUARIO: <b>{{ $user->firstname }} {{ $user->lastname }}</b></h5>
		<form action="{{ route('user.save', $user->id) }}" method="PUT">
			@csrf
		  <div class="form-group">
		    <label for="id">COLABORADOR ASOCIADO A ESTE USUARIO:</label>
		    <input type="hidden" class="form-control form-control-sm" name="collaborator" value="{{ $collaborator->id }}" readonly required>
		    <input type="text" class="form-control form-control-sm" value="{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}" readonly required>
		  </div>
		  <div class="form-group">
		    <label for="id">IDENTIFICADOR:</label>
		    <input hidden type="text" class="form-control form-control-sm" id="id" name="id_old" value="{{ $user->id }}" required="required">
		    <input type="text" class="form-control form-control-sm" id="id" name="id_new" value="{{ $user->id }}" required="required">
		    <small class="form-text text-muted">Identificación del usuario, actualmente es: <b>{{ $user->id }}</b></small>
		  </div>
		  <div class="form-group">
		    <label for="firstname">NOMBRES:</label>
		    <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" value="{{ $user->firstname }}" required="required">
		    <small class="form-text text-muted">El usuario actual es <b>{{ $user->firstname }}</b></small>
		  </div>
		  <div class="form-group">
		    <label for="lastname">APELLIDOS:</label>
		    <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" value="{{ $user->lastname }}" required="required">
		    <small class="form-text text-muted">El apellido actual del usuario es <b>{{ $user->lastname }}</b></small>
		  </div>
		  <div class="form-group">
		    <label for="lastname">ROL:</label>
		    @php $rol = '' @endphp
		    @if($user->roles->implode('name',',') == '')
		    	@php $rol = 'Indefinido' @endphp
		    @else
		    	@php $rol = $user->roles->implode('name',',') @endphp
		    @endif
		    <select class="form-control form-control-sm" name="role" id="role" required="required">
		    	<option value="">SELECCIONE EL TIPO DE ACCESO...</option>
		    	<option value="Indefinido" selected="selected">Indefinido</option>
		    	 @foreach($roles as $role)
		    	 	@if($rol === $role->name)
			    		<option value="{{ $role->name }}" selected="selected">{{ $role->name }}</option>
		    	 	@else
			    		<option value="{{ $role->name }}">{{ $role->name }}</option>
		    	 	@endif
			    @endforeach
		    </select>
		    <small class="form-text text-muted">El rol actual del usuario es <b>{{ $rol }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIOS</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection