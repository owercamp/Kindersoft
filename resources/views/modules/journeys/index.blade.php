@extends('modules.services')

@section('services')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<!-- Mensajes de actualizacion de jornada -->
				@if(session('PrimaryUpdateJourney'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateJourney') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateJourney'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateJourney') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de jornada -->
				@if(session('WarningDeleteJourney'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteJourney') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteJourney'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteJourney') }}
				    </div>
				@endif
			</div>
			<div class="col-md-6">
				<a href="{{ route('journey.new') }}" class="bj-btn-table-add mx-5 my-2 form-control-sm">REGISTRAR JORNADA</a>
			</div>
		</div>
		<table id="tablejourneys" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>JORNADA</th>
					<th>DIAS</th>
					<th>ENTRADA</th>
					<th>SALIDA</th>
					<th>VALOR</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($journeys as $journey)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $journey->jouJourney }}</td>
						<td>{{ $journey->jouDays }}</td>
						<td>{{ $journey->jouHourEntry }}</td>
						<td>{{ $journey->jouHourExit }}</td>
						<td>${{ $journey->jouValue }}</td>
						<td>
							<a href="{{ route('journey.edit',$journey->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>
							<!--<a href="{{ route('journey.delete',$journey->id) }}" title="EDITAR" class="bj-btn-table-delete" onclick="return confirm('¿Desea eliminar la jornada con los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection