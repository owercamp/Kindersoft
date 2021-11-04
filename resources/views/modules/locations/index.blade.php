@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<form action="{{ route('location.new') }}" method="PUT">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							  	<select class="form-control form-control-sm mx-sm-1" name="city_id" id="city_id" required>
							  		<option value="">Seleccione ciudad...</option>
							    	@foreach($citys as $city)
							    		<option value="{{ $city->id }}">{{ $city->name }}</option>
							    	@endforeach
							    </select>
				  			</div>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control form-control-sm mx-sm-1" name="name" placeholder="Nueva localidad" required>
						</div>
					</div>
					<div class="row justify-content-center">
						<button type="submit" class="bj-btn-table-add form-control-sm">CREAR</button>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de localidades -->
				@if(session('SuccessSaveLocation'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveLocation') }}
				    </div>
				@endif
				@if(session('SecondarySaveLocation'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveLocation') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de localidades -->
				@if(session('PrimaryUpdateLocation'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateLocation') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateLocation'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateLocation') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de localidades -->
				@if(session('WarningDeleteLocation'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteLocation') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteLocation'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteLocation') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tablelocations" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>LOCALIDADES</th>
					<th colspan="2">ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($locations as $location)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $location->name }}</td>
						<td><a href="{{ route('location.edit', $location->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a></td>
						<td><a href="{{ route('location.delete', $location->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('Si borra esta localidad, se eliminarán los barrios relacionados. ¿Desea borrar la localidad y sus barrios?')"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
