@extends('modules.humans')

@section('humans')
<div class="col-md-12">
	<div class="row text-center border-bottom mb-4">
		<div class="col-md-6">
			<!-- Mensajes de actualizacion de acudientes -->
			@if(session('PrimaryUpdateAttendant'))
			    <div class="alert alert-primary">
			        {{ session('PrimaryUpdateAttendant') }}
			    </div>
			@endif
			@if(session('SecondaryUpdateAttendant'))
			    <div class="alert alert-secondary">
			        {{ session('SecondaryUpdateAttendant') }}
			    </div>
			@endif
			<!-- Mensajes de eliminación de acudientes -->
			@if(session('WarningDeleteAttendant'))
			    <div class="alert alert-warning">
			        {{ session('WarningDeleteAttendant') }}
			    </div>
			@endif
			@if(session('SecondaryDeleteAttendant'))
			    <div class="alert alert-secondary">
			        {{ session('SecondaryDeleteAttendant') }}
			    </div>
			@endif
		</div>
		<div class="col-md-6">
			<a href="{{ route('attendant.new') }}" class="bj-btn-table-add mx-5 my-2 form-control-sm">REGISTRAR ACUDIENTE</a>
		</div>
	</div>
	<table id="tableattendants" class="table table-hover text-center">
		<thead>
			<tr>
				<th>DOCUMENTO</th>
				<th>APELLIDOS</th>
				<th>NOMBRES</th>
				<th>GENERO</th>
				<th>TELEFONO</th>
				<th>ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			@foreach($attendants as $attendant)
				@if ($attendant->status == "ACTIVO")
					<tr>
						<td>{{ $attendant->numberdocument }}</td>
						<td>{{ $attendant->threename }}</td>
						<td>{{ $attendant->firstname }}</td>
						<td>{{ $attendant->gender }}</td>
						<td>{{ $attendant->phoneone }}</td>
						<td>
							<a href="{{ route('attendant.details', $attendant->id) }}" title="VER DETALLES" class="bj-btn-table-add"><i class="fas fa-eye"></i></a>
							<a href="{{ route('attendant.edit', $attendant->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>
							<a href="{{route('attendant.active', $attendant->id)}}" title="ACTIVO" class="bj-btn-table-add"><i class="fa fa-check-circle"></i></a>
							<!--<a href="{{ route('attendant.delete', $attendant->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('* Se eliminará el acudiente y los registro relacionados')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@else
					<tr>
						<td class="text-muted">{{ $attendant->numberdocument }}</td>
						<td class="text-muted">{{ $attendant->threename }}</td>
						<td class="text-muted">{{ $attendant->firstname }}</td>
						<td class="text-muted">{{ $attendant->gender }}</td>
						<td class="text-muted">{{ $attendant->phoneone }}</td>
						<td>
							<a href="{{ route('attendant.details', $attendant->id) }}" title="VER DETALLES" class="bj-btn-table-add"><i class="fas fa-eye"></i></a>
							<a href="{{ route('attendant.edit', $attendant->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>						
							<a href="{{route('attendant.inactive', $attendant->id)}}" title="INACTIVO" class="bj-btn-table-cancel"><i class="fa fa-ban"></i></a>
							<!--<a href="{{ route('attendant.delete', $attendant->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('* Se eliminará el acudiente y los registro relacionados')"><i class="fas fa-trash-alt"></i></a>-->
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>
@endsection