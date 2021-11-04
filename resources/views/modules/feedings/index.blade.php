@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<form action="{{ route('feeding.new') }}" method="PUT">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" class="form-control my-2 form-control-sm" name="feeConcept" placeholder="Concepto" required>
								<input type="number" max="1000000" class="form-control my-2 form-control-sm" name="feeValue" placeholder="Valor" required>
							</div>
						</div>
						<div class="col-md-3 align-self-center">
							<button type="submit" class="bj-btn-table-add form-control-sm">REGISTRAR</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de alimentaciones -->
				@if(session('SuccessSaveFeeding'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveFeeding') }}
				    </div>
				@endif
				@if(session('SecondarySaveFeeding'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveFeeding') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de alimentaciones -->
				@if(session('PrimaryUpdateFeeding'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateFeeding') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateFeeding'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateFeeding') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de alimentaciones -->
				@if(session('WarningDeleteFeeding'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteFeeding') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteFeeding'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteFeeding') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tablefeedings" class="table table-hover text-center" width="100%">
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
				@foreach($feedings as $feeding)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $feeding->feeConcept }}</td>
						<td>${{ $feeding->feeValue }}</td>
						<td>
							<a href="{{ route('feeding.edit',$feeding->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>
							<!--<a href="{{ route('feeding.delete',$feeding->id) }}" title="EDITAR" class="bj-btn-table-delete edit-city" onclick="return confirm('¿Desea eliminar el concepto de alimentación con los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection