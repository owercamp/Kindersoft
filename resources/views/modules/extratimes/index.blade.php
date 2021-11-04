@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<form action="{{ route('extratime.new') }}" method="PUT">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" class="form-control my-2 form-control-sm" name="extTConcept" placeholder="Concepto" required>
								<input type="number" max="1000000" class="form-control my-2 form-control-sm" name="extTValue" placeholder="Valor" required>
							</div>
						</div>
						<div class="col-md-3 align-self-center">
							<button type="submit" class="bj-btn-table-add form-control-sm">REGISTRAR</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de tiempos extra -->
				@if(session('SuccessSaveExtratime'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveExtratime') }}
				    </div>
				@endif
				@if(session('SecondarySaveExtratime'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveExtratime') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de tiempos extra -->
				@if(session('PrimaryUpdateExtratime'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateExtratime') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateExtratime'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateExtratime') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de tiempos extra -->
				@if(session('WarningDeleteExtratime'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteExtratime') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteExtratime'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteExtratime') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tableextratimes" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>CONCEPTO</th>
					<th>VALOR</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($extratimes as $extratime)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $extratime->extTConcept }}</td>
						<td>${{ $extratime->extTValue }}</td>
						<td>
							<a href="{{ route('extratime.edit',$extratime->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>
							<!--<a href="{{ route('extratime.delete',$extratime->id) }}" title="EDITAR" class="bj-btn-table-delete edit-city" onclick="return confirm('¿Desea eliminar el concepto de tiempo extra y los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection