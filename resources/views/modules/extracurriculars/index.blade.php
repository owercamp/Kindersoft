@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<form action="{{ route('extracurricular.new') }}" method="PUT">
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control my-2 form-control-sm" name="extConcept" placeholder="Concepto" required>
						</div>
						<div class="col-md-6">
							<input type="text" max="100" min="1" class="form-control my-2 form-control-sm" name="extIntensity" placeholder="Intensidad" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input type="number" max="1000000" class="form-control my-2 form-control-sm" name="extValue" placeholder="Valor" required>
						</div>
						<div class="col-md-6 align-self-center">
							<button type="submit" class="bj-btn-table-add form-control-sm">REGISTRAR</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de extracurriculares -->
				@if(session('SuccessSaveExtracurricular'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveExtracurricular') }}
				    </div>
				@endif
				@if(session('SecondarySaveExtracurricular'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveExtracurricular') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de extracurriculares -->
				@if(session('PrimaryUpdateExtracurricular'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateExtracurricular') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateExtracurricular'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateExtracurricular') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de extracurriculares -->
				@if(session('WarningDeleteExtracurricular'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteExtracurricular') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteExtracurricular'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteExtracurricular') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tableextracurriculars" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>CONCEPTO</th>
					<th>INTENSIDAD</th>
					<th>VALOR</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($extracurriculars as $extracurricular)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $extracurricular->extConcept }}</td>
						<td>{{ $extracurricular->extIntensity }}</td>
						<td>${{ $extracurricular->extValue }}</td>
						<td>
							<a href="{{ route('extracurricular.edit',$extracurricular->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>
							<!--<a href="{{ route('extracurricular.delete',$extracurricular->id) }}" title="EDITAR" class="bj-btn-table-delete edit-city" onclick="return confirm('¿Desea eliminar el concepto de extracurricular y los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection